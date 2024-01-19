<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Resource;
use Exception;

class MResourceController extends Controller
{
    public function index() {
        $model = Resource::all();
        return view('page.resource.index', ['list' => $model]);
    }

    public function create() {
        return view('page.resource.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|max:2048'
        ]);

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $image = Str::after($imagePath, '/');

                $payload = [
                    'title' => request()->title,
                    'content' => request()->content,
                    'image' => $image,
                ];

            }

            Resource::create($payload);
            return redirect()->route('resource.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            dd($e);
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Resource::findOrFail($id);
        return view('page.resource.edit', ['model' => $model]);
    }


    public function update(Request $request, $id)
    {

        $validate['content'] = 'required|string|max:255';

        if (empty($request->input('img_bash'))) {
            $validate['image'] = 'required|max:2048';
        }

        $request->validate($validate);

        $model = Resource::findOrFail($id);

        try {
            if ($request->hasFile('image')) {
                if ($model->image) {
                    Storage::disk('public')->delete($model->image);
                }

                $imagePath = $request->file('image')->store('images', 'public');
                $image = Str::after($imagePath, '/');

                $model->image = $image;

            }

            $model->title = $request->input('title');
            $model->content = $request->input('content');
            $model->save();

            return redirect()->route('resource.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function destroy($id){
        $resource = Resource::findOrFail($id);
        $resource->delete();

        return response()->json(['success' => true]);
    }

    public function getAllResource()
    {
        $model = Resource::orderBy('id', 'asc')->get();
        return response()->json(['list' => $model]);
    }
}
