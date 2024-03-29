<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogUser;
use App\Models\Produk;
use App\Models\ProdukFoto;
use App\Providers\MoodStudioProvider as MoodStudio;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Ramsey\Uuid\Uuid as Generator;

class ProdukController extends Controller
{
    public function index(Request $request) {
        $model = Produk::orderBy('created_at', 'DESC');
        $model = $model->paginate(20);

        $kategori = Kategori::get();
        $foto = ProdukFoto::where('is_main', 1)->get();

        foreach ($model as $key => $value) {
            $value->arr_tags = explode(',', $value->tags);
            //get foto produk main
            foreach ($foto as $k => $v) {
                if($v->m_produk_id === $value->id){
                    $value->foto = $v->foto;
                }
            }
            //get kategori
            foreach ($kategori as $i => $d) {
                if($d->id === $value->m_kategori_id){
                    $value->kategori = $d->kategori;
                }
            }
        }

        return view('page.produk.index', ['list' => $model]);
    }

    public function create() {
        $kategori = Kategori::get();

        return view('page.produk.create', ['listKategori' => $kategori]);
    }

    public function store(Request $request)
    {
        try {
            $payload = [
                "id"            => Generator::uuid4()->toString(),
                "sku"           => MoodStudio::skuProduk(),
                "nama"          => $request->nama,
                "harga"         => str_replace('.', '', $request->harga),
                "min_beli"      => $request->min_beli,
                "slug"          => MoodStudio::createSlug($request->nama),
                "m_kategori_id" => $request->m_kategori_id,
                "deskripsi"     => $request->deskripsi,
                "detail_produk" => $request->detail_produk,
                "in_box"        => $request->in_box,
                "link_shopee"   => $request->link_shopee,
                "link_tokped"   => $request->link_tokped,
                "link_bukalapak" => $request->link_bukalapak,
                "link_lazada"   => $request->link_lazada,
                "link_blibli"   => $request->link_blibli,
                "tags"          => $request->tags,
                "created_by"    => auth()->user()->id
            ];

            Produk::create($payload);

            //foto produk
            $uploadedImage = $request->file('foto_produk');
            $urutan = 1;
            foreach ($uploadedImage as $key => $value) {
                $filename = $payload['sku'].$urutan;
                // $original = $filename . '.' . $value->getClientOriginalExtension();
                $original = $request->nama_gambar[$key] . '.' . $value->getClientOriginalExtension();
                $value->move(public_path('img/media/product/'), $original);

                $payload_foto = [
                    "m_produk_id"   => $payload['id'],
                    "foto"          => $original,
                    "urutan"        => $urutan,
                    "is_main"       => $key === 0 ? 1 : 0,
                    "created_by"    => auth()->user()->id
                ];

                $urutan++;
                ProdukFoto::create($payload_foto);
            }

            //log user
            $log = [
                'ref_name'  => 'm_produk',
                'ref_id'    => $payload['id'],
                'notes'     => 'menambahkan produk',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);

            return redirect()->route('produk.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Produk::findOrFail($id);

        $kategori = Kategori::get();
        $foto = ProdukFoto::where('m_produk_id', $id)->get();

        return view('page.produk.edit', ['model' => $model, 'foto' => $foto, 'listKategori' => $kategori]);
    }

    public function destroy($id){
        $role = Produk::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }

    //public function
    public function getProduk(Request $request){
        $model = Produk::where('is_active', 1)->get();

        return response()->json(['success' => true, "data" => $model]);
    }

    public function getProdukById(Request $request, $id){
        $data = Produk::where('is_active', 1)->where('id', $id)->first();

        return response()->json(['success' => true, "data" => $data]);
    }

    public function katalog(Request $request) {
        $produkModel = new Produk();
        $param = [
            'kategori'  => $request->kategori
        ];
        $produk = $produkModel->getAll($param);
        if($produk){

            return response()->json(['status_code' => 200, 'data' => $produk], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function produk() {
        $produkModel = new Produk();
        $produk = $produkModel->getAll();
        if($produk){
            return response()->json(['status_code' => 200, 'data' => $produk], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function getProdukSlug(Request $request) {
        $produkModel = new Produk();
        $produk = $produkModel->getBySlug($request->slug);
        if($produk){
            return response()->json(['status_code' => 200, 'data' => $produk], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }
}
