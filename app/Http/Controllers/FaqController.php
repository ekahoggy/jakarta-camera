<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\LogUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class FaqController extends Controller
{
    public function index() {
        $model = Faq::orderBy('created_at', 'DESC');
        $model = $model->paginate(5);

        return view('page.faq.index', ['list' => $model]);
    }

    public function create() {
        return view('page.faq.create');
    }

    public function store(Request $request)
    {
        try {
            $payload = [
                "title" => $request->title,
                "title_en" => $request->title_en,
                "content" => $request->content,
                "content_en" => $request->content_en,
                "position" => '0',
            ];
            $faq = Faq::create($payload);

            //log user
            $log = [
                'ref_name'  => 'm_faq',
                'ref_id'    => $faq->id,
                'notes'     => 'menambahkan faq',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('faq.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Faq::findOrFail($id);
        $model->time = date('H:i', strtotime($model->date));
        $model->date = date('Y-m-d', strtotime($model->date));

        return view('page.faq.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Faq::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }

    public function update($id, Request $request)
    {
        try {
            $payload = [
                "title" => $request->title,
                "title_en" => $request->title_en,
                "content" => $request->content,
                "content_en" => $request->content_en
            ];

            Faq::find($id)->update($payload);

            //log user
            $log = [
                'ref_name'  => 'm_faq',
                'ref_id'    => $id,
                'notes'     => 'mengubah faq',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('faq.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }
}
