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
            DB::raw('
                    SELECT 
                            d_pagu.kdindex as kode_index, 
                            d_pagu.rupiah as rupiah, 
                            d_pagu.thang as kode_thang ,
                            d_pagu.kdsatker as kode_satker ,

                            CONCAT("089.01.",d_pagu.kdprogram) as kode_program, 
                            CONCAT(d_pagu.kdprogram) as without_concat_kode_program,

                            d_pagu.kdgiat as kode_kegiatan, 

                            CONCAT(d_pagu.kdgiat,".",d_pagu.kdoutput) as kode_output,
                            CONCAT(d_pagu.kdoutput) as without_concat_kode_output, 

                            CONCAT(d_pagu.kdgiat,".",d_pagu.kdoutput,".",d_pagu.kdsoutput) as kode_sub_output,
                            CONCAT(d_pagu.kdsoutput) as without_concat_kode_sub_output, 

                            d_pagu.kdkmpnen as kode_komponen, 

                            CONCAT(d_pagu.kdskmpnen,")") as kode_sub_komponen, 
                            CONCAT(d_pagu.kdskmpnen) as without_concat_kode_sub_komponen, 

                            d_pagu.kdakun as kode_akun, 
                            d_pagu.kdbeban as kode_beban, 
                            d_pagu.kdib as kode_ib ,
                            d_bagipagu.id_unit as id_unit, 
                            d_bagipagu.id_ppk as id_ppk
                    FROM d_pagu 
                    LEFT JOIN d_bagipagu ON d_pagu.kdindex = d_bagipagu.kdindex 
                    LEFT JOIN t_satker ON d_pagu.kdsatker = t_satker.kdsatker
                    where d_pagu.kdsatker = '.$request->satker_id.'
                    '
                )
        );
        // $anggaran = DB::table('d_pagu')
        //                 ->select(
        //                     'd_pagu.kdindex as kode_index', 
        //                     'd_pagu.rupiah as rupiah', 
        //                     'd_pagu.thang as kode_thang' ,
        //                     'd_pagu.kdsatker as kode_satker' ,
        //                     'd_pagu.kdprogram as kode_program', 
        //                     'd_pagu.kdgiat as kode_kegiatan', 
        //                     'd_pagu.kdoutput as kode_output', 
        //                     'd_pagu.kdsoutput as kode_sub_output', 
        //                     'd_pagu.kdkmpnen as kode_komponen', 
        //                     'd_pagu.kdskmpnen as kode_sub_komponen', 
        //                     'd_pagu.kdakun as kode_akun', 
        //                     'd_pagu.kdbeban as kode_beban', 
        //                     'd_pagu.kdib as kode_ib' ,
        //                     'd_bagipagu.id_unit as id_unit', 
        //                     'd_bagipagu.id_ppk as id_ppk')
        //                 ->join('d_bagipagu','d_pagu.kdindex','=','d_bagipagu.kdindex','left')
        //                 ->join('t_satker','d_pagu.kdsatker','=','t_satker.kdsatker','left')

        //                 ->where('d_pagu.kdsatker',$request->satker_id)
        //                 ->get();

        return DataTables::of($anggaran)->make(true);
    }

    // public function getAnggaran(Request $request){

    //     $anggaran = DB::select(
    //         DB::raw(" 

    //                 select new_id_satker as satker, CONCAT('2021.',new_id_satker) as urutan  , satker as uraian, id as id, parent_id as parent, parent_id as paguAkhir , CONCAT('SATKER') as label, flag as flag from r_satker where new_id_satker = ".$request->satker_id."
    //             UNION 
    //                 select satker_id as satker, CONCAT('2021.',satker_id) as urutan , nama as uraian, id as id, satker_id as parent, pagu2 as paguAkhir,  CONCAT('PROGRAM') as label, flag as flag from r_program where satker_id = ".$request->satker_id."
    //             UNION 
    //                 select satker_id as satker, program_id as urutan , nama as uraian, id as id, program_id as parent, pagu2 as paguAkhir , CONCAT('KEGIATAN') as label, flag as flag from r_kegiatan where satker_id = ".$request->satker_id."
    //             UNION 
    //                 select satker_id as satker, id as urutan , nama as uraian, id as id, kegiatan_id as parent, pagu2 as paguAkhir , CONCAT('OUTPUT') as label, flag as flag from r_output where satker_id = ".$request->satker_id."
    //             UNION 
    //                 select satker_id as satker, id as urutan , nama as uraian, id as id, output_id as parent, pagu2 as paguAkhir , CONCAT('SUB OUTPUT') as label, flag as flag from r_sub_output where satker_id = ".$request->satker_id."
    //             UNION 
    //                 select satker_id as satker, id as urutan , nama as uraian, id as id, sub_output_id as parent, pagu2 as paguAkhir , CONCAT('KOMPONEN') as label, flag as flag from r_komponen where satker_id = ".$request->satker_id."
    //              UNION 
    //                 select satker_id as satker, id as urutan , nama as uraian, id as id, komponen_id as parent , pagu2 as paguAkhir , CONCAT('SUB KOMPONEN') as label, flag as flag from r_sub_komponen where satker_id = ".$request->satker_id."
    //             UNION 
    //                 select satker_id as satker, id as urutan , nama as uraian, id as id, sub_komponen_id as parent , pagu2 as paguAkhir , CONCAT('MAK') as label, flag as flag from r_mak where satker_id = ".$request->satker_id."
                
                    
    //                 "
    //             )
    //     );

    //     return DataTables::of($anggaran)->make(true);
    // }

    function UpdateAnggaran(Request $request)
    {

        $countBagipagu = DB::table('d_bagipagu')
                            ->select('kdindex')
                            ->where('kdindex',$request->kdindex)
                            ->get();

        if(count($countBagipagu) == 0){
            if($request->Trigger == "unit"){

                DB::table('d_bagipagu')
                        ->insert([
                            'kdindex'=> $request->kdindex,
                            'kdsatker'=> $request->kdsatker,
                            'id_unit'=> $request->idunit,
                            // 'id_ppk'=> $request->idppk,

                        ]);

            }else{
                DB::table('d_bagipagu')
                ->insert([
                    'kdindex'=> $request->kdindex,
                    'kdsatker'=> $request->kdsatker,
                    'id_ppk'=> $request->idppk,

                ]);
            }
           
        }else{
            if($request->Trigger == "unit"){
                DB::table('d_bagipagu')
                        ->where('kdindex', $request->kdindex)
                        ->update([
                            'id_unit'=> $request->idunit
                        
                        ]);
            }else{
                DB::table('d_bagipagu')
                            ->where('kdindex', $request->kdindex)
                            ->update([
                                'id_ppk'=> $request->idppk
                            
                        ]);
            }
        }
               
    }

    function EditUnit(Request $request) {
        $Trigger = $request->trigger;

        if($Trigger == "program"){
                $kode = "kdprogram";
            }else if($Trigger == "kegiatan"){
                $kode = "kdgiat";
            }else if($Trigger == "output"){
                $kode = "kdoutput";
            }else if($Trigger == "sub_output"){
                $kode = "kdsoutput";
            }else if($Trigger == "komponen"){
                $kode = "kdkmpnen";
            }else if($Trigger == "sub_komponen"){
                $kode = "kdskmpnen";
        }

        $edit = 

        DB::select(
                    DB::raw(" 
        
                    SELECT 
                    t_unitkerja.id as id_unitkerja,
                    t_unitkerja.nama_unit as nama_unitkerja,
                    d_pagu.kdsatker as kode_satker,
                    d_pagu.kdindex as kode_index,

                    SUBSTRING(d_pagu.kdindex, 11, 2) AS kode_program,
                    SUBSTRING(d_pagu.kdindex, 13, 4) AS kode_kegiatan,
                    SUBSTRING(d_pagu.kdindex, 17, 3) AS kode_output,
                    SUBSTRING(d_pagu.kdindex, 20, 3) AS kode_sub_output,
                    SUBSTRING(d_pagu.kdindex, 23, 3) AS kode_komponen,
                    SUBSTRING(d_pagu.kdindex, 26, 3) AS kode_sub_komponen
                    
                    FROM
                    d_pagu

                    LEFT JOIN t_unitkerja ON d_pagu.kdsatker = t_unitkerja.id_satker
                    
                    WHERE d_pagu.".$kode." LIKE '%".$request->id."%'
                            "
                        )
                );
        // DB::table('d_pagu')
        //     ->join('t_unitkerja', 'd_pagu.kdsatker','=', 't_unitkerja.id_satker','left')
        //     ->select(
        //     't_unitkerja.id as id_unitkerja', 
        //     't_unitkerja.nama_unit as nama_unitkerja',
        //     'd_pagu.kdgiat as kode_kegiatan',
        //     'd_pagu.kdsatker as kode_satker',
        //     'd_pagu.kdindex as kode_index',

        //     'd_pagu.kdindex as kode_index'

        //     )->where('d_pagu.'.$kode.'', 'LIKE','%'.$request->id.'%')
        //     ->get();

            return response()->json($edit);
    }

    public function UpdateUnit(Request $request)
        {       

            $Trigger = $request->trigger;

                if($Trigger == "program"){
                        $kode = "kdprogram";

                        $selectBagiPagu = DB::table('d_pagu')
                        ->select('kdindex')
                        ->where(''.$kode.'',$request->kode)
                        ->get();

                    }else if($Trigger == "kegiatan"){
                        $kode = "kdgiat";
                        $program = "kdprogram";
                        
                        $selectBagiPagu = DB::table('d_pagu')
                                ->select('kdindex')
                                ->where(''.$kode.'',$request->kode)
                                ->where(''.$program.'',$request->kode_program)
                                ->get();

                    }else if($Trigger == "output"){
                        $kode = "kdoutput";
                        $program = "kdprogram";
                        $kegiatan = "kdgiat";

                        $selectBagiPagu = DB::table('d_pagu')
                                ->select('kdindex')
                                ->where(''.$kode.'',$request->kode)
                                ->where(''.$program.'',$request->kode_program)
                                ->where(''.$kegiatan.'',$request->kode_kegiatan)
                                ->get();
                    }else if($Trigger == "sub_output"){
                        $kode = "kdsoutput";
                        $program = "kdprogram";
                        $kegiatan = "kdgiat";
                        $output = "kdoutput";

                        $selectBagiPagu = DB::table('d_pagu')
                                ->select('kdindex')
                                ->where(''.$kode.'',$request->kode)
                                ->where(''.$program.'',$request->kode_program)
                                ->where(''.$kegiatan.'',$request->kode_kegiatan)
                                ->where(''.$output.'',$request->kode_output)
                                ->get();


                    }else if($Trigger == "komponen"){
                        $kode = "kdkmpnen";
                        $program = "kdprogram";
                        $kegiatan = "kdgiat";
                        $output = "kdoutput";
                        $suboutput = "kdsoutput";

                        $selectBagiPagu = DB::table('d_pagu')
                                ->select('kdindex')
                                ->where(''.$kode.'',$request->kode)
                                ->where(''.$program.'',$request->kode_program)
                                ->where(''.$kegiatan.'',$request->kode_kegiatan)
                                ->where(''.$output.'',$request->kode_output)
                                ->where(''.$suboutput.'',$request->kode_sub_output)
                                ->get();


                    }else if($Trigger == "sub_komponen"){
                        $kode = "kdskmpnen";
                        $program = "kdprogram";
                        $kegiatan = "kdgiat";
                        $output = "kdoutput";
                        $suboutput = "kdsoutput";
                        $komponen = "kdkmpnen";

                        $selectBagiPagu = DB::table('d_pagu')
                                ->select('kdindex')
                                ->where(''.$kode.'',$request->kode)
                                ->where(''.$program.'',$request->kode_program)
                                ->where(''.$kegiatan.'',$request->kode_kegiatan)
                                ->where(''.$output.'',$request->kode_output)
                                ->where(''.$suboutput.'',$request->kode_sub_output)
                                ->where(''.$komponen.'',$request->kode_komponen)
                                ->get();
                }


            // $selectBagiPagu = DB::table('d_pagu')
            //                     ->select('kdindex')
            //                     ->where(''.$kode.'',$request->kode)
            //                     ->get();

                               // dd($selectBagiPagu[1]->kdindex);

                // DB::table('d_bagipagu')
                // ->where("kdindex",'LIKE','%'.$request->kode.'%')
                // ->delete();

                // for($i= 0; $i < count($selectBagiPagu); $i++ ){
                   
                //     DB::table('d_bagipagu')
                //         ->insert([
                //         "id_unit" => $request->unitselect2,
                //         "kdsatker" => $request->kode_satker,
                //         "kdindex" => $selectBagiPagu[$i]->kdindex,
                        
                //     ]);
                // }

                $countBagiPagu = 
                DB::table('d_bagipagu')
                ->select('kdindex')
                ->where("kdindex",'LIKE','%'.$request->kode.'%')
                ->get();

                if(count($countBagiPagu)==0){
                    for($i= 0; $i < count($selectBagiPagu); $i++ ){
                   
                        DB::table('d_bagipagu')
                            ->insert([
                            "id_unit" => $request->unitselect2,
                            "kdsatker" => $request->kode_satker,
                            "kdindex" => $selectBagiPagu[$i]->kdindex,
                            
                        ]);
                    }
                }else{

                    if(count($selectBagiPagu) == 0){
                        for($i= 0; $i < count($selectBagiPagu); $i++ ){
    
                            DB::table('d_bagipagu')
                                ->insert([
                                "id_unit" => $request->unitselect2,
                                "kdsatker" => $request->kode_satker,
                                "kdindex" => $selectBagiPagu[$i]->kdindex,
                                
                            ]);
                        }
                    }else{
                        for($i= 0; $i < count($selectBagiPagu); $i++ ){
                   
                            DB::table('d_bagipagu')
                                ->where('kdindex', $selectBagiPagu[$i]->kdindex)
                                ->update([
                                "id_unit" => $request->unitselect2,
                                
                            ]);
                    }
                    
                    }
                }
                
            return redirect('/PembagianPagu');
                
        }

        public function UpdatePpk(Request $request)
        {       

            $Trigger = $request->trigger;

                if($Trigger == "program"){
                        $kode = "kdprogram";

                        $selectBagiPagu = DB::table('d_pagu')
                        ->select('kdindex')
                        ->where(''.$kode.'',$request->kode)
                        ->get();
                        


                    }else if($Trigger == "kegiatan"){
                        $kode = "kdgiat";
                        $program = "kdprogram";
                        
                        $selectBagiPagu = DB::table('d_pagu')
                                ->select('kdindex')
                                ->where(''.$kode.'',$request->kode)
                                ->where(''.$program.'',$request->kode_program)
                                ->get();

                    }else if($Trigger == "output"){
                        $kode = "kdoutput";
                        $program = "kdprogram";
                        $kegiatan = "kdgiat";

                        $selectBagiPagu = DB::table('d_pagu')
                                ->select('kdindex')
                                ->where(''.$kode.'',$request->kode)
                                ->where(''.$program.'',$request->kode_program)
                                ->where(''.$kegiatan.'',$request->kode_kegiatan)
                                ->get();
                    }else if($Trigger == "sub_output"){
                        $kode = "kdsoutput";
                        $program = "kdprogram";
                        $kegiatan = "kdgiat";
                        $output = "kdoutput";

                        $selectBagiPagu = DB::table('d_pagu')
                                ->select('kdindex')
                                ->where(''.$kode.'',$request->kode)
                                ->where(''.$program.'',$request->kode_program)
                                ->where(''.$kegiatan.'',$request->kode_kegiatan)
                                ->where(''.$output.'',$request->kode_output)
                                ->get();


                    }else if($Trigger == "komponen"){
                        $kode = "kdkmpnen";
                        $program = "kdprogram";
                        $kegiatan = "kdgiat";
                        $output = "kdoutput";
                        $suboutput = "kdsoutput";

                        $selectBagiPagu = DB::table('d_pagu')
                                ->select('kdindex')
                                ->where(''.$kode.'',$request->kode)
                                ->where(''.$program.'',$request->kode_program)
                                ->where(''.$kegiatan.'',$request->kode_kegiatan)
                                ->where(''.$output.'',$request->kode_output)
                                ->where(''.$suboutput.'',$request->kode_sub_output)
                                ->get();


                    }else if($Trigger == "sub_komponen"){

                        
                        $kode = "kdskmpnen";
                        $program = "kdprogram";
                        $kegiatan = "kdgiat";
                        $output = "kdoutput";
                        $suboutput = "kdsoutput";
                        $komponen = "kdkmpnen";

                        $selectBagiPagu = DB::table('d_pagu')
                                ->select('kdindex')
                                ->where(''.$kode.'',$request->kode)
                                ->where(''.$program.'',$request->kode_program)
                                ->where(''.$kegiatan.'',$request->kode_kegiatan)
                                ->where(''.$output.'',$request->kode_output)
                                ->where(''.$suboutput.'',$request->kode_sub_output)
                                ->where(''.$komponen.'',$request->kode_komponen)
                                ->get();
                }
                $countBagiPagu = 
                DB::table('d_bagipagu')
                ->select('kdindex')
                ->where("kdindex",'LIKE','%'.$request->kode.'%')
                ->get();

                if(count($countBagiPagu)==0){
                    for($i= 0; $i < count($selectBagiPagu); $i++ ){
                   
                        DB::table('d_bagipagu')
                            ->insert([
                            "id_ppk" => $request->ppkselect2,
                            "kdsatker" => $request->kode_satker,
                            "kdindex" => $selectBagiPagu[$i]->kdindex,
                            
                        ]);
                    }
                }else{

                    if(count($selectBagiPagu) == 0){
                        for($i= 0; $i < count($selectBagiPagu); $i++ ){
    
                            DB::table('d_bagipagu')
                                ->insert([
                                "id_ppk" => $request->ppkselect2,
                                "kdsatker" => $request->kode_satker,
                                "kdindex" => $selectBagiPagu[$i]->kdindex,
                                
                            ]);
                        }
                    }else{
                        for($i= 0; $i < count($selectBagiPagu); $i++ ){
                   
                            DB::table('d_bagipagu')
                            ->where('kdindex', $selectBagiPagu[$i]->kdindex)
                            ->update([
                            "id_ppk" => $request->ppkselect2,
                            
                        ]);
                        }
                    
                    }
                }

                
                
            return redirect('/PembagianPagu');
                
        }

}
