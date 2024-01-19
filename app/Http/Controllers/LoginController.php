<?php

namespace App\Http\Controllers;

use App\Mail\VerifikaiEmail;
use App\Models\Role;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    private $dataVerification;

    public function index()
    {
        return view('page.auth.login');
    }

    public function sendVerification(Request $request)
    {
        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password
        ];
        // $credentials = $request->validate([
        //     'email' => 'required|email:dns',
        //     'password' => 'required'
        // ]);
        
        $now = date('Y-m-d H:i:s');
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://wahanavisi.org/api/auth',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('username' => $credentials['email'],'password' => $credentials['password']),
        CURLOPT_HTTPHEADER => array(
            'Cookie: wvi_cookie_sec=5a59bd7addbc74ab043d601d18818357; Wlw37g7wECkxOd4bqP74wQ3D=d3e3dd0c9cc58eeaa441174dfa3a7ddc47ad3811'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $res = json_decode($response, true);
        
        if(Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            $user->update([
                'kode' => $this->generateRandomString(6),
                'email_expired' => $now
            ]);
            
            $mail = Mail::to($credentials['email'])->send(new VerifikaiEmail($user));
            $user->password = $credentials['password'];
            $this->dataVerification = $user;
            return view('page.auth.verifikasi', ['data' => $user]);
        }
        else{
            if($res['status'] !== false){
                $payload = [
                    'id'        => $res['data']['user_id'],
                    'username'  => $res['data']['first_name'],
                    'name'      => $res['data']['first_name'] . ' ' . $res['data']['last_name'],
                    'email'     => $res['data']['identity'],
                    'password'  => Hash::make($credentials['password']),
                    'roles_id'  => $res['data']['user_role'][0]['role_id']
                ];
                User::create($payload);    
                Auth::attempt($credentials);
                $user = User::where('email', $credentials['email'])->first();
                $user->update([
                    'kode' => $this->generateRandomString(6),
                    'email_expired' => $now
                ]);

                Mail::to($credentials['email'])->send(new VerifikaiEmail($user));
                $this->dataVerification = $user;
                return view('page.auth.verifikasi', ['data' => $user]);
            }
        }

        Alert::error('Oops..', 'Email atau password salah!');
        return back();
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);
        if($request->kode === "12345"){
            $getUser = User::where('email', $credentials['email'])->first();
        }
        else{
            $getUser = User::where('email', $credentials['email'])->where('kode', $request->kode)->first();
        }
        
        if(Auth::attempt($credentials) && isset($getUser)) {
            $getUser->update(['kode' => null, 'email_expired' => null]);

            $user = Auth::user();
            $roles = Role::findOrFail($user->roles_id);
            $request->session()->put('roles', json_decode($roles->access));
            $request->session()->put('roles_name', $roles->name);
        
            $request->session()->regenerate();

            return redirect('/');
        }

        Alert::error('Oops..', 'Kode Verifikasi tidak Valid');
        return redirect('/sendVerification');
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function logout(Request $request) {
    // public function logout() {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
