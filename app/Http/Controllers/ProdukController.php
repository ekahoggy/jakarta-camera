<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Providers\MoodStudioProvider as MoodStudio;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request) {
        $model = Produk::orderBy('created_at', 'DESC');
        $model = $model->paginate(20);
        
        return view('page.produk.index', ['list' => $model]);
    }
    
    public function create() {
        $kategori = Kategori::get();

        return view('page.produk.create', ['listKategori' => $kategori]);
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
}
