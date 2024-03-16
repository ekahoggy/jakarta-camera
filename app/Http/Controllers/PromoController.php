<?php

namespace App\Http\Controllers;

use App\Models\LogUser;
use App\Models\Produk;
use App\Models\Promo;
use App\Models\PromoDetail;
use Illuminate\Http\Request;
use App\Providers\MoodStudioProvider as MoodStudio;
use Exception;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Ramsey\Uuid\Uuid as Generator;

class PromoController extends Controller
{
    public function index(Request $request) {
        $model = Promo::orderBy('created_at', 'DESC');
        $model = $model->paginate(20);

        return view('page.promo.index', ['list' => $model]);
    }

    public function create() {
        $produk = Produk::where('is_active', 1)->get();

        return view('page.promo.create', ['listProduk' => $produk]);
    }

    public function store(Request $request)
    {

        try {
            $payload = [
                "id"                => Generator::uuid4()->toString(),
                "kode"              => MoodStudio::kodePromo(),
                "promo"             => $request->promo,
                "tanggal_mulai"     => $request->tanggal_mulai,
                "tanggal_selesai"   => $request->tanggal_selesai,
                "jam_mulai"         => $request->jam_mulai,
                "jam_selesai"       => $request->jam_selesai,
                "promo_min_beli"    => $request->promo_min_beli,
                "is_flashsale"      => $request->is_flashsale ? 1 : 0,
                "created_by"        => auth()->user()->id
            ];

            Promo::create($payload);

            $detail = [];
            foreach ($request->detail_promo as $value) {
                $diskon = ($value['diskon'] / 100) * $value['harga'];
                $detail[] = [
                    "id"            => Generator::uuid4()->toString(),
                    'm_promo_id'    => $payload['id'],
                    'm_produk_id'   => $value['id'],
                    'persen' => $value['diskon'],
                    'nominal'=> (int)$diskon,
                    'promo_user'    => 0,
                    'qty'           => $value['jumlah'],
                ];
            }

            DB::table('m_promo_detail')->insert($detail);

           $log = [
                'ref_name'  => 'm_promo',
                'ref_id'    => $payload['id'],
                'notes'     => 'menambahkan promo ' + $payload['kode'],
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);

            return redirect()->route('promo.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        // $model = Produk::findOrFail($id);

        // $kategori = Kategori::get();
        // $foto = ProdukFoto::where('m_produk_id', $id)->get();

        // return view('page.produk.edit', ['model' => $model, 'foto' => $foto, 'listKategori' => $kategori]);
    }

    public function destroy($id){
        // $role = Produk::findOrFail($id);
        // $role->delete();

        // return response()->json(['success' => true]);
    }
}
