<script>


$('#Satker').select2({
            placeholder: 'Pilih...',
            ajax: {
            url: '{!!URL::to('/findsatker')!!}',
            width: "100%",
            type:'post',
            delay: 250,
            data: function(params) {
                        return {
                            //tk2: tk2_merge,                        
                            _token: "{{ csrf_token() }}",
                            search: params.term
                        };
                    },
                // success:function(data){
                //     console.log(data);
                // },
            processResults: function (data) {
                return {
                results:  $.map(data, function (item) {
                        return {
                            text: item.id+ ' - ' +item.satker,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
            }
    });

    $('#Eselon').select2({
            placeholder: 'Pilih...',
            ajax: {
            url: '{!!URL::to('/findeselon')!!}',
            width: "100%",
            type:'post',
            delay: 250,
            data: function(params) {
                        return {
                            //tk2: tk2_merge,                        
                            _token: "{{ csrf_token() }}",
                            search: params.term
                        };
                    },
                // success:function(data){
                //     console.log(data);
                // },
            processResults: function (data) {
                return {
                results:  $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
            }
    });

    
var grid_tabel = "#tabel_anggaran";
var is_set_grid_tabel = false;
var editor; // use a global for the submit and return data rendering in the examples

var all;

if(session_rule_id != 1){
    jQuery(document).ready(function () {
        Filter()
            });
}

function set_grid_tabel(is_current) {
    var collapsedGroups = {};
    var top = '';
    var parent = '';

  if (!is_set_grid_tabel) {
    is_set_grid_tabel = true;
    $(grid_tabel).DataTable({
            serverSide: true,
            processing: true,
            searchDelay: 500,
            scrollX: true,
            
            ajax: {
                url: '{{url('getPembagianPagu')}}',
                data: function (d) {
                    if(session_rule_id == 1){
                        d.satker_id = $('#Satker').val()
                    }else{
                        d.satker_id = session_satker_id
                    }
                
                    d._token = "{{ csrf_token() }}"
                },
            },
            autoWidth: false,
            columns: [

                {data: 'kode_program'},

                {data: 'kode_kegiatan'},

                {data: 'kode_output'},

                {data: 'kode_sub_output'},

                {data: 'kode_komponen'},

                {data: 'kode_sub_komponen'},

                {data: 'kode_akun'},

                {data: 'kode_index', visible: false},

                {data: 'rupiah',className: "text-right", render: $.fn.dataTable.render.number( ',', '.', 0 )},

                

                { data: "kode_index", 
                    render: function (data, type, row) {
                            //return "1";
                            return '<select name="unit" id="'+data+'" class="dt-select2"  onchange="Update(this,'+row.kode_satker+')"><option selected="selected" value='+row.id_unit+'>'+row.id_unit+'</option></select>';                    
                    },
                },

                { data: "kode_index", 
                    render: function (data, type, row) {
                            //return "1";
                            return '<select name="ppk" id="'+data+'" class="dt-select2-idppk"  onchange="Update(this,'+row.kode_satker+')"><option selected="selected" value='+row.id_ppk+'>'+row.id_ppk+'</option></select>';                    
                    },
                },

                // { data: "id", 
                //     render: function (data, type, row) {
                //             //return "1";
                //             return '<input type="number" class="form-control" value ='+row.flag+' min="000" max="0100"> </input>';                    
                //     },
                // }



                //------------BACKUP------------------

                // {data: 'satker', visible: false},

                // {data: 'urutan' , visible: false,
                //     render: function (data, type, row, meta) {
                //         return row.urutan
                //     },
                // },

                // {data: 'id'},

                // {data: 'uraian'},

                // {data: 'paguAkhir',className: "text-right", render: $.fn.dataTable.render.number( ',', '.', 0 )},

                // { data: "id", 
                //     render: function (data, type, row) {
                //             //return "1";
                //             return '<select name="'+row.label+'" id="'+data+'" class="dt-select2"  onchange="Update(this,'+row.satker+')"><option selected="selected" value='+row.flag+'>'+row.flag+'</option></select>';                    
                //     },
                // },

                // { data: "id", 
                //     render: function (data, type, row) {
                //             //return "1";
                //             return '<input type="number" class="form-control" value ='+row.flag+' min="000" max="0100"> </input>';                    
                //     },
                // }
            ],
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            order: [[0, "asc"],[1, "asc"],[2, "asc"],[3, "asc"],[4, "asc"],[5, "asc"]],
            searching: true,
            scrollCollapse: true,
            columnDefs: [

                {
                    // hide columns by index number
                    targets: [ 0, 1, 2, 3, 4, 5],
                    visible: false,
                    },


                { "width": "15%", "targets": 7 },
                ],

            // initComplete: function (settings, json) {
            //     $(grid_tabel).wrap('<div class="table-responsive"></div>');
            // },


            rowGroup: {
                dataSrc: [
                    'kode_program' , 
                    'kode_kegiatan', 
                    'kode_output',
                    'kode_sub_output' , 
                    'kode_komponen', 
                    'kode_sub_komponen'],
                startRender: function(rows, group, level) {  
                    var Trigger = '';
                    if ( level == 0 ) {
                         Trigger = "program"
                        return $('<tr/>')
                                .append('<td colspan= "2">' + group +'</td>')
                                .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_unit')[0]+' id='+rows.data().pluck('without_concat_kode_program')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'unit\')"> <i class ="fas fa-plus"></i> UNIT</button></td>')
                                .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_ppk')[0]+' id='+rows.data().pluck('without_concat_kode_program')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'pppk\')"> <i class ="fas fa-plus"></i> PPK</button></td>')
                        
                        } else if ( level == 1 ) {
                            Trigger = "kegiatan"
                            return $('<tr/>')
                                .append('<td colspan= "2">' + group +'</td>')
                                .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_unit')[0]+' id='+rows.data().pluck('kode_kegiatan')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'unit\')"> <i class ="fas fa-plus"></i> UNIT</button></td>')
                                .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_ppk')[0]+' id='+rows.data().pluck('kode_kegiatan')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'ppk\')"> <i class ="fas fa-plus"></i> PPK</button></td>')
                        
                        } else if ( level == 2 ) {
                            Trigger = "output"
                            return $('<tr/>')
                                .append('<td colspan= "2">' + group +'</td>')
                                .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_unit')[0]+' id='+rows.data().pluck('without_concat_kode_output')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'unit\')"> <i class ="fas fa-plus"></i> UNIT</button></td>')
                                .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_ppk')[0]+' id='+rows.data().pluck('without_concat_kode_output')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'ppk\')"> <i class ="fas fa-plus"></i> PPK</button></td>')
                        
                        } else if ( level == 3 ) {
                            Trigger = "sub_output"
                            return $('<tr/>')
                                .append('<td colspan= "2">' + group +'</td>')
                                .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_unit')[0]+' id='+rows.data().pluck('without_concat_kode_sub_output')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'unit\')"> <i class ="fas fa-plus"></i> UNIT</button></td>')
                                .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_ppk')[0]+' id='+rows.data().pluck('without_concat_kode_sub_output')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'ppk\')"> <i class ="fas fa-plus"></i> PPK</button></td>')
                        
                        } else if ( level == 4 ) {
                            Trigger = "komponen"
                            return $('<tr/>')
                                .append('<td colspan= "2">' + group +'</td>')
                                .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_unit')[0]+' id='+rows.data().pluck('kode_komponen')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'unit\')"> <i class ="fas fa-plus"></i> UNIT</button></td>')
                                .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_ppk')[0]+' id='+rows.data().pluck('kode_komponen')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'ppk\')"> <i class ="fas fa-plus"></i> PPK</button></td>')
                        
                    } else{
                        Trigger = "sub_komponen"
                        return $('<tr/>')
                            .append('<td colspan= "2">' + group +'</td>')
                            .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_unit')[0]+' id='+rows.data().pluck('without_concat_kode_sub_komponen')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'unit\')"> <i class ="fas fa-plus"></i> UNIT</button></td>')
                            .append('<td align="center"><button class="btn btn-sm btn-success" style="width: 100%" name='+Trigger+' value='+rows.data().pluck('id_ppk')[0]+' id='+rows.data().pluck('without_concat_kode_sub_komponen')[0]+' onclick="showModalUnit(this,\'' +rows.data().pluck('kode_satker')[0]+'\',\''+rows.data().pluck('kode_index')[0]+'\',\'ppk\')"> <i class ="fas fa-plus"></i> PPK</button></td>')
                    
                    }


                        // return $('<tr/>')
                        //     //$('.ppk')
                        //     .append('<td colspan= "2">' + group +'</td>')
                        //     .append('<td><select name="nama" class="unit select2" onchange="Update(this,'+rows.data().pluck('kode_satker')[0]+')"><option selected="selected" value='+rows.data().pluck('id_unit')[0]+'>'+rows.data().pluck('id_unit')[0]+'</option></select></td>')
                        //     .append('<td><select name="nama" class="ppk select2" onchange="Update(this,'+rows.data().pluck('kode_satker')[0]+')"><option selected="selected" value='+rows.data().pluck('id_ppk')[0]+'>'+rows.data().pluck('id_ppk')[0]+'</option></select></td>')
                        
                    
                }

                
            },

            drawCallback: function(settings) {
            
            $('.dt-select2').select2({
            placeholder: 'Pilih...',
            ajax: {
            url: '{!!URL::to('/findunitkerja')!!}',
            type:'post',
            delay: 250,
            width: "20%",
            
                    data: function(params) {
                                    var Satker = session_satker_id
                                    if(session_rule_id == 1){
                                            Satker = $('#Satker').val()
                                        }
                                
                                return {                      
                                    _token: "{{ csrf_token() }}",
                                    search: params.term,
                                    satker: Satker
                                };
                                
                    },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                                return {
                                    text: item.id+ ' - ' +item.nama_unit,
                                    id: item.id,
                                    selected: true
                                }
                            })
                    };
                },
                    cache: true
                    }
                });

            $('.dt-select2-idppk').select2({
            placeholder: 'Pilih...',
            ajax: {
            url: '{!!URL::to('/findppk')!!}',
            type:'post',
            delay: 250,
            width: "20%",
            
                    data: function(params) {
                                    var Satker = session_satker_id
                                    if(session_rule_id == 1){
                                            Satker = $('#Satker').val()
                                        }
                                
                                return {                      
                                    _token: "{{ csrf_token() }}",
                                    search: params.term,
                                    satker: Satker
                                };
                                
                    },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                                return {
                                    text: item.id+ ' - ' +item.nama,
                                    id: item.id,
                                    selected: true
                                }
                            })
                    };
                },
                    cache: true
                    }
                });
            
            },

            
            
        });
        $(grid_tabel).DataTable().draw();

        // $('#tabel_anggaran tbody').on('click', 'tr.dtrg-start', function() {
        // var name = $(this).data('name');
        // collapsedGroups[name] = !collapsedGroups[name];
        // $(grid_tabel).DataTable().draw(false);
        // });

        } else {
    $(grid_tabel).DataTable().search("");
    $(grid_tabel).DataTable().ajax.reload(null, !is_current);
  }
}

