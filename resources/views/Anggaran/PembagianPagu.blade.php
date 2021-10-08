@include('_uiAssets.Header')
<body>

    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        @include('_uiComponent.Upside')
        @include('_uiComponent.Aside')

        <div class="page-wrapper">

            <div class="container-fluid">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <form action="/Auth" method="POST" >
                                        @csrf

                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-lg-2" style="padding-top: 5px;">
                                                    <label>Tahun</label>
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="form-group">
                                                       <input class="form-control" type="number" min="1900" max="2022">
                                                    </div>
                                                </div>

                                                <div class="col-lg-2" style="padding-top: 5px;">
                                                    <label>Satuan Kerja</label>
                                                </div>
                                                <div class="col-lg-10">
                                                    <div class="form-group">
                                                            @if (session()->get('pegawai_rule_id') == 1)
                                                                <select name="Satker" id="Satker" onchange="Filter()"></select>
                                                            @else
                                                                <input class="form-control" type="text" readonly placeholder="{{session()->get('pegawai_satker_id')}} - {{session()->get('pegawai_satker_nama')}}">
                                                            @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <div class="table-responsive" id="card_table" style="display: none">

                                        <table id="tabel_anggaran" class="table table-bordered display nowrap" >
                                            <thead>
                                                <tr>
                                                    <th>Program</th>
                                                    <th>Kegitan</th>
                                                    <th>Output</th>
                                                    <th>Sub Output</th>
                                                    <th>Komponen</th>
                                                    <th>Sub Komponen</th>
                                                    <th>Kode</th>
                                                    <th>Kode</th>
                                                    <th>Rupiah</th>
                                                    <th>Unit</th>
                                                    <th>PPK</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                          </table>
                                        
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <footer class="footer text-center text-muted">
                All Rights Reserved by Adminmart. Designed and Developed by <a
                    href="https://wrappixel.com">WrapPixel</a>.
            </footer>
        </div>
    </div>

    <!-- SignIn modal content -->
    <div id="modal-unit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class=" modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Pilih Unit Kerja</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form role="form" action="EditUnit/Update" method="POST" class="pl-3 pr-3">
                        @csrf

                        <div class="form-group">
                            <label for="emailaddress1">Pilih Unit Kerja</label>
                           <select id="unitselect2" name="unitselect2" class="dt-select2-unit-kerja" ></select>
                        </div>

                        <div style="">
                            <div class="form-group">
                                <label for="emailaddress1">Kode</label>
                            <input type="text" id="kode" name="kode">
                            </div>


                            <div class="form-group">
                                <label for="emailaddress1">Kode Satker</label>
                            <input type="text" id="kode_satker" name="kode_satker">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Program</label>
                            <input type="text" id="kode_program" name="kode_program">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Kegiatan</label>
                            <input type="text" id="kode_kegiatan" name="kode_kegiatan">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Output</label>
                            <input type="text" id="kode_output" name="kode_output">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Sub Output</label>
                            <input type="text" id="kode_sub_output" name="kode_sub_output">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Komponen</label>
                            <input type="text" id="kode_komponen" name="kode_komponen">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Sub Komponen</label>
                            <input type="text" id="kode_sub_komponen" name="kode_sub_komponen">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Index</label>
                            <input type="text" id="kode_index" name="kode_index">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Trigger</label>
                            <input type="text" id="trigger" name="trigger">
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-rounded btn-primary col-md-12">Simpan</button>
                                </div>

                                <div class="col-md-6">
                                    <button class="btn btn-rounded btn-danger col-md-12" data-dismiss="modal"
                                        aria-hidden="true">Batal</button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- SignIn modal content -->
    <div id="modal-ppk" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class=" modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Pilih PPK</h4>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form role="form" action="EditPpk/Update" method="POST" class="pl-3 pr-3">
                        @csrf

                        <div class="form-group">
                            <label for="emailaddress1">Pilih PPK</label>
                           <select id="ppkselect2" name="ppkselect2" class="dt-select2-ppk-kerja" ></select>
                        </div>

                        <div style="">
                            <div class="form-group">
                                <label for="emailaddress1">Kode</label>
                            <input type="text" id="kode_ppk" name="kode">
                            </div>


                            <div class="form-group">
                                <label for="emailaddress1">Kode Satker</label>
                            <input type="text" id="kode_satker_ppk" name="kode_satker">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Program</label>
                            <input type="text" id="kode_program_ppk" name="kode_program">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Kegiatan</label>
                            <input type="text" id="kode_kegiatan_ppk" name="kode_kegiatan">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Output</label>
                            <input type="text" id="kode_output_ppk" name="kode_output">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Sub Output</label>
                            <input type="text" id="kode_sub_output_ppk" name="kode_sub_output">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Komponen</label>
                            <input type="text" id="kode_komponen_ppk" name="kode_komponen">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Sub Komponen</label>
                            <input type="text" id="kode_sub_komponen_ppk" name="kode_sub_komponen">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Kode Index</label>
                            <input type="text" id="kode_index_ppk" name="kode_index">
                            </div>

                            <div class="form-group">
                                <label for="emailaddress1">Trigger</label>
                            <input type="text" id="trigger_ppk" name="trigger">
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-rounded btn-primary col-md-12">Simpan</button>
                                </div>

                                <div class="col-md-6">
                                    <button class="btn btn-rounded btn-danger col-md-12" data-dismiss="modal"
                                        aria-hidden="true">Batal</button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@include('_uiAssets.Footer')
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
@include('Anggaran.Script_pembagian_pagu')