<?php

namespace App\Http\Controllers;

use App\Models\LogUser;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewayDetail;
use App\Models\Setting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class SettingController extends Controller
{
    public function index() {
        $model = PaymentGateway::all();

        return view('page.setting.index', ['list' => $model]);
    }

    public function view($id){
        $model = PaymentGateway::findOrFail($id);
        $detail = PaymentGatewayDetail::where('payment_gateway_id', $id)->get();

        switch ($id) {
            case 2:
                $folder = 'bank';
                break;
            case 3:
                $folder = 'ewallet';
                break;
            case 4:
                $folder = 'cc';
                break;
            default:
                $folder = 'bank';
                break;
        }

        return view('page.setting.detail', ['model'=>$model , 'detail' => $detail, 'folder'=>$folder]);
    }

    public function updateStatus(Request $request, $id)
    {
        $model = PaymentGatewayDetail::findOrFail($id);
        try {
            $payload = [
                'is_status' => $request->is_status
            ];

            $res = $model->update($payload);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function getSEO(){
        try {
            $model = Setting::where('setting_kategori', 'S')->get();

            foreach ($model as $key => $value) {
                if($value->setting_name == 'icon'){
                    $data['icon'] = $value->setting_value;
                }
                if($value->setting_name == 'title'){
                    $data['title'] = $value->setting_value;
                }
                if($value->setting_name == 'deskripsi'){
                    $data['deskripsi'] = $value->setting_value;
                }
                if($value->setting_name == 'keyword'){
                    $data['keyword'] = $value->setting_value;
                }
                if($value->setting_name == 'author'){
                    $data['author'] = $value->setting_value;
                }
            }

            return view('page.setting.seo', ['model' => $data]);
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function saveSEO(Request $request){
        try {
            $url = env('IMG_URL').'img/media/originals/';
            $img = str_replace($url, "", $request->icon);

            $kategori = 'S';
            $icon = Setting::where('setting_type', 'F')
                            ->where('setting_kategori', 'S')
                            ->where('setting_name', 'icon')
                            ->update([
                                'setting_value' => $img
                            ]);
            $title = Setting::where('setting_type', 'T')
                            ->where('setting_kategori', 'S')
                            ->where('setting_name', 'title')
                            ->update([
                                'setting_value' => $request->title
                            ]);

            $deskripsi = Setting::where('setting_type', 'T')
                            ->where('setting_kategori', 'S')
                            ->where('setting_name', 'deskripsi')
                            ->update([
                                'setting_value' => $request->deskripsi
                            ]);
            $keyword = Setting::where('setting_type', 'T')
                            ->where('setting_kategori', 'S')
                            ->where('setting_name', 'keyword')
                            ->update([
                                'setting_value' => $request->keyword
                            ]);
            $author = Setting::where('setting_type', 'T')
                            ->where('setting_kategori', 'S')
                            ->where('setting_name', 'author')
                            ->update([
                                'setting_value' => $request->author
                            ]);

            //log user
            $log = [
                'ref_name'  => 'm_setting',
                'ref_id'    => '',
                'notes'     => 'Mengubah SEO',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);

            return redirect()->route('seo.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }
}
