<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SubscriptionController extends Controller
{
    public function index() {
        $model = Subscription::orderBy('created_at', 'DESC');
        $model = $model->paginate(20);

        return view('page.subscription.index', ['list' => $model]);
    }

    public function create() {
        return view('page.subscription.create');
    }

    public function store(Request $request)
    {
        try {
            $payload = [
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "is_subscribed" => '1'
            ];

            Subscription::create($payload);
            return redirect()->route('subscription.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Subscription::findOrFail($id);
        $model->time = date('H:i', strtotime($model->date));
        $model->date = date('Y-m-d', strtotime($model->date));

        return view('page.subscription.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Subscription::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }

    public function update($id, Request $request)
    {
        try {
            $c_time = date('H:i', strtotime($request->time));
            $payload = [
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "is_subscribed" => '1'
            ];

            Subscription::find($id)->update($payload);
            return redirect()->route('subscription.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }
}
