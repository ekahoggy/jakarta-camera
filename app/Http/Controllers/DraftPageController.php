<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Stringable;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class DraftPageController extends Controller
{
    public function index(Request $request) {
        $model = Page::with('users');

        if(isset($request->status)){
            $model->where('is_status', $request->status);
        }
        if(isset($request->search)){
            $model->where('title', 'like', '%' . $request->search . '%');
        }

        $result = $model->paginate(10);

        return view('page.page.index', ['list' => $result]);
    }

    public function create() {
        return view('page.page.create');
    }

    public function store(Request $request)
    {
        try {
            if ($request->hasFile('picture')) {
                $imagePath = $request->file('picture')->store('page', 'public');
                $image = Str::after($imagePath, '/');
                $payload = [
                    "title" => $request->title,
                    "short_description" => $request->short_description,
                    'picture' => $image,
                    "short_content" => $request->short_content,
                    "content" => $request->content,
                    "is_status" => $request->is_status,
                    "publish_at" => $request->is_status == 2 ? date("Y-m-d H:i") : '',
                    "date"       => date("Y-m-d"),
                    "tags"  => $request->tags,
                    "created_by" => Auth::id()
                ];
            }
            Page::create($payload);
            return redirect()->route('page.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $model = Page::findOrFail($id);
        try {
            $payload = [
                "title" => $request->title,
                "short_description" => $request->short_description,
                "short_content" => $request->short_content,
                "content" => $request->content,
                "is_status" => $request->is_status,
                "publish_at" => $request->is_status == 2 ? date("Y-m-d H:i") : '',
                "tags"  => $request->tags,
            ];
            if ($request->hasFile('picture')) {
                $imagePath = $request->file('picture')->store('page', 'public');
                $image = Str::after($imagePath, '/');

                $payload['picture'] = $image;

            }

            Page::find($id)->update($payload);
            return redirect()->route('page.index')->with('success', 'Edit successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Page::findOrFail($id);

        return view('page.page.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Page::findOrFail($id);
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
}
