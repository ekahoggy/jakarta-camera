<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use App\Models\WidgetDetail;
use Exception;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class WidgetController extends Controller
{
    public function index() {
        $model = Widget::all();

        return view('page.widget-donasi.index', ['list' => $model]);
    }

    public function create() {
        return view('page.slider.create');
    }

    public function store(Request $request)
    {
        try {
            $payload = [
                "name" => $request->name,
                "type" => $request->type,
                "position" => $request->position,
                "is_status" => 1,
            ];

            Widget::create($payload);
            return redirect()->route('slider.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Widget::findOrFail($id);

        return view('page.slider.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Widget::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }

    public function update($id, Request $request)
    {
        try {
            $payload = [
                "name" => $request->name,
                "type" => $request->type,
                "position" => $request->position,
                "is_status" => 1,
            ];

            Widget::find($id)->update($payload);
            return redirect()->route('slider.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    // widget Detail
    public function getDetailWidget(Request $request, $id){
        $model = WidgetDetail::where('widgets_id', $id)->get();
        return response()->json(['success' => true, "data" => $model]);
    }

    public function storeDetailWidget(Request $request){
        try {
            $payload = [
                "widgets_id" => $request->widget_id,
                "nominal"    => $request->nominal
            ];

            $dt = WidgetDetail::create($payload);
            return response()->json(['success' => true, "data" => $dt]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false]);
        }
    }

    public function updateDetailWidget(Request $request, $id){
        try {
            $payload = [
                "nominal"    => $request->nominal
            ];

            $dt = WidgetDetail::find($id)->update($payload);
            return response()->json(['success' => true, "data" => $dt]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false]);
        }
    }

    public function deleteDetailWidget($id){
        $widgetDetail = WidgetDetail::findOrFail($id);
        $widgetDetail->delete();

        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request, $id)
    {
        $model = Widget::findOrFail($id);
        try {
            $payload = [
                'is_status' => $request->is_status,
            ];

            $model->update($payload);
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }
}
