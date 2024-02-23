<?php

namespace App\Http\Controllers;

use App\Models\LogUser;
use App\Models\Role;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as Generator;

class UserController extends Controller
{
    public function index(Request $request) {
        $role = Role::where('is_deleted', 0)->get();
        $arr = [];
        foreach ($role as $key => $value) {
            $arr[] = $value->name;
        }
        $listRole = array_values(array_unique($arr));

        $model = User::select('users.*', 'm_roles.name as roles_name')->leftJoin('m_roles', 'users.roles_id', '=', 'm_roles.id')->latest();

        if(isset($request->status)){
            $model->where('m_roles.name', $request->status);
        }
        if(isset($request->search)){
            $model->where('users.name', 'like', '%' . $request->search . '%')
                ->orWhere('users.email', 'like',  '%' . $request->search . '%')
                ->orWhere('users.username', 'like',  '%' . $request->search . '%');
        }

        $model = $model->paginate(10);
        return view('page.user.index', ['list' => $model, 'listRole' => $listRole]);
    }

    public function create() {
        $roles = Role::where('is_deleted', 0)->get();

        return view('page.user.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $url = env('IMG_URL').'img/media/originals/';
        $image = str_replace($url, "", $request->photo);

        try {
            $payload = [
                "username" => $request->username,
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "phone_code" => '+62',
                "phone_number" => $request->phone_number,
                "address" => $request->address,
                "roles_id" => $request->roles,
                'photo' => $image
            ];

            $user = User::create($payload);

            //log user
            $log = [
                'ref_name'  => 'users',
                'ref_id'    => $user->id,
                'notes'     => 'menambahkan user',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('user.index')->with('success', 'Saved successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $model = User::findOrFail($id);
        try {
            $payload = [
                "username" => $request->username,
                "name" => $request->name,
                "email" => $request->email,
                "phone_code" => '+62',
                "phone_number" => $request->phone_number,
                "address" => $request->address,
                "roles_id" => $request->roles,
            ];

            if (isset($request->password)) {
                $payload["password"] = $request->password;
            }

            if (isset($request->photo)) {
                $url = env('IMG_URL').'img/media/originals/';
                $img = str_replace($url, "", $request->photo);

                $payload["photo"] = $img;
            }

            $model->update($payload);

            //log user
            $log = [
                'ref_name'  => 'users',
                'ref_id'    => $id,
                'notes'     => 'mengubah user',
                'created_by'=> auth()->user()->id
            ];
            LogUser::create($log);
            return redirect()->route('user.index')->with('success', 'Edit successfully.');
        } catch (Exception $e) {
            Alert::error('Error', 'There is an error.');
            return back();
        }
    }

    public function edit($id)
    {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $model = User::findOrFail($id);
        $roles = Role::where('is_deleted', 0)->get();
        $model->photo = $url . $model->photo;
        return view('page.user.edit', ['model' => $model, 'roles' => $roles]);
    }

    public function destroy($id){
        $role = User::findOrFail($id);
        $role->delete();

        return response()->json(['success' => true]);
    }

    public function checkEmail(Request $request){

    }

    public function register(Request $request)
    {
        $payload = [
            "id"        => Generator::uuid4()->toString(),
            "username"  => $request->username,
            "name"      => $request->name,
            "email"     => $request->email,
            "password"  => Hash::make($request->password),
            "phone_code" => '+62',
            "phone_number" => $request->phone_number,
            "address" => $request->address
        ];

        $user = User::create($payload);

        //log user
        $log = [
            'ref_name'  => 'users',
            'ref_id'    => $payload['id'],
            'notes'     => 'Customer '. $payload['name'] .' Mendaftar',
            'created_by'=> $payload['id']
        ];
        LogUser::create($log);

        if($user){
            return response()->json(['status_code' => 200, 'data' => $user], 200);
        }
        else{
            return response()->json(['status_code' => 422, 'pesan' => 'Data Tidak ada'], 422);
        }
    }
}