$('.dt-select2-unit-kerja').select2({
            placeholder: 'Pilih...',
            ajax: {
            url: '{!!URL::to('/findunitkerja')!!}',
            type:'post',
            delay: 250,
            width: "20%",
            
                    data: function(params) {
                                    var Satker = session_satker_id
                                    if(session_rule_id == 1){
                                            Satker = $('#Satker').val()
                                        }
                                
                                return {                      
                                    _token: "{{ csrf_token() }}",
                                    search: params.term,
                                    satker: Satker
                                };
                                
                    },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                                return {
                                    text: item.id+ ' - ' +item.nama_unit,
                                    id: item.id,
                                    selected: true
                                }
                            })
                    };
                },
                    cache: true
                    }
                });

                $('.dt-select2-ppk-kerja').select2({
            placeholder: 'Pilih...',
            ajax: {
            url: '{!!URL::to('/findppk')!!}',
            type:'post',
            delay: 250,
            width: "20%",
            
                    data: function(params) {
                                    var Satker = session_satker_id
                                    if(session_rule_id == 1){
                                            Satker = $('#Satker').val()
                                        }
                                
                                return {                      
                                    _token: "{{ csrf_token() }}",
                                    search: params.term,
                                    satker: Satker
                                };
                                
                    },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                                return {
                                    text: item.id+ ' - ' +item.nama,
                                    id: item.id,
                                    selected: true
                                }
                            })
                    };
                },
                    cache: true
                    }
                });



