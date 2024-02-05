<?php

namespace App\Http\Controllers;

use App\Models\LogUser;
use App\Models\Slider;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class SliderController extends Controller
{
    public function index() {
        $model = Slider::orderBy('index_position')->get();

        return view('page.slider.index', ['list' => $model]);
    }

    public function create() {
        return view('page.slider.create');
    }

    public function store(Request $request)
    {
        $url = env('IMG_URL').'img/media/originals/';
        $img = str_replace($url, "", $request->picture);

        try {
            $payload = [
                "title" => $request->title,
                "title_en" => $request->title_en,
                "url" => 'ok',
                "picture" => $img,
                "content" => $request->content,
                "content_en" => $request->content_en,
                "is_status" => 1,
            ];

            $getCountData = Slider::count();
            $payload['index_position'] = $getCountData + 1;

            $slider = Slider::create($payload);

            //log user
            $log = [
                'ref_name'  => 'm_sliders',
                'ref_id'    => $slider->id,
                'notes'     => 'menambahkan slider',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);

            return redirect()->route('slider.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Slider::findOrFail($id);
        $model->time = date('H:i', strtotime($model->date));
        $model->date = date('Y-m-d', strtotime($model->date));

        return view('page.slider.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Slider::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }

    public function update($id, Request $request)
    {
        try {
            $payload = [
                "title" => $request->title,
                "title_en" => $request->title_en,
                "url" => 'ok',
                "content" => $request->content,
                "content_en" => $request->content_en,
                "is_status" => 1,
            ];

            if (isset($request->picture)) {
                $url = env('IMG_URL').'img/media/originals/';
                $img = str_replace($url, "", $request->picture);

                $payload["picture"] = $img;
            }

            $slider = Slider::find($id)->update($payload);

            //log user
            $log = [
                'ref_name'  => 'm_sliders',
                'ref_id'    => $id,
                'notes'     => 'mengubah slider',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('slider.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function updateIndex(Request $request, $id){
        try {
            $payload['index_position'] = $request->index;

            $model = Slider::find($id);
            // dd($payload);
            if($model->index_position < $payload['index_position']){
                Slider::where('index_position', '>',$payload['index_position'])->increment('index_position', 1);
                Slider::where('index_position','>',$model->index_position)->decrement('index_position', 1);
                // $payload['index_position'] -= 1;
            }else{
                Slider::where('id', '!=', $model->id)->where('index_position', '>=',$payload['index_position'])->increment('index_position', 1);
                Slider::where('id', '!=', $model->id)->where('index_position','>',$model->index_position)->decrement('index_position', 1);
                // $payload['index_position'] -= 1;
            }

            $model->update($payload);

            return true;


        } catch (\Throwable $th) {
            return false;
        }
    }
}
