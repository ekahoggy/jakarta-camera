<?php

namespace App\Http\Controllers;

use App\Models\GaleryPage;
use App\Models\Kegiatan;
use App\Models\LogUser;
use App\Models\Media;
use App\Models\Page;
use App\Models\Slider;
use App\Models\Testimoni;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Exception;

class MediaController extends Controller
{
    public function index(Request $request ) {
        $model = Media::orderBy('created_at', 'DESC');
        // $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $url = '';
        if(isset($request->search)){
            $model->where('file', 'like', '%' . $request->search . '%');
        }

        if(isset($request->date)){
            $request->date = date('Y-m', strtotime('01-'.$request->date));
            $model->where('created_at', 'like', '%' . $request->date . '%');
        }

        $model = $model->paginate(20);
        foreach ($model as $key => $value) {
            $value->link_image = url('img/media/originals/'.$value->file);
        }
        return view('page.media.index', ['list' => $model]);
    }

    public function create() {
        return view('page.media.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image|max:2048'
        ]);
        
        try {
            if ($request->hasFile('file')) {
                // Get the uploaded file
                $uploadedImage = $request->file('file');
                // Generate a unique filename
                
                $filename = Str::random();
                $original = $filename . '.' . $uploadedImage->getClientOriginalExtension();
                $request->file->move(public_path('img/media/originals/'), $original);
                
                // Create a WebP version of the image
                // $image = Image::make($request->file('file'))->encode('webp'); 
                // $imageName = $filename.'.webp'; 
                // $image->save(public_path('img/kategori/webp/'. $imageName)); 
                $path = 'kategori/originals/'. $original;

                $payload = [
                    "file" => $original,
                    "is_status" => 1,
                ];
                $media = Media::create($payload);
                //log user
                $log = [
                    'ref_name'  => 'm_medias',
                    'ref_id'    => $media->id,
                    'notes'     => 'menambahkan media',
                    'created_by'=> auth()->user()->id
                ];
                LogUser::create($log);
                return redirect()->route('media.index')->with('success', 'Saved successfully.');
            }            
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Media::findOrFail($id);
        $model->time = date('H:i', strtotime($model->date));
        $model->date = date('Y-m-d', strtotime($model->date));

        return view('page.media.edit', ['model' => $model]);
    }

    public function destroy($id){
        $media = Media::findOrFail($id);

        // user
        $user = User::where('photo', $media->file)->get();
        foreach ($user as $key => $value) {
            User::findOrFail($value->id)->update(['photo' => null]);
        }
        // event
        $event = Kegiatan::where('photo', $media->file)->get();
        foreach ($event as $key => $value) {
            Kegiatan::findOrFail($value->id)->update(['photo' => null]);
        }
        // galeri
        $galeri = GaleryPage::where('photo', $media->file)->get();
        foreach ($galeri as $key => $value) {
            GaleryPage::findOrFail($value->id)->delete();
        }
        // slider
        $slider = Slider::where('picture', $media->file)->get();
        foreach ($slider as $key => $value) {
            Slider::findOrFail($value->id)->delete();
        }
        // testimoni
        $testimoni = Testimoni::where('photo', $media->file)->get();
        foreach ($testimoni as $key => $value) {
            Testimoni::findOrFail($value->id)->update(['photo' => null]);
        }
        // page
        $page = Page::where('picture', $media->file)->get();
        foreach ($page as $key => $value) {
            Page::findOrFail($value->id)->update(['picture' => null]);
        }
        
        Storage::disk('s3')->delete($media->file);
        $media->delete();

        return response()->json(['success' => true]);
    }

    public function getImg(Request $request) {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';

        $model = Media::orderBy('created_at', 'DESC');

        if(isset($request->search)){
            $model->where('file', 'LIKE', "%".$request->search."%");
        }

        $result = $model->paginate(12);

        foreach ($result as $key => $value) {
            $value->link_image = url('img/media/originals/'.$value->file);
        }

        return response()->json(['success' => true, "data" => $result, "paginate" => (string) $result->links()]);
    }

    public function saveImg(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image|max:2048'
        ]);

        try {
            if ($request->hasFile('file')) {
                $uploadedImage = $request->file('file');
                // $name = time() . $file->getClientOriginalName();
                // $filePath = 'galery_wvi/' . $name;
                // Storage::disk('s3')->put($filePath, file_get_contents($file));

                $filename = Str::random();
                $original = $filename . '.' . $uploadedImage->getClientOriginalExtension();
                $request->file->move(public_path('img/media/originals/'), $original);

                $payload = [
                    "file" => $original,
                    "is_status" => 1,
                ];
            }

            $media = Media::create($payload);

            //log user
            $log = [
                'ref_name'  => 'm_medias',
                'ref_id'    => $media->id,
                'notes'     => 'menambahkan media',
                'created_by'=> auth()->user()->id
            ];

            LogUser::create($log);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return response()->json(['success' => false]);
        }
    }

    public function destroyAll($id){
        $arr = explode (",", $id);

        foreach ($arr as $key => $value) {
            $media = Media::findOrFail($value);

            Storage::disk('s3')->delete($media->file);
            $media->delete();
        }

        return response()->json(['success' => true]);
    }
}
