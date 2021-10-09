<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Login;

class UserSession extends Controller
{
    

    public function AuthSession(Request $request,$body){

        $nip        = preg_replace('/\s+/', '', $body['message']['nipbaru']);
        $username   = preg_replace('/\s+/', '', $body['message']['username']);
        $satKer = $body['message']['namaunit'];
        // dd($body);

        $getUser = DB::table('userku')->selectRaw('userid')
                    ->where('userid',$nip)->groupBy('userid')->get();

       
        //dd($body);
        if(count($getUser) == 0){

            $this->InsertUserku($getUser, $nip);

        }

        $getSatker = DB::table('t_satker')->select('kdsatker as satker_id','nmsatker as satker_nama')
        ->where('nmsatker', 'like', '%' . $satKer . '%')->get();

        $getPegawai =DB::table('r_pegawai')
                    ->join('userku', 'userku.userid', '=', 'r_pegawai.nip')
                    ->join('r_rule', 'userku.new_id_rule', '=', 'r_rule.id_rule')
                    ->join('r_tk2', 'r_tk2.id', '=', 'r_pegawai.tk2_id')
                    ->select('r_pegawai.*',
                    'r_rule.nama as namarule', 
                    'userku.new_id_rule as idrule', 
                    'userku.new_id_pegawai as id', 
                    'userku.aktif as rule_aktif',
                    'r_tk2.nama as tk2_nama',
                    'r_tk2.id as tk2_id')
                    ->where('r_pegawai.nip', $nip)
                    ->where('userku.aktif', 1)
                    ->get();
        $request->session()->put('pegawai_nama',$getPegawai[0]->nama);
        $request->session()->put('pegawai_tk2_nama',$getPegawai[0]->tk2_nama);
        $request->session()->put('pegawai_tk2_id',$getPegawai[0]->tk2_id);
        $request->session()->put('pegawai_rule_nama',$getPegawai[0]->namarule);
        $request->session()->put('pegawai_rule_id',$getPegawai[0]->idrule);
        
        $request->session()->put('pegawai_satker_id',$getSatker[0]->satker_id);
        $request->session()->put('pegawai_satker_nama',$getSatker[0]->satker_nama);

        return redirect('/Dashboard');
        
    }
    public function InsertUserku($getUser, $nip){

        $getPegawai = DB::table('r_pegawai')->select('id','nip')->where('nip',$nip)->get();
        DB::table('userku')
            ->insert([ 
            "userid" => $nip,
            "aktif" => 1 ,
            "new_id_pegawai" => $getPegawai[0]->id,
            "new_id_rule" => 24
            ]);

            return $getPegawai;

    }
   




    
}