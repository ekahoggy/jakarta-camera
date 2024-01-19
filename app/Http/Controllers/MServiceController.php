<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Service;
use Exception;

class MServiceController extends Controller
{
    public function index() {
        $model = Service::all();
        return view('page.service.index', ['list' => $model]);
    }

    public function create() {
        return view('page.service.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
            'image' => 'required|max:2048'
        ]);

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $image = Str::after($imagePath, '/');

                $payload = [
                    'image' => $image,
                    'content' => request()->content
                ];

            }

            Service::create($payload);
            return redirect()->route('service.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Service::findOrFail($id);
        return view('page.service.edit', ['model' => $model]);
    }


    public function update(Request $request, $id)
    {

        $validate['content'] = 'required|string|max:255';

        if (empty($request->input('img_bash'))) {
            $validate['image'] = 'required|max:2048';
        }

        $request->validate($validate);

        $model = Service::findOrFail($id);

        try {
            if ($request->hasFile('image')) {
                if ($model->image) {
                    Storage::disk('public')->delete($model->image);
                }

                $imagePath = $request->file('image')->store('images', 'public');
                $image = Str::after($imagePath, '/');

                $model->image = $image;

            }

            $model->content = $request->input('content');
            $model->save();

            return redirect()->route('service.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function destroy($id){
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['success' => true]);
    }

    public function getAllService()
    {
        $model = Service::orderBy('id', 'asc')->get();
        return response()->json(['list' => $model]);
    }

    public function uploadPdf()
    {
        $model = DB::table('m_files')->first();

        if ($model == null) {
            $model = (object) [];
            $model->file = '';
            $model->download = false;
        } else {
            $model->download = true;
        }

        return view('page.service.upload', ['model' => $model]);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('pdf', 'public');
            $file = Str::after($filePath, '/');

            $payload = [
                'file' => $file,
            ];
        }

        $m_file = DB::table('m_files')->first();

        if ($m_file == null) {
            $model = DB::table('m_files')
            ->insert(['file' => $file]);
        } else {
            $model = DB::table('m_files')
                ->where(['id' => $m_file->id])
                ->update(['file' => $file]);
        }

        return redirect()->route('service.index')->with('success', 'Saved successfully.');
    }

    public function downloadPdf(Request $request)
    {
        $data = DB::table('m_files')->first();

        return response()->json(['files' => $data]);
    }
}
