<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use App\Models\PaymentGatewayDetail;
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
}
