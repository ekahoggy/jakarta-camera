<?php

namespace App\Http\Controllers;

use App\Models\Donations;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportDonations;
use App\Models\Kegiatan;
use Exception;

class DonationController extends Controller
{
    public function index() {
        $event = Kegiatan::all();

        $all = Donations::orderBy('created_at', 'DESC')->latest();
        $all = $all->paginate(10, ['*'], 'allPagination');

        $sponsor = Donations::where('type', 1)->orderBy('created_at', 'DESC')->latest();
        $sponsor = $sponsor->paginate(10, ['*'], 'sponsorPagination');

        $onetime = Donations::where('type', 0)->orderBy('created_at', 'DESC')->latest();
        $onetime = $onetime->paginate(10, ['*'], 'onetimePagination');


        foreach ($all as $key => $value) {
            foreach ($event as $k => $v) {
                if($value->m_events_id == $v->id){
                    $value->wnsm = $v->place;
                }
            }
        }

        foreach ($sponsor as $key => $value) {
            foreach ($event as $k => $v) {
                if($value->m_events_id == $v->id){
                    $value->wnsm = $v->place;
                }
            }
        }

        foreach ($onetime as $key => $value) {
            foreach ($event as $k => $v) {
                if($value->m_events_id == $v->id){
                    $value->wnsm = $v->place;
                }
            }
        }

        return view('page.donasi.index', ['all' => $all, 'sponsor' => $sponsor, 'onetime' => $onetime]);
    }

    public function updateAll(){
        $donasi = Donations::where('transaction_status', '!=', 'Paid')->get();
        $serverKey = config('midtrans.server_key');

        foreach ($donasi as $key => $value) {
            $ch = curl_init("https://api.midtrans.com/v2/$value->no_donation/status");
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
                'Accept:application/json',
                'Content-Type:application/json',
                'Authorization:Basic '. base64_encode($serverKey)
            ));
            # Return response instead of printing.
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            # Send request.
            $result = curl_exec($ch);
            curl_close($ch);
            $data = json_decode( $result, true );
            if($data['status_code'] !== "404"){
                if($data['transaction_status'] === 'capture' || $data['transaction_status'] === 'settlement'){
                    $data['transaction_status'] = 'Paid';

                    if(isset($data['payment_type']) && $data['payment_type'] === 'qris'){
                        if(isset($data['acquirer'])){
                            $data['bank'] = $data['acquirer'];
                        }
                        else{
                            $data['bank'] = '';
                        }
                    }
                    elseif(isset($data['payment_type']) && $data['payment_type'] === 'echannel'){
                        $data['bank'] = 'Virtual Account';
                        $data['card_type'] = 'Mandiri';
                        $data['masked_card'] = $data['bill_key'];
                    }
                    elseif(isset($data['payment_type']) && $data['payment_type'] === 'bank_transfer'){
                        if(isset($data['va_numbers'])){
                            $data['bank'] = 'Virtual Account';
                            $data['card_type'] = $data['va_numbers'][0]['bank'];
                            $data['masked_card'] = $data['va_numbers'][0]['va_number'];
                        }
                        else{
                            if(isset($data['permata_va_number'])){
                                $data['bank'] = 'Virtual Account';
                                $data['card_type'] = 'Permata Bank';
                                $data['masked_card'] = $data['permata_va_number'];
                            }
                            else{
                                $data['bank'] = 'Bank Transfer';
                            }
                        }
                    }
                }

            }
            else{
                $data['transaction_status'] = 'Expired';
            }
            
            $model = Donations::findOrFail($value->id);
            $model->update($data);
        }
        
        return redirect()->route('donasi.index')->with('success', 'Batch successfully.');
    }

    public function edit($id)
    {
        $serverKey = config('midtrans.server_key');
        $event = Kegiatan::all();
        $model = Donations::findOrFail($id);
        $model->card_type = $this->RemoveSpecialChar($model->card_type);
        $model->payment_type = $this->RemoveSpecialChar($model->payment_type);
        $model->wnsm = '-';
        $model->city = '-';

        $model->phone_number = str_replace("+62", "", $model->phone_number);

        $ch = curl_init("https://api.midtrans.com/v2/$model->no_donation/status");
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type:application/json',
            'Authorization:Basic '. base64_encode($serverKey)
        ));
        # Return response instead of printing.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);

        if($result){
            $data = json_decode( $result, true );
            
            if($data['status_code'] !== "404"){
                if(isset($data['payment_type']) && $data['payment_type'] === 'qris'){
                    if(isset($data['acquirer'])){
                        $acquirer = ' - '. $data['acquirer'];
                    }
                    else{
                        $acquirer = '';
                    }
                    $model->metode_pembayaran = strtoupper($data['payment_type']) . $acquirer;
                }
                elseif(isset($data['payment_type']) && $data['payment_type'] === 'credit_card'){
                    $model->metode_pembayaran = strtoupper($this->RemoveSpecialChar($data['payment_type']) . ' - ' .$data['bank']);
                }
                elseif(isset($data['payment_type']) && $data['payment_type'] === 'echannel'){
                    // $model->metode_pembayaran = isset($data['bill_key']) ? strtoupper('E Channel') . ' - ' .$data['bill_key'] : strtoupper('E Channel');
                    $model->metode_pembayaran = isset($data['bill_key']) ? 'Virtual Account - Mandiri(' .$data['bill_key'] .')' : 'Virtual Account';
                }
                elseif(isset($data['payment_type']) && $data['payment_type'] === 'bank_transfer'){
                    if(isset($data['va_numbers'])){
                        $model->metode_pembayaran = strtoupper('Virtual Account - ' .$data['va_numbers'][0]['bank'] . '(' . $data['va_numbers'][0]['va_number'] . ')');
                    }
                    else{
                        if(isset($data['permata_va_number'])){
                            $model->metode_pembayaran = strtoupper('Virtual Account - Permata Bank('.$data['permata_va_number'].')');
                        }
                        else{
                            $model->metode_pembayaran = strtoupper('Bank Transfer');
                        }
                    }
                }
                else{
                    $model->metode_pembayaran = strtoupper($data['payment_type']);
                }

                $model->transaction_status = ucfirst($data['transaction_status']);
                if($model->transaction_status === 'Capture' || $model->transaction_status === 'Settlement'){
                    $model->transaction_status = 'Paid';
                }
                elseif($model->transaction_status === 'Expire'){
                    $model->transaction_status = 'Expired';
                }
            }
            else{
                $model->transaction_status = 'Expired';
            }
            //update status
            $this->updateStatus($id, $model);
        }

        foreach ($event as $k => $v) {
            if($model->m_events_id == $v->id){
                $model->wnsm = $v->place;
                $model->city = $v->city;
            }
        }

        return view('page.donasi.edit', ['model' => $model]);
    }

    function updateStatus($id, $response){
        $model = Donations::findOrFail($id);
        
        $data = [
            'transaction_status'    => $response->transaction_status,
            'payment_type'          => $response->payment_type ? $response->payment_type : NULL
        ];
        $model->update($data);
    }

    function updateIDN(Request $request, $id) {
        $model = Donations::findOrFail($id);
        try {
            $model->update(['idn_anak' => $request->idn_anak]);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    function export() {
        return Excel::download(new ExportDonations, 'donasi.xlsx');
    }

    function RemoveSpecialChar($str) {
        $res = str_replace( array( '\'', '"', ',' , ';', '<', '>' , '_' ), ' ', $str);

        return $res;
    }

}
