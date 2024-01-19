<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class KegiatanDraftController extends Controller
{
    public function index() {
        $kotaEvent = Kegiatan::where('is_status', 0)->get();
        $arr = [];
        foreach ($kotaEvent as $key => $value) {
            $arr[] = $value->place;
        }
        $listKota = array_values(array_unique($arr));

        $model = Kegiatan::where('is_status', 0)->latest()->paginate(10);
        return view('page.kegiatandraft.index', ['model' => $model, 'listKota' => $listKota]);
    }

    public function create() {
        return view('page.kegiatandraft.create');
    }

    public function store(Request $request)
    {
        try {
            $c_time = date('H:i', strtotime($request->time));
            if ($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('kegiatan', 'public');
                $image = Str::after($imagePath, '/');


                $payload = [
                    "event" => $request->event,
                    "city" => $request->city,
                    "place" => $request->place,
                    "date" => $request->date . ' '. $c_time,
                    "photo" => $image,
                    "intro" => $request->intro,
                    "is_status" => 1,
                ];
            }

            Kegiatan::create($payload);
            return redirect()->route('kegiatan.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Kegiatan::findOrFail($id);
        $model->time = date('H:i', strtotime($model->date));
        $model->date = date('Y-m-d', strtotime($model->date));

        return view('page.kegiatandraft.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Kegiatan::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }
}
