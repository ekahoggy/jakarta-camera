<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(Request $request) {
        $model = Voucher::orderBy('created_at', 'DESC');
        $model = $model->paginate(20);

        return view('page.voucher.index', ['list' => $model]);
    }
    
    public function create() {
        $voucher = Voucher::get();

        return view('page.voucher.create', ['listVoucher' => $voucher]);
    }

    // public function store(Request $request)
    // {
    //     try {

    //         $payload = [
    //             "id"            => Generator::uuid4()->toString(),
    //             "sku"           => MoodStudio::skuProduk(),
    //             "nama"          => $request->nama,
    //             "harga"         => str_replace('.', '', $request->harga),
    //             "min_beli"      => $request->min_beli,
    //             "slug"          => MoodStudio::createSlug($request->nama),
    //             "m_kategori_id" => $request->m_kategori_id,
    //             "deskripsi"     => $request->deskripsi,
    //             "detail_produk" => $request->detail_produk,
    //             "in_box"        => $request->in_box,
    //             "link_shopee"   => $request->link_shopee,
    //             "link_tokped"   => $request->link_tokped,
    //             "link_bukalapak" => $request->link_bukalapak,
    //             "link_lazada"   => $request->link_lazada,
    //             "link_blibli"   => $request->link_blibli,
    //             "tags"          => $request->tags,
    //             "created_by"    => auth()->user()->id
    //         ];

    //         Produk::create($payload);

    //         //foto produk
    //         $uploadedImage = $request->file('foto_produk');
    //         $urutan = 1;
    //         foreach ($uploadedImage as $key => $value) {
    //             $filename = $payload['sku'].$urutan;
    //             $original = $filename . '.' . $value->getClientOriginalExtension();
    //             $value->move(public_path('img/media/product/'), $original);

    //             $payload_foto = [
    //                 "m_produk_id"   => $payload['id'],
    //                 "foto"          => $original,
    //                 "urutan"        => $urutan,
    //                 "is_main"       => $key === 0 ? 1 : 0,
    //                 "created_by"    => auth()->user()->id
    //             ];

    //             $urutan++;
    //             ProdukFoto::create($payload_foto);
    //         }

    //         //log user
    //         $log = [
    //             'ref_name'  => 'm_produk',
    //             'ref_id'    => $payload['id'],
    //             'notes'     => 'menambahkan produk',
    //             'created_by'=> auth()->user()->id
    //         ];
    //         LogUser::create($log);

    //         return redirect()->route('produk.index')->with('success', 'Saved successfully.');
    //     } catch (Exception $e) {
    //         Alert::error('Error', 'There is an error.');
    //         return back();
    //     }
    // }

    public function edit($id)
    {
        $model = Voucher::findOrFail($id);
        
        return view('page.voucher.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Voucher::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }
}
