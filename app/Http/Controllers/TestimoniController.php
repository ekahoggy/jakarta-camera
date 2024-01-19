<?php

namespace App\Http\Controllers;

use App\Models\LogUser;
use Exception;
use App\Models\Testimoni;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index(Request $request) {
        $model = Testimoni::orderBy('is_status', 'DESC')->orderBy('created_at', 'DESC');

        if(isset($request->search)){
            $model->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('testimoni', 'like', '%' . $request->search . '%')
                ->orWhere('testimoni_en', 'like', '%' . $request->search . '%');
        }

        $model = $model->paginate(10);

        return view('page.testimoni.index', ['list' => $model]);
    }

    public function create() {
        return view('page.testimoni.create');
    }

    public function store(Request $request)
    {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $image = str_replace($url, "", $request->photo);
        try {
            $payload = [
                'photo' => $image,
                'name' => $request->name,
                'testimoni' => $request->testimoni,
                'testimoni_en' => $request->testimoni_en,
                'is_status' => 1,
            ];
            $getCountData = Testimoni::count();
            $payload['position'] = $getCountData + 1;

            $testimoni = Testimoni::create($payload);

            //log user
            $log = [
                'ref_name'  => 'm_testimoni',
                'ref_id'    => $testimoni->id,
                'notes'     => 'menambahkan testimoni',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('testimoni.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Testimoni::findOrFail($id);
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';

        $model->photo = $url . $model->photo;

        return view('page.testimoni.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Testimoni::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }

    public function update($id, Request $request)
    {
        try {
            $payload = [
                'name' => $request->name,
                'testimoni' => $request->testimoni,
                'testimoni_en' => $request->testimoni_en,
                'is_status' => 1,
            ];

            if (isset($request->photo)) {
                $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
                $img = str_replace($url, "", $request->photo);
                $payload['photo'] = $img;
            }
            
            Testimoni::find($id)->update($payload);
            //log user
            $log = [
                'ref_name'  => 'm_testimoni',
                'ref_id'    => $id,
                'notes'     => 'mengubah testimoni',
                'created_by'=> auth()->user()->id
            ];
            
            LogUser::create($log);
            return redirect()->route('testimoni.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $model = Testimoni::findOrFail($id);
            $payload = [
                'is_status' => $request->is_status
            ];

            $model->update($payload);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            dd($e);
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }
}