function showModalUnit(selectObject, Satker, kdIndex, jenis){
    var Value = selectObject.value;
    var kode = selectObject.id;
    var kdIndex = kdIndex;
    var KdSatker = Satker;
    var Trigger = selectObject.name;

    $.ajax({
        url : "{!!URL::to('/EditUnit')!!}",
        data: {"id": kode, "trigger": Trigger},
        type: "GET",
        dataType: "JSON",
        success: function(data)
            {

            var unit = $("<option selected='selected'></option>").val(data[0].id_unit).text(data[0].nama_unitkerja)
    
            var countData = data.length
            // $("#tk2").append(tk2).trigger('change');
            //$('select[name="tk2"]').val(data[0].tk2).trigger("change.select2");

            if(jenis == "unit"){
                $('#id_unit').val(data[0].id_unit);
                $('#kode').val(kode);
                $('#kode_program').val(kdIndex.substring(10, 12));
                $('#kode_kegiatan').val(kdIndex.substring(12, 16));
                $('#kode_output').val(kdIndex.substring(16, 19));
                $('#kode_sub_output').val(kdIndex.substring(19, 22));
                $('#kode_komponen').val(kdIndex.substring(22, 25));
                $('#kode_sub_komponen').val(kdIndex.substring(25, 27));
                $('#kode_satker').val(kdIndex.substring(4, 9));
                $('#kode_index').val(kdIndex);
                $('#trigger').val(Trigger);
                $("#unitselect2").append(unit).trigger('change');
                $('#modal-unit').modal('show');
            }else{
                $('#id_unit_ppk').val(data[0].id_unit);
                $('#kode_ppk').val(kode);
                $('#kode_program_ppk').val(kdIndex.substring(10, 12));
                $('#kode_kegiatan_ppk').val(kdIndex.substring(12, 16));
                $('#kode_output_ppk').val(kdIndex.substring(16, 19));
                $('#kode_sub_output_ppk').val(kdIndex.substring(19, 22));
                $('#kode_komponen_ppk').val(kdIndex.substring(22, 25));
                $('#kode_sub_komponen_ppk').val(kdIndex.substring(25, 27));
                $('#kode_satker_ppk').val(kdIndex.substring(4, 9));
                $('#kode_index_ppk').val(kdIndex);
                $('#trigger_ppk').val(Trigger);
                $("#ppkselect2_ppk").append(unit).trigger('change');
                $('#modal-ppk').modal('show');
            }
            
            }
    });
}


