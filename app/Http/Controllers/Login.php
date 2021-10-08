<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\UserSession;

class Login extends Controller
{

    protected $UserSession;

    public function __construct(UserSession $UserSession)

    {

        $this->UserSession = $UserSession;

    }

    public function index(){
        return view('Login.Login');
    }

    

    public function Auth(Request $request){
        $username = $request["username"];
        $password = $request["password"];

        $client = new \GuzzleHttp\Client(['verify' => false ]);

        $response = $client->request('POST', 'https://map.bpkp.go.id/api/v2/login', [
            'form_params' => [
                'username' => $username,
                'password' => $password,
                'kelas_user' => 0,
            ],
        ]);

        $body       = json_decode($response->getBody(), true);
        $res        = $this->UserSession->AuthSession($request, $body);
        return $res;
    }

    public function Success(){

        return view('Dashboard.Dashboard');
    }

    public function Logout(Request $request){

        $request->session()->forget('pegawai_nama');
        $request->session()->forget('pegawai_tk2_nama');
        $request->session()->forget('pegawai_tk2_id');
        $request->session()->forget('pegawai_rule_nama');
        $request->session()->forget('pegawai_rule_id');
        
        $request->session()->forget('pegawai_satker_id');
        $request->session()->forget('pegawai_satker_nama');
        return redirect('/');
    }

    
}