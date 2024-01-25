<?php

namespace App\Http\Controllers;

use App\Models\LogUser;
use App\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class RoleController extends Controller
{
    public function index(Request $request) {

        $role = Role::where('is_deleted', 0)->get();
        $arr = [];
        foreach ($role as $key => $value) {
            $arr[] = $value->name;
        }
        $listRole = array_values(array_unique($arr));

        $model = Role::where('is_deleted', 0)->latest();
        if(isset($request->search)){
            $model->where('name', 'like', '%' . $request->search . '%');
        }

        $model = $model->paginate(10);

        // convert data access to array
        $model->map(function ($item){
            $item->access = json_decode($item->access);
        });

        return view('page.role.index', ['list' => $model, 'listRole' => $listRole]);
    }

    public function create() {
        return view('page.role.create');
    }

    public function store(Request $request)
    {
        try {
            $arrPermision = [
                'dashboard_index'   => request()->dashboard_index ? 1 : 0,
                'kategori_index'      => request()->kategori_index ? 1 : 0,
                'kategori_create'     => request()->kategori_create ? 1 : 0,
                'kategori_update'     => request()->kategori_update ? 1 : 0,
                'kategori_delete'     => request()->kategori_delete ? 1 : 0,
                'donasi_index'      => request()->donasi_index ? 1 : 0,
                'donasi_create'     => request()->donasi_create ? 1 : 0,
                'donasi_update'     => request()->donasi_update ? 1 : 0,
                'donasi_delete'     => request()->donasi_delete ? 1 : 0,
                'page_index'        => request()->page_index ? 1 : 0,
                'page_create'       => request()->page_create ? 1 : 0,
                'page_update'       => request()->page_update ? 1 : 0,
                'page_delete'       => request()->page_delete ? 1 : 0,
                'widget_index'      => request()->widget_index ? 1 : 0,
                'widget_create'     => request()->widget_create ? 1 : 0,
                'widget_update'     => request()->widget_update ? 1 : 0,
                'widget_delete'     => request()->widget_delete ? 1 : 0,
                'event_index'       => request()->event_index ? 1 : 0,
                'event_create'      => request()->event_create ? 1 : 0,
                'event_update'      => request()->event_update ? 1 : 0,
                'event_delete'      => request()->event_delete ? 1 : 0,
                'media_index'       => request()->media_index ? 1 : 0,
                'media_create'      => request()->media_create ? 1 : 0,
                'media_update'      => request()->media_update ? 1 : 0,
                'media_delete'      => request()->media_delete ? 1 : 0,
                'testimoni_index'   => request()->testimoni_index ? 1 : 0,
                'testimoni_create'  => request()->testimoni_create ? 1 : 0,
                'testimoni_update'  => request()->testimoni_update ? 1 : 0,
                'testimoni_delete'  => request()->testimoni_delete ? 1 : 0,
                'other_index'       => request()->other_index ? 1 : 0,
                'other_create'      => request()->other_create ? 1 : 0,
                'other_update'      => request()->other_update ? 1 : 0,
                'other_delete'      => request()->other_delete ? 1 : 0,
                'user_index'        => request()->user_index ? 1 : 0,
                'user_create'       => request()->user_create ? 1 : 0,
                'user_update'       => request()->user_update ? 1 : 0,
                'user_delete'       => request()->user_delete ? 1 : 0,
                'role_index'        => request()->role_index ? 1 : 0,
                'role_create'       => request()->role_create ? 1 : 0,
                'role_update'       => request()->role_update ? 1 : 0,
                'role_delete'       => request()->role_delete ? 1 : 0,
            ];

            $payload = [
                'name'          => request()->name,
                'access'        => json_encode($arrPermision),
                'is_deleted'    => 0
            ];
            $role = Role::create($payload);

            //log user
            $log = [
                'ref_name'  => 'm_roles',
                'ref_id'    => $role->id,
                'notes'     => 'menambahkan role',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('role.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $model = Role::findOrFail($id);
        try {
            $arrPermision = [
                'dashboard_index'   => request()->dashboard_index ? 1 : 0,
                'kategori_index'      => request()->kategori_index ? 1 : 0,
                'kategori_create'     => request()->kategori_create ? 1 : 0,
                'kategori_update'     => request()->kategori_update ? 1 : 0,
                'kategori_delete'     => request()->kategori_delete ? 1 : 0,
                'donasi_index'      => request()->donasi_index ? 1 : 0,
                'donasi_create'     => request()->donasi_create ? 1 : 0,
                'donasi_update'     => request()->donasi_update ? 1 : 0,
                'donasi_delete'     => request()->donasi_delete ? 1 : 0,
                'page_index'        => request()->page_index ? 1 : 0,
                'page_create'       => request()->page_create ? 1 : 0,
                'page_update'       => request()->page_update ? 1 : 0,
                'page_delete'       => request()->page_delete ? 1 : 0,
                'widget_index'      => request()->widget_index ? 1 : 0,
                'widget_create'     => request()->widget_create ? 1 : 0,
                'widget_update'     => request()->widget_update ? 1 : 0,
                'widget_delete'     => request()->widget_delete ? 1 : 0,
                'event_index'       => request()->event_index ? 1 : 0,
                'event_create'      => request()->event_create ? 1 : 0,
                'event_update'      => request()->event_update ? 1 : 0,
                'event_delete'      => request()->event_delete ? 1 : 0,
                'media_index'       => request()->media_index ? 1 : 0,
                'media_create'      => request()->media_create ? 1 : 0,
                'media_update'      => request()->media_update ? 1 : 0,
                'media_delete'      => request()->media_delete ? 1 : 0,
                'testimoni_index'   => request()->testimoni_index ? 1 : 0,
                'testimoni_create'  => request()->testimoni_create ? 1 : 0,
                'testimoni_update'  => request()->testimoni_update ? 1 : 0,
                'testimoni_delete'  => request()->testimoni_delete ? 1 : 0,
                'other_index'       => request()->other_index ? 1 : 0,
                'other_create'      => request()->other_create ? 1 : 0,
                'other_update'      => request()->other_update ? 1 : 0,
                'other_delete'      => request()->other_delete ? 1 : 0,
                'user_index'        => request()->user_index ? 1 : 0,
                'user_create'       => request()->user_create ? 1 : 0,
                'user_update'       => request()->user_update ? 1 : 0,
                'user_delete'       => request()->user_delete ? 1 : 0,
                'role_index'        => request()->role_index ? 1 : 0,
                'role_create'       => request()->role_create ? 1 : 0,
                'role_update'       => request()->role_update ? 1 : 0,
                'role_delete'       => request()->role_delete ? 1 : 0,
            ];

            $model->name = request()->name;
            $model->access = json_encode($arrPermision);

            $model->save();
            //log user
            $log = [
                'ref_name'  => 'm_roles',
                'ref_id'    => $id,
                'notes'     => 'mengubah role',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('role.index')->with('success', 'Edited successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $model = Role::findOrFail($id);
        // convert data access to array
        $model->access = json_decode($model->access);
        return view('page.role.edit', ['model' => $model]);
    }

    public function destroy($id){
        $role = Role::findOrFail($id);
        
        $role->is_deleted = 1;

        $role->save();

        return response()->json(['success' => true]);
    }
}
