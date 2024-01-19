<?php

namespace App\Http\Controllers;

use App\Models\GaleryPage;
use App\Models\LogUser;
use App\Models\Page;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class PageController extends Controller
{
    public function index(Request $request) {
        $model = Page::with('users');

        if(isset($request->status)){
            $model->where('is_status', $request->status);
        }
        if(isset($request->search)){
            $model->where('title', 'like', '%' . $request->search . '%');
        }
        $model->orderBy('is_status', 'DESC')->orderBy('publish_at', 'DESC');
        $result = $model->paginate(10);

        return view('page.page.index', ['list' => $result]);
    }

    public function create(Request $request) {
        $to = $request->to ?? 1;
        return view('page.page.create', ['to' => $to]);
    }

    public function store(Request $request)
    {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        // $img = str_replace($url, "", $request->picture);

        try {
            $payload = [
                "title" => $request->title,
                "title_en" => $request->title_en,
                "short_description" => $request->short_description,
                "short_description_en" => $request->short_description_en,
                "short_content" => $request->short_content,
                "short_content_en" => $request->short_content_en,
                "content" => $request->content,
                "content_en" => $request->content_en,
                "is_status" => $request->is_status,
                "publish_at" => $request->is_status == 2 ? date("Y-m-d H:i") : '',
                "date"       => date("Y-m-d"),
                "to"  => $request->to,
                "link_youtube"  => $request->link_youtube,
                "email"  => $request->email,
                "phone_number"  => $request->phone_number,
                "created_by" => Auth::id()
            ];
            if($payload['to'] == 5 || $payload['to'] == 6){
                $img = str_replace($url, "", $request->photo);
                $payload['picture'] = $img;
            }
            $page = Page::create($payload);

            if($request->picture != null){
                foreach ($request->picture as $key => $value) {
                    $img = str_replace($url, "", $value['link']);
                    $payload_img = [
                        "m_pages" => $page->id,
                        "photo"   => $img,
                        "title"   => $value["title"],
                        "content" => $value["content"],
                        "title_en"   => $value["title_en"],
                        "content_en" => $value["content_en"]
                    ];
                    $save_img = GaleryPage::create($payload_img);
                }
            }


            //log user
            $log = [
                'ref_name'  => 'm_pages',
                'ref_id'    => $page->id,
                'notes'     => 'menambahkan page',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('page.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            dd($e);
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $model = Page::findOrFail($id);
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        try {
            $payload = [
                "title" => $request->title,
                "title_en" => $request->title_en,
                "short_description" => $request->short_description,
                "short_description_en" => $request->short_description_en,
                "short_content" => $request->short_content,
                "short_content_en" => $request->short_content_en,
                "content" => $request->content,
                "content_en" => $request->content_en,
                "is_status" => $request->is_status,
                "link_youtube" => $request->link_youtube,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "publish_at" => $request->is_status == 2 ? date("Y-m-d H:i") : ''
            ];

            if($model->to == 5 || $model->to == 6){
                $img = str_replace($url, "", $request->photo);
                $payload['picture'] = $img;
            }

            if($request->picture != null){
                foreach ($request->picture as $key => $value) {

                    $img = str_replace($url, "", $value['link']);

                    if($value['id'] == 0){
                        $payload_img = [
                            "m_pages" => $id,
                            "photo"   => $img,
                            "title"   => $value["title"],
                            "title_en"   => $value["title_en"],
                            "content" => $value["content"],
                            "content_en" => $value["content_en"],
                        ];
                        GaleryPage::create($payload_img);
                    }else {
                        $payload_img = [
                            "photo"   => $img,
                            "title"   => $value["title"],
                            "title_en"   => $value["title_en"],
                            "content" => $value["content"],
                            "content_en" => $value["content_en"],
                        ];
                        GaleryPage::find($value['id'])->update($payload_img);
                    }
                }
            }

            // if (isset($request->picture)) {
            //     $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
            //     $img = str_replace($url, "", $request->picture);
            //     $payload['picture'] = $img;
            // }

            $model->update($payload);

            //log user
            $log = [
                'ref_name'  => 'm_pages',
                'ref_id'    => $id,
                'notes'     => 'mengubah page',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('page.index')->with('success', 'Edit successfully.');
        } catch (Exception $e) {
            dd($e);
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Page::with('galeri')->findOrFail($id);

        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $model->picture = $model->picture != null ? $url . $model->picture : null;
        foreach ($model->galeri as $key => $val_img) {
            $val_img->photo = $url . $val_img->photo;
        }
        // dd(count($model->galeri), $model->to);
        return view('page.page.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Page::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }

    public function destroyDetail($id){
        $role = GaleryPage::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request, $id)
    {
        $model = Page::findOrFail($id);
        try {
            $payload = [
                'is_status' => $request->is_status,
                'publish_at' => $request->is_status == 0 ? '' : date('Y-m-d H:i')
            ];

            $model->update($payload);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function duplicate(Request $request, $id)
    {
        $root = Page::findOrFail($id);
        try {

            $new = [
                'title' => $root->title . ' Copy',
                'title_en' => $root->title_en . ' Copy',
                'date' => $root->date,
                'to' => $root->to,
                'short_description' => $root->short_description,
                'short_description_en' => $root->short_description_en,
                'picture' => $root->picture,
                'short_content' => $root->short_content,
                'short_content_en' => $root->short_content_en,
                'content' => $root->content,
                'content_en' => $root->content_en,
                'link_youtube' => $root->link_youtube,
                'email' => $root->email,
                'phone_number' => $root->phone_number,
                'publish_at' => $root->publish_at,
                'is_status' => 0,
                "created_by" => Auth::id()
            ];
            $page = Page::create($new);

            //log user
            $log = [
                'ref_name'  => 'm_pages',
                'ref_id'    => $page->id,
                'notes'     => 'Duplicate Page',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            dd($e);
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }
}
