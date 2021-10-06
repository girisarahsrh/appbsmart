<?php

namespace App\Http\Controllers\Anggaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MappingApp extends Controller
{
    public function index(){
        return view('Anggaran.MappingApp');
    }

    public function getMapping(Request $request){

        $mapping = DB::select(
            DB::raw(" 
                    select new_id_satker as satker, CONCAT('2021.',new_id_satker) as urutan  , satker as uraian, id as id,  CONCAT('SATKER') as label, parent_id as paguAkhir from r_satker where new_id_satker = ".$request->satker_id."
                UNION 
                    select satker_id as satker, CONCAT('2021.',satker_id) as urutan , nama as uraian, CONCAT('089.01.', kode) as id, CONCAT('PROGRAM') as label, pagu2 as paguAkhir from r_program where satker_id = ".$request->satker_id." and id like '%CH%' 
                UNION 
                    select satker_id as satker, program_id as urutan , nama as uraian, kode as id, CONCAT('KEGIATAN') as label, pagu2 as paguAkhir from r_kegiatan where satker_id = ".$request->satker_id." and id like '%CH%'
                UNION 
                    select satker_id as satker, id as urutan , nama as uraian, id as id, CONCAT('OUTPUT') as label, pagu2 as paguAkhir from r_output where satker_id = ".$request->satker_id." and id like '%CH%'
                UNION 
                    select satker_id as satker, id as urutan , nama as uraian, id as id, CONCAT('SUB OUTPUT') as label, pagu2 as paguAkhir from r_sub_output where satker_id = ".$request->satker_id." and id like '%CH%'
                UNION 
                    select satker_id as satker, id as urutan , nama as uraian, id as id, CONCAT('KOMPONEN') as label, pagu2 as paguAkhir from r_komponen where satker_id = ".$request->satker_id." and id like '%CH%'
                 UNION 
                    select satker_id as satker, id as urutan , nama as uraian, id as id, CONCAT('SUB KOMPONEN') as label , pagu2 as paguAkhir from r_sub_komponen where satker_id = ".$request->satker_id." and id like '%CH%'
                UNION 
                    select satker_id as satker, id as urutan , nama as uraian, id as id, CONCAT('MAK') as label , pagu2 as paguAkhir from r_mak where satker_id = ".$request->satker_id." and id like '%CH%'
                
                    
                    "
                )
        );

        return DataTables::of($mapping)->make(true);
    }

    function UpdateAnggaran(Request $request)
    {

    			DB::table('r_program')
    				->where('id', $request->id)
    				->update(['flag'=> $request->flag]);
    }
    

}
