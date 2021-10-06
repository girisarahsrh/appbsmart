<?php

namespace App\Http\Controllers\Anggaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\DataTables\UsersDataTable;
use App\DataTables\UsersDataTablesEditor;

class PembagianPagu extends Controller
{
    public function index(){
        return view('Anggaran.PembagianPagu');
    }

    public function getAnggaran(Request $request){

        $anggaran = DB::select(
            DB::raw(" 

                    select new_id_satker as satker, CONCAT('2021.',new_id_satker) as urutan  , satker as uraian, id as id, parent_id as parent, parent_id as paguAkhir , CONCAT('SATKER') as label, flag as flag from r_satker where new_id_satker = ".$request->satker_id."
                UNION 
                    select satker_id as satker, CONCAT('2021.',satker_id) as urutan , nama as uraian, id as id, satker_id as parent, pagu2 as paguAkhir,  CONCAT('PROGRAM') as label, flag as flag from r_program where satker_id = ".$request->satker_id."
                UNION 
                    select satker_id as satker, program_id as urutan , nama as uraian, id as id, program_id as parent, pagu2 as paguAkhir , CONCAT('KEGIATAN') as label, flag as flag from r_kegiatan where satker_id = ".$request->satker_id."
                UNION 
                    select satker_id as satker, id as urutan , nama as uraian, id as id, kegiatan_id as parent, pagu2 as paguAkhir , CONCAT('OUTPUT') as label, flag as flag from r_output where satker_id = ".$request->satker_id."
                UNION 
                    select satker_id as satker, id as urutan , nama as uraian, id as id, output_id as parent, pagu2 as paguAkhir , CONCAT('SUB OUTPUT') as label, flag as flag from r_sub_output where satker_id = ".$request->satker_id."
                UNION 
                    select satker_id as satker, id as urutan , nama as uraian, id as id, sub_output_id as parent, pagu2 as paguAkhir , CONCAT('KOMPONEN') as label, flag as flag from r_komponen where satker_id = ".$request->satker_id."
                 UNION 
                    select satker_id as satker, id as urutan , nama as uraian, id as id, komponen_id as parent , pagu2 as paguAkhir , CONCAT('SUB KOMPONEN') as label, flag as flag from r_sub_komponen where satker_id = ".$request->satker_id."
                UNION 
                    select satker_id as satker, id as urutan , nama as uraian, id as id, sub_komponen_id as parent , pagu2 as paguAkhir , CONCAT('MAK') as label, flag as flag from r_mak where satker_id = ".$request->satker_id."
                
                    
                    "
                )
        );

        return DataTables::of($anggaran)->make(true);
    }

    function UpdateAnggaran(Request $request)
    {
        $trigger = $request->label;

        if($trigger == 'SATKER'){

            DB::table('r_program')
                        ->where('satker_id', $request->satker)
                        ->update(['flag'=> $request->flag]);
            DB::table('r_kegiatan')
                        ->where('satker_id', $request->satker)
                        ->update(['flag'=> $request->flag]);
            DB::table('r_output')
                        ->where('satker_id', $request->satker)
                        ->update(['flag'=> $request->flag]);
            DB::table('r_sub_output')
                        ->where('satker_id', $request->satker)
                        ->update(['flag'=> $request->flag]);
            DB::table('r_komponen')
                        ->where('satker_id', $request->satker)
                        ->update(['flag'=> $request->flag]);
            DB::table('r_sub_komponen')
                        ->where('satker_id', $request->satker)
                        ->update(['flag'=> $request->flag]);
            DB::table('r_mak')
                        ->where('satker_id', $request->satker)
                        ->update(['flag'=> $request->flag]);

                }else if($trigger == 'PROGRAM'){
                    $kegiatan = DB::table('r_kegiatan')
                        ->select('id as kegiatan_id')
                        ->where('program_id', $request->id)
                        ->get();

                    $output = DB::table('r_ouput')
                        ->select('id as output_id')
                        ->where('kegiatan_id', $kegiatan[0])
                        ->get();

                }else if($trigger == 'KEGIATAN'){
                    DB::table('r_kegiatan')
                            ->where('id', $request->id)
                            ->update(['flag'=> $request->flag]);

                }else if($trigger == 'OUTPUT'){
                    DB::table('r_output')
                            ->where('id', $request->id)
                            ->update(['flag'=> $request->flag]);

                }else if($trigger == 'SUB OUTPUT'){
                    DB::table('r_sub_output')
                            ->where('id', $request->id)
                            ->update(['flag'=> $request->flag]);

                }else if($trigger == 'KOMPONEN'){
                    DB::table('r_komponen')
                            ->where('id', $request->id)
                            ->update(['flag'=> $request->flag]);

                }else if($trigger == 'SUB KOMPONEN'){
                    DB::table('r_sub_komponen')
                            ->where('id', $request->id)
                            ->update(['flag'=> $request->flag]);

            }else{
                DB::table('r_mak')
                        ->where('id', $request->id)
                        ->update(['flag'=> $request->flag]);
            }
    	}
    

}
