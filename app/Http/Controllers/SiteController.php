<?php

namespace App\Http\Controllers;

use App\Mail\DonasiDoneEmail;
use App\Mail\DonasiProgressEmail;
use App\Models\Country;
use App\Models\Donations;
use App\Models\Faq;
use App\Models\GaleryPage;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Media;
use App\Models\Page;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewayDetail;
use App\Models\Produk;
use App\Models\ProdukFoto;
use App\Models\Slider;
use App\Models\Subscription;
use App\Models\Testimoni;
use App\Models\Widget;
use App\Models\WidgetDetail;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{

    public function index() {
        dd('ok');
    }

    public function country() {
        $country = Country::all();

        if($country){
            return response()->json(['status_code' => 200, 'data' => $country], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function city() {
        $kotaEvent = Kegiatan::where('is_status', 1)->orderBy('date', 'DESC')->get();

        $arr = [];
        foreach ($kotaEvent as $value) {
            $arr[] = $value->city;
        }
        $listKota = array_values(array_unique($arr));

        if(!empty($listKota)){
            return response()->json(['status_code' => 200, 'data' => $listKota], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function place() {
        $placeEvent = Kegiatan::orderBy('date', 'DESC')->get();

        if(!empty($placeEvent)){
            return response()->json(['status_code' => 200, 'data' => $placeEvent], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function payment() {
        $payment = PaymentGateway::orderBy('id', 'ASC')->get();
        $url = 'https://sharehopebe.wahanavisi.org/img/payment/';

        foreach ($payment as $key => $value) {
            $value->url_icon = $url. $value->icon;
        }

        if($payment){
            return response()->json(['status_code' => 200, 'data' => $payment], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function paymentDetail() {
        $payment = PaymentGatewayDetail::where('is_status', 1)->orderBy('id', 'ASC')->get();
        $url = 'https://sharehopebe.wahanavisi.org/img/payment/';

        foreach ($payment as $key => $value) {
            $value->folder = 'bank/';

            if($value->payment_gateway_id === "3"){
                $value->folder = 'ewallet/';
            }
            else if($value->payment_gateway_id === "4"){
                $value->folder = 'cc/';
            }

            $value->url_icon = $url. $value->folder .$value->icon;
        }

        if($payment){
            return response()->json(['status_code' => 200, 'data' => $payment], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function slider() {
        $slider = Slider::where('is_status', 1)->orderBy('index_position', 'ASC')->get();

        if($slider){
            return response()->json(['status_code' => 200, 'data' => $slider], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function faq() {
        $faq = Faq::orderBy('position', 'ASC')->get();

        foreach ($faq as $key => $value) {
            $value->content = strip_tags($value->content);
        }

        if($faq){
            return response()->json(['status_code' => 200, 'data' => $faq], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function event() {
        $event = Kegiatan::where('is_status', 1)->orderBy('date', 'ASC')->get();
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';

        if($event){
            foreach ($event as $item) {
                $item->date_convert = date('d F Y', strtotime($item->date));
                $item->time = date('H.i', strtotime($item->date));
                $item->photo = $url . $item->photo;
                $item->intro = strip_tags($item->intro);
                $item->intro_en = strip_tags($item->intro_en);
            }
            return response()->json(['status_code' => 200, 'data' => $event], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function page() {
        $page = Page::where('is_status', 2)->orderBy('date', 'DESC')->get();
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        if($page){
            foreach($page as $item){
                $item->short_content = strip_tags($item->short_content);
                $item->short_content_en = strip_tags($item->short_content_en);
                $item->content = strip_tags($item->content);
                $item->content_en = strip_tags($item->content_en);
                $item->picture = $url . $item->picture;

                if($item->to == '1'){
                    $item->link_youtube = str_replace("https://www.youtube.com/watch?v=", "", $item->link_youtube);
                }
            }
            return response()->json(['status_code' => 200, 'data' => $page], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function galeri() {
        $root = Page::where('is_status', 2)->where('to', 2)->orderBy('created_at', 'DESC')->first();
        $galeri = GaleryPage::where('m_pages', $root->id)->get();
        $root->content = strip_tags($root->content);
        $root->content_en = strip_tags($root->content_en);

        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';

        if($galeri){
            foreach ($galeri as $item) {
                $item->file = $url . $item->photo;
                $item->content = strip_tags($item->content);
                $item->content_en = strip_tags($item->content_en);
            }
            return response()->json(['status_code' => 200, 'data' => $galeri, 'root' => $root], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function widgetPageDonasi() {
        $sponsor = Page::where('is_status', 2)->where('to', 5)->first();
        $onetime = Page::where('is_status', 2)->where('to', 6)->first();
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';

        $sponsor->content = strip_tags($sponsor->content);
        $sponsor->content_en = strip_tags($sponsor->content_en);
        $sponsor->file = $url . $sponsor->picture;
        $onetime->content = strip_tags($onetime->content);
        $onetime->content_en = strip_tags($onetime->content_en);
        $onetime->file = $url . $onetime->picture;
        return response()->json(['status_code' => 200, 'sponsor' => $sponsor, 'onetime' => $onetime], 200);
    }

    public function settingWidget() {
        $setting = Widget::where('is_status', 1)->get();

        if($setting){
            return response()->json(['status_code' => 200, 'data' => $setting], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function widget() {
        $sponsor = WidgetDetail::where('widgets_id', 1)->first();
        $onetime = WidgetDetail::where('widgets_id', 2)->get();

        if($sponsor){
            return response()->json(['status_code' => 200, 'sponsor' => $sponsor, 'onetime' => $onetime], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function testimoni() {
        $testimoni = Testimoni::where('is_status', 1)->orderBy('created_at', 'DESC')->get();
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';

        if($testimoni){
            foreach ($testimoni as $item) {
                $item->photo = $url . $item->photo;
            }
            return response()->json(['status_code' => 200, 'data' => $testimoni], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }

    public function subscription(Request $request) {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required'
        ]);

        try {
            $payload = [
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "is_subscribed" => '1'
            ];

            $sub = Subscription::create($payload);
            return response()->json(['status_code' => 200, 'data' => $sub], 200);
        } catch (\Throwable $th) {
            return response()->json(['status_code' => 422, 'pesan' => $th], 422);
        }
    }

    public function donation(Request $request) {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = true;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            $payload = [
                'no_donation'   => rand(),
                'type'          => $request->type === 1 ? 0 : 1,
                'qty'           => $request->qty,
                'nominal'       => $request->nominal,
                'total_donation'=> $request->qty * $request->nominal,
                'name'          => $request->nama,
                'email'         => $request->email,
                'phone_code'    => $request->phone_code,
                'phone_number'  => $request->telepon,
                'address'       => $request->alamat,
                'gender'        => $request->gender === 'laki-laki' ? 1 : 0,
                'wnsm'          => $request->city_from,
                'm_events_id'   => $request->m_events_id,
                'transaction_status' => 'Unpaid'
            ];

            $donation = Donations::create($payload);
            // Mail::to($request->email)->send(new DonasiProgressEmail($donation));

            $params = array(
                'transaction_details' => array(
                    'order_id' => $donation->no_donation,
                    'gross_amount' => $donation->total_donation,
                ),
                'customer_details' => array(
                    'first_name' => $donation->name,
                    'email' => $donation->email,
                    'phone' => $donation->phone_number
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $model = Donations::findOrFail($donation->id);

            $model->update(['snap_token' => $snapToken]);

            $data = [
                'data' => $model,
                'snapToken' => $snapToken
            ];

            return response()->json(['status_code' => 200, 'data' => $data], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['status_code' => 422, 'pesan' => $th], 422);
        }
    }

    public function midtransCallback(Request $request){
        $serverKey = config('midtrans.server_key');
        try {
            if($request->transaction_status === 'capture' || $request->transaction_status === 'paid' || $request->transaction_status === 'settlement'){
                $status = 'Paid';
            }
            elseif($request->transaction_status === 'pending'){
                $status = 'Pending';
            }
            elseif($request->transaction_status === 'unpaid'){
                $status = 'Unpaid';
            }
            else{
                $status = 'Expired';
            }

            $payload = [
                'bank' => $request->bank,
                'card_type' => $request->card_type,
                'finish_redirect_url' => $request->finish_redirect_url,
                'masked_card' => $request->masked_card,
                'payment_type' => $request->payment_type,
                'transaction_id' => $request->transaction_id,
                'transaction_time' => $request->transaction_time,
                'transaction_status' => $status
            ];
            // $status = $request->transaction_status === 'capture' ? 'Paid' : 'Expired';
            $donation = Donations::where('no_donation', $request->order_id)->update($payload);

            return response()->json(['status_code' => 200, 'data' => $donation], 200);
        } catch (\Throwable $th) {
            return response()->json(['status_code' => 422, 'pesan' => $th], 422);
        }
    }

    public function notificationURL(Request $request){
        $serverKey = config('midtrans.server_key');
        try {
            $payload = [
                'bank' => $request->bank,
                'card_type' => $request->card_type,
                'finish_redirect_url' => $request->finish_redirect_url,
                'masked_card' => $request->masked_card,
                'payment_type' => $request->payment_type,
                'transaction_id' => $request->transaction_id,
                'transaction_time' => $request->transaction_time,
                'transaction_status' => $request->transaction_status === 'capture' ? 'Paid' : 'Pending'
            ];
            $status = $request->transaction_status === 'capture' ? 'Paid' : 'Pending';
            $donation = Donations::where('no_donation', $request->order_id)->update(['transaction_status' => $status]);

            return response()->json(['status_code' => 200, 'data' => $donation], 200);
        } catch (\Throwable $th) {
            return response()->json(['status_code' => 422, 'pesan' => $th], 422);
        }
    }

    public function updateDonation(Request $request) {
        $data = $request->data;
        $model = Donations::where(['no_donation' => $data['order_id']])->first();

        try {
            $payload = [
                'bank' => $data['bank'],
                'card_type' => $data['card_type'],
                'finish_redirect_url' => $data['finish_redirect_url'],
                'masked_card' => $data['masked_card'],
                'payment_type' => $data['payment_type'],
                'transaction_id' => $data['transaction_id'],
                'transaction_time' => $data['transaction_time']
            ];
            $model->update($payload);

            $model->transaction_time = date('d F Y H:i:s', strtotime($model->transaction_time));
            $model->masked_card = $this->mask_number($model->masked_card);

            Mail::to($model->email)->send(new DonasiDoneEmail($model));

            return response()->json(['status_code' => 200, 'data' => $model], 200);
        } catch (\Throwable $th) {
            return response()->json(['status_code' => 422, 'pesan' => $th], 422);
        }
    }

    function mask_number($number, $count = 4, $seperators = '-')
    {
        $masked = preg_replace('/\d/', 'x', $number);
        $last = preg_match(sprintf('/([%s]?\d){%d}$/', preg_quote($seperators),  $count), $number, $matches);
        if ($last) {
            list($clean) = $matches;
            $masked = substr($masked, 0, -strlen($clean)) . $clean;
        }
        return $masked;
    }

    function cronjob() {
        $now = date('Y-m-d');
        $getCountData = Kegiatan::where('is_status', 1)->count();
        $model = Kegiatan::orderBy('date', 'ASC')->get();

        foreach ($model as $key => $value) {
            $value->df = date('Y-m-d', strtotime($value->date));
            $value->intro = strip_tags($value->intro);
            $value->intro_en = strip_tags($value->intro_en);

            //update when date is not available
            if(strtotime($value->df) < strtotime($now) && $value->is_status == 1 && $getCountData < 5){
                Kegiatan::findOrFail($value->id)->update(['is_status' => 0]);
            }

            if(strtotime($value->df) == strtotime($now) && $value->is_status == 0 && $getCountData < 5){
                Kegiatan::findOrFail($value->id)->update(['is_status' => 1]);
            }
        }

        return response()->json(['status_code' => 200, 'data' => $model], 200);
    }
}
