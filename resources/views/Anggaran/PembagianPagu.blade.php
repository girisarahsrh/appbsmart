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

                                        <table id="tabel_anggaran" class="table table-striped table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>satker</th>
                                                    <th>Urutan</th>
                                                    <th>Kode</th>
                                                    <th style="max-width: 30%">Uraian</th>
                                                    <th>Volume</th>
                                                    <th>Rupiah</th>
                                                    <th>Jabatan</th>
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


@include('_uiAssets.Footer')
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
@include('Anggaran.Script_pembagian_pagu')