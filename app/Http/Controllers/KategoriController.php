<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogUser;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Providers\MoodStudioProvider as MoodStudio;

class KategoriController extends Controller
{
    public function index() {
        $model = Kategori::whereNull('induk_id')->orderBy('created_at', 'DESC');
        $model = $model->paginate(10);
        
        foreach ($model as $key => $value) {
            $value->childs = MoodStudio::oneTreeView('m_kategori', $value->id);
        }

        return view('page.kategori.index', ['list' => $model]);
    }
    
    public function create() {
        $induk = Kategori::whereNull('induk_id')->get();

        return view('page.kategori.create', ['listInduk' => $induk]);
    }

    public function store(Request $request)
    {
        try {
            $url = env('IMG_URL').'img/media/originals/';
            $img = str_replace($url, "", $request->icon);

            $payload = [
                "icon"          => $img,
                "slug"          => MoodStudio::createSlug($request->kategori),
                "kategori"      => $request->kategori,
                "induk_id"      => $request->induk_id,
                "keterangan"    => $request->keterangan,
            ];
            $kategori = Kategori::create($payload);

            //log user
            $log = [
                'ref_name'  => 'm_kategori',
                'ref_id'    => $kategori->id,
                'notes'     => 'menambahkan kategori',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);

            return redirect()->route('kategori.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Kategori::findOrFail($id);

        return view('page.kategori.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Kategori::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }

    public function update($id, Request $request)
    {
        try {
            $url = env('IMG_URL').'img/media/originals/';
            $img = str_replace($url, "", $request->icon);

            $payload = [
                "icon"          => $img,
                "slug"          => MoodStudio::createSlug($request->kategori),
                "kategori"      => $request->kategori,
                "induk_id"      => $request->induk_id,
                "keterangan"    => $request->keterangan,
            ];

            Kategori::find($id)->update($payload);

            //log user
            $log = [
                'ref_name'  => 'm_kategori',
                'ref_id'    => $id,
                'notes'     => 'Mengubah kategori',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('kategori.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }
}