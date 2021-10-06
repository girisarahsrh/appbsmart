<?php

namespace App\Http\Controllers\Dropdown;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dropdown extends Controller
{
    public function Sex(Request $request)

    {
            $Sex = DB::table('r_sex')
                        ->select('*')
                        ->get();

        return response()->json($Sex);

    }

    public function findtingkat1(Request $request)

    {

            if(!empty($request->search)){
                $tk1combo = DB::table('r_tk1')
                ->select('*')
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
            }else{
            $tk1combo = DB::table('r_tk1')
            ->select('*')
            ->get();
            }


        return response()->json($tk1combo);

    }

    public function findtingkat2_req(Request $request)

    {

            if(!empty($request->search)){
                $tk2combo = DB::table('r_tk2')
                ->select('*')
                ->where("tk1_id", $request->tk1)
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
            }else{
            $tk2combo = DB::table('r_tk2')
            ->select('*')
            ->where("tk1_id", $request->tk1)
            ->get();
            }


        return response()->json($tk2combo);

    }

    public function findtingkat2(Request $request)

    {

            if(!empty($request->search)){
                $tk2combo = DB::table('r_tk2')
                ->select('*')
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
            }else{
            $tk2combo = DB::table('r_tk2')
            ->select('*')
            ->get();
            }


        return response()->json($tk2combo);

    }

    public function findtingkat2_multiple(Request $request)

    {

            if(!empty($request->search)){
                $tk2combo = DB::table('r_tk2')
                ->select('*')
                ->where("tk1_id", $request->tk1)
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
            }else{
                $tk2combo = DB::table('r_tk2')
                ->select('*')
                ->where("tk1_id", $request->tk1)
                ->get();
            }


        return response()->json($tk2combo);

    }

    public function findtingkat3(Request $request)

    {

        $tk2 = $request->tk2;

        if (isset($tk2)) {
            if(!empty($request->search)){
                $tk3combo = DB::table('r_tk3')
                ->select('*')
                ->where('r_tk3.tk2_id', $tk2)
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $tk3combo = DB::table('r_tk3')
                ->select('*')
                ->where('r_tk3.tk2_id', $tk2)
                ->get();
                }
            
       }else{
            if(!empty($request->search)){
                $tk3combo = DB::table('r_tk3')
                ->select('*')
                ->whereIn('r_tk3.tk2_id', $tk2)
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $tk3combo = DB::table('r_tk3')
                ->select('*')
                ->whereIn('r_tk3.tk2_id', $tk2)
                ->get();
                }
       }

        return response()->json($tk3combo);

    }

    public function findtingkat4(Request $request)

    {

        $tk3 = $request->tk3;

            if(!empty($request->search)){
                $tk4combo = DB::table('r_tk4')
                ->select('*')
                ->where('r_tk4.tk3_id', $tk3)
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $tk4combo = DB::table('r_tk4')
                ->select('*')
                ->where('r_tk4.tk3_id', $tk3)
                ->get();
                }


        // return response()->json($tk2combo);
        //     $tk3 = DB::table('r_tk3')
        //                 ->select('*')
        //                 ->get();

        return response()->json($tk4combo);

    }

    public function findgolongan(Request $request)

