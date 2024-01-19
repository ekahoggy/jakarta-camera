<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\LogUser;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class KegiatanController extends Controller
{
    public function index(Request $request) {
        $now = date('Y-m-d');
        $getCountData = Kegiatan::where('is_status', 1)->count();
        $kotaEvent = Kegiatan::all();
        $arr = [];
        foreach ($kotaEvent as $key => $value) {
            $arr[] = $value->city;
        }
        $listKota = array_values(array_unique($arr));

        $model = Kegiatan::orderBy('is_status', 'DESC')->orderBy('date', 'ASC')->latest();
        
        if(isset($request->city)){
            $model->where('city', $request->city);
        }
        if(isset($request->search)){
            $model->where('event', 'like', '%' . $request->search . '%')
                ->orWhere('place', 'like', '%' . $request->search . '%')
                ->orWhere('city', 'like', '%' . $request->search . '%');
        }

        $result = $model->paginate(10);

        foreach ($result as $key => $value) {
            $value->status = 0;
            $value->df = date('Y-m-d', strtotime($value->date));
            //update when date is not available
            if(strtotime($value->df) < strtotime($now) && $value->is_status == 1 && $getCountData >= 5){
                Kegiatan::findOrFail($value->id)->update(['is_status' => 0]);
            }
            //crontjob
            if(strtotime($value->df) == strtotime($now) && $value->is_status == 0 && $getCountData <= 5){
                Kegiatan::findOrFail($value->id)->update(['is_status' => 1]);
            }

            if(strtotime($value->df) === strtotime($now)){
                $value->status = 1;
            }
            else if(strtotime($value->df) > strtotime($now)){
                $value->status = 2;
            }
        }

        // if($getCountData < 5){
        //     $upComming = Kegiatan::where('is_status', 1)->orderBy('date', 'DESC')->first();
        //     $upComming->update(['is_status' => 0]);
        // }
        
        return view('page.kegiatan.index', ['model' => $result, 'listKota' => $listKota]);
    }

    public function create() {
        return view('page.kegiatan.create');
    }

    public function store(Request $request)
    {
        $now = strtotime(date('Y-m-d'));
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $image = str_replace($url, "", $request->photo);
        
        $getCountData = Kegiatan::where('is_status', 1)->count();
        $upComming = Kegiatan::where('is_status', 1)->orderBy('date', 'DESC')->first();
        if($getCountData > 5 && $upComming){
            $upComming->update(['is_status' => 0]);
        }

        try {
            $c_time = date('H:i', strtotime($request->time));
            $payload = [
                "event" => $request->event,
                "city" => $request->city,
                "place" => $request->place,
                "date" => $request->date . ' '. $c_time,
                "zona" => $request->zona,
                "photo" => $image,
                "intro" => $request->intro,
                "intro_en" => $request->intro_en,
                "is_status" => $getCountData < 5 ? 1 : 0,
            ];

            if(strtotime($request->date) < $now){
                $payload['is_status'] = 0;
            }

            $kegiatan = Kegiatan::create($payload);

            //log user
            $log = [
                'ref_name'  => 'm_events',
                'ref_id'    => $kegiatan->id,
                'notes'     => 'menambahkan event',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('kegiatan.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            dd($e);
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Kegiatan::findOrFail($id);
        $model->time = date('H:i', strtotime($model->date));
        $model->date = date('Y-m-d', strtotime($model->date));

        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $model->photo = $url . $model->photo;
        return view('page.kegiatan.edit', ['model' => $model]);
    }

    public function update($id, Request $request)
    {
        $now = strtotime(date('Y-m-d'));
        try {
            $getCountData = Kegiatan::where('is_status', 1)->count();
            $upComming = Kegiatan::where('is_status', 1)->orderBy('date', 'DESC')->first();
            if($getCountData > 5 && $upComming){
                $upComming->update(['is_status' => 0]);
            }

            $c_time = date('H:i', strtotime($request->time));
            
            $payload = [
                "event" => $request->event,
                "city" => $request->city,
                "place" => $request->place,
                "date" => $request->date . ' '. $c_time,
                "zona" => $request->zona,
                "intro" => $request->intro,
                "intro_en" => $request->intro_en
            ];

            if(strtotime($request->date) < $now){
                $payload['is_status'] = 0;
            }

            if (isset($request->photo)) {
                $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
                $img = str_replace($url, "", $request->photo);

                $payload["photo"] = $img;
            }

            Kegiatan::find($id)->update($payload);

            //log user
            $log = [
                'ref_name'  => 'm_events',
                'ref_id'    => $id,
                'notes'     => 'mengubah event',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('kegiatan.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function destroy($id){
        $event = Kegiatan::findOrFail($id);
        $upComming = Kegiatan::where('is_status', 0)->where('id', '!=', $event->id)->orderBy('date', 'DESC')->first();

        if($event->is_status === "1"){
            if($upComming && $upComming->id !== $event->id){
                $upComming->update(['is_status' => 1]);
            }
        }
        $event->delete();

        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request, $id)
    {
        $model = Kegiatan::findOrFail($id);
        try {
            $getCountData = Kegiatan::where('is_status', 1)->count();
            if($getCountData <= 5){
                // Kegiatan::where('is_status', 1)->orderBy('date', 'DESC')->first()->update(['is_status' => 0]);
            }

            $payload = [
                'is_status' => $request->is_status
            ];

            $model->update($payload);

            //log user
            $log = [
                'ref_name'  => 'm_events',
                'ref_id'    => $id,
                'notes'     => 'mengubah status event',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }
}