function Update(selectObject, Satker, Trigger) {
    var Value = selectObject.value;
    var KdIndex = selectObject.id;
    var KdSatker = Satker;
    var Trigger = selectObject.name;
        var formData = new FormData();
        formData.append("_token", '{{ csrf_token() }}');
        formData.append("kdindex", KdIndex);
        formData.append("kdsatker", KdSatker);
       if(Trigger == "unit"){
        formData.append("idunit", Value);
       }else{
        formData.append("idppk", Value);
       }
            
       
        
        formData.append("Trigger", Trigger);

            $.ajax({
                type: "POST",
                data: formData,
                url: '{!!URL::to('/PembagianPagu/Update')!!}',
                processData: false,
                contentType: false,
                success: function (data, textStatus, jqXHR) {
                    show_msg();
                    set_grid_tabel(false);
                    
                    
                },
                error: function (jqXHR, textStatus, errorThrown) { },
            });
        }

        function show_msg(){
            Swal.fire({
              icon: 'success',
              title: 'Berubah!',
              text: 'Jabatan Berhasil Diubah.',
              showConfirmButton: true,
              timer: 2000
          });
        }
 

function Message(isSuccess, title) {
    Swal.fire({
        position: "top-right",
        icon: isSuccess ? "success" : "error",
        title: title,
        showConfirmButton: false,
        timer: 1500,
    });
}

    


 function Filter() {
     $('#card_table').fadeIn();
      set_grid_tabel(false);
 
 }



</script>