    {

            if(!empty($request->search)){
                $golongancombo = DB::table('r_golongan')
                ->select('*')
                ->where("nama", "LIKE", "%{$request->search}%")
                ->orWhere("pangkat", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $golongancombo = DB::table('r_golongan')
                ->select('*')
                ->get();
                }


        // return response()->json($tk2combo);
        //     $tk3 = DB::table('r_tk3')
        //                 ->select('*')
        //                 ->get();

        return response()->json($golongancombo);

    }

    public function findeselon(Request $request)

    {

            if(!empty($request->search)){
                $eseloncombo = DB::table('r_eselon')
                ->select('*')
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $eseloncombo = DB::table('r_eselon')
                ->select('*')
                ->get();
                }


        // return response()->json($tk2combo);
        //     $tk3 = DB::table('r_tk3')
        //                 ->select('*')
        //                 ->get();

        return response()->json($eseloncombo);

    }

    public function findaktif(Request $request)

    {

            if(!empty($request->search)){
                $aktifcombo = DB::table('r_aktif')
                ->select('*')
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $aktifcombo = DB::table('r_aktif')
                ->select('*')
                ->get();
                }


        // return response()->json($tk2combo);
        //     $tk3 = DB::table('r_tk3')
        //                 ->select('*')
        //                 ->get();

        return response()->json($aktifcombo);

    }

    public function findbank(Request $request)

    {

            if(!empty($request->search)){
                $bankcombo = DB::table('r_bank')
                ->select('*')
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $bankcombo = DB::table('r_bank')
                ->select('*')
                ->get();
                }
        return response()->json($bankcombo);

    }

    public function findjenis(Request $request)

    {

            if(!empty($request->search)){
                $jeniscombo = DB::table('r_jenis')
                ->select('*')
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $jeniscombo = DB::table('r_jenis')
                ->select('*')
                ->get();
                }
        return response()->json($jeniscombo);

    }

    public function findhak(Request $request)

    {

            if(!empty($request->search)){
                $hakcombo = DB::table('r_rule')
                ->select('*')
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $hakcombo = DB::table('r_rule')
                ->select('*')
                ->get();
                }
        return response()->json($hakcombo);

    }

    public function findhak_Rule(Request $request)

    {

            if(!empty($request->search)){

                    if($request->rule_session == 2){
                        $hakcombo = DB::table('r_rule')->select('r_rule.id_rule','r_rule.nama')
                        ->whereRaw("id_rule NOT IN (SELECT r_rule.id_rule FROM r_rule join userku on userku.new_id_rule = r_rule.id_rule where userku.new_id_pegawai = ".$request->new_id_user.")")
                        ->where("nama", "LIKE", "%{$request->search}%")
                        ->where("id_rule", "!=", 1)
                        ->where("id_rule", "!=", 11)
                        ->get();
                    }else if ($request->rule_session == 11){
                        $hakcombo = DB::table('r_rule')->select('r_rule.id_rule','r_rule.nama')
                        ->whereRaw("id_rule NOT IN (SELECT r_rule.id_rule FROM r_rule join userku on userku.new_id_rule = r_rule.id_rule where userku.new_id_pegawai = ".$request->new_id_user.")")
                        ->where("nama", "LIKE", "%{$request->search}%")
                        ->where("id_rule", "!=", 1)
                        ->where("id_rule", "!=", 2)
                        ->get();

                    }else{
                        $hakcombo = DB::table('r_rule')->select('r_rule.id_rule','r_rule.nama')
                        ->whereRaw("id_rule NOT IN (SELECT r_rule.id_rule FROM r_rule join userku on userku.new_id_rule = r_rule.id_rule where userku.new_id_pegawai = ".$request->new_id_user.")")
                        ->where("nama", "LIKE", "%{$request->search}%")
                        ->where("id_rule", "!=", 1)
                        ->get();
                    }
            }else{
                    if($request->rule_session == 2){
                        $hakcombo = DB::table('r_rule')->select('r_rule.id_rule','r_rule.nama')
                        ->whereRaw("id_rule NOT IN (SELECT r_rule.id_rule FROM r_rule join userku on userku.new_id_rule = r_rule.id_rule where userku.new_id_pegawai = ".$request->new_id_user.")")
                        ->where("id_rule", "!=", 1)
                        ->where("id_rule", "!=", 11)
                        ->get();
                    }else if ($request->rule_session == 11){
                        $hakcombo = DB::table('r_rule')->select('r_rule.id_rule','r_rule.nama')
                        ->whereRaw("id_rule NOT IN (SELECT r_rule.id_rule FROM r_rule join userku on userku.new_id_rule = r_rule.id_rule where userku.new_id_pegawai = ".$request->new_id_user.")")
                        ->where("id_rule", "!=", 1)
                        ->where("id_rule", "!=", 2)
                        ->get();

                    }else{
                        $hakcombo = DB::table('r_rule')->select('r_rule.id_rule','r_rule.nama')
                        ->whereRaw("id_rule NOT IN (SELECT r_rule.id_rule FROM r_rule join userku on userku.new_id_rule = r_rule.id_rule where userku.new_id_pegawai = ".$request->new_id_user.")")
                        ->where("nama", "LIKE", "%{$request->search}%")
                        ->where("id_rule", "!=", 1)
                        ->get();
                    }
                }
        return response()->json($hakcombo);

    }

    public function findsex(Request $request)

    {

            if(!empty($request->search)){
                $sexcombo = DB::table('r_sex')
                ->select('*')
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $sexcombo = DB::table('r_sex')
                ->select('*')
                ->get();
                }
        return response()->json($sexcombo);

    }

    public function findagama(Request $request)

    {

            if(!empty($request->search)){
                $agamacombo = DB::table('r_agama')
                ->select('*')
                ->where("nama", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $agamacombo = DB::table('r_agama')
                ->select('*')
                ->get();
                }
        return response()->json($agamacombo);

    }

    public function findsatker(Request $request)

    {

            if(!empty($request->search)){
                $satkercombo = DB::table('r_satker')
                ->select('*')
                ->where("satker", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $satkercombo = DB::table('r_satker')
                ->select('*')
                ->get();
                }
        return response()->json($satkercombo);

    }

    public function findapp(Request $request)

    {

            if(!empty($request->search)){
                $appcombo = DB::table('t_app')
                ->select('*')
                ->where("nama_app", "LIKE", "%{$request->search}%")
                ->get();
                }else{
                $appcombo = DB::table('t_app')
                ->select('*')
                ->get();
                }
        return response()->json($appcombo);

    }
}
