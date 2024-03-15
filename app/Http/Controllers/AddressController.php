<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected $address;

    public function __construct()
    {
        $this->address = new Address();
    }

    public function getAddress(Request $request) {
        $params = $request->all();
        $data = $this->address->getAddress($params);

        return response()->json([
            'data' => $data,
            'status_code' => 200, 
            'message' => 'Successfully show list address'
        ], 200);
    }

    public function addAddress(Request $request) {
        $params = $request->all();

        $found = $this->address->checkAddress($params);

        if (isset($found) && !empty($found)) {
            $params['quantity'] += $found->quantity;
            $model = $this->address->updateAddress($params);
        } else {
            $model = $this->address->insertAddress($params);
        }

        if ($model === true || $model === 1) {
            return response()->json(['status_code' => 200, 'message' => 'Successfully added to address'], 200);
        }

        return response()->json(['status_code' => 422, 'message' => 'An error occurred on the server'], 422);
    }

    public function updateAddress(Request $request) {
        $params = $request->all();
        $model = $this->address->changeAddress($params);

        if ($model === true || $model === 1) {
            return response()->json(['status_code' => 200, 'message' => 'Successfully change quantity'], 200);
        }

        return response()->json(['status_code' => 422, 'message' => 'An error occurred on the server'], 422);
    }

    public function deleteAddress(Request $request) {
        $params = $request->all();
        $model = $this->address->deleteAddress($params);

        if ($model === true || $model === 1) {
            return response()->json(['status_code' => 200, 'message' => 'Successfully delete address'], 200);
        }

        return response()->json(['status_code' => 422, 'message' => 'An error occurred on the server'], 422);
    }
}
