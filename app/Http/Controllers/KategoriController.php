<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogUser;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    public function index() {
        $model = Kategori::orderBy('created_at', 'DESC');
        $model = $model->paginate(10);

        return view('page.kategori.index', ['list' => $model]);
    }

    public function create() {
        return view('page.kategori.create');
    }

    public function store(Request $request)
    {
        try {

            dd($request);
            $payload = [
                "kategori" => $request->kategori,
                "keterangan" => $request->keterangan,
            ];
            $kategori = Kategori::create($payload);

            //log user
            $log = [
                'ref_name'  => 'm_faq',
                'ref_id'    => $kategori->id,
                'notes'     => 'menambahkan faq',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('faq.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }
}