<?php

namespace App\Http\Controllers;

use App\Models\LogUser;
use App\Models\Voucher;
use App\Providers\MoodStudioProvider as MoodStudio;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Ramsey\Uuid\Uuid as Generator;

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

    public function store(Request $request)
    {
        try {
            $url = env('IMG_URL').'img/media/originals/';
            $img = str_replace($url, "", $request->gambar);

            $payload = [
                'id'                => Generator::uuid4()->toString(),
                'redeem_code'       => $request->redeem_code,
                'voucher'           => $request->voucher,
                'tanggal_mulai'     => $request->tanggal_mulai,
                'tanggal_selesai'   => $request->tanggal_selesai,
                'jam_mulai'         => $request->jam_mulai,
                'jam_selesai'       => $request->jam_selesai,
                'gambar'            => $img,
                'deskripsi'         => $request->deskripsi,
                'kategori'          => $request->kategori == NULL ? 'T' : 'O',
                'qty'               => $request->qty,
                'type'              => $request->type == NULL ? 'P' : 'N',
                'voucher_value'     => $request->voucher_value,
                'voucher_max'       => $request->voucher_max,
                'voucher_min_beli'  => $request->voucher_min_beli,
                "created_by"        => auth()->user()->id
            ];

            Voucher::create($payload);

            //log user
            $log = [
                'ref_name'  => 'm_voucher',
                'ref_id'    => $payload['id'],
                'notes'     => 'Menambahkan voucher',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);

            return redirect()->route('voucher.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            dd($e);
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

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
