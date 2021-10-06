<script>
        $("#jumlah").inputmask({
            prefix : 'Rp ',
            radixPoint: ',',
            groupSeparator: ".",
            alias: "numeric",
            autoGroup: true,
            digits: 0
        });


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

        $('#App').select2({
                placeholder: 'Pilih...',
                ajax: {
                url: '{!!URL::to('/findapp')!!}',
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
                                text: item.nama_app,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
                }
        });
    
        
    var grid_tabel = "#tabel_mapping";
    var is_set_grid_tabel = false;
    var editor; // use a global for the submit and return data rendering in the examples
    
    var all;

    if(session_rule_id != 1){
    jQuery(document).ready(function () {
        Filter()
            });
}
    
    function set_grid_tabel(is_current) {
      if (!is_set_grid_tabel) {
        is_set_grid_tabel = true;
        $(grid_tabel).DataTable({
                serverSide: true,
                processing: true,
                searchDelay: 500,
                ajax: {
                    url: '{{url('getMapping')}}',
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
    
                    {data: 'satker', visible: false},
    
                    {data: 'urutan' , visible: false,
                    render: function (data, type, row, meta) {
                        if(row.parent == 0){
                            return "<td colspan='6'>"+row.urutan+"</td>";
                        }else{
                            return data;
                        }
                        },
                    },
    
                    {data: 'id',
                        render: function (data, type, row) {
                            return '<a href="javascript:;" onclick="Detail()">'+data+'</a>';
                        }
                    },
    
                    {data: 'uraian'},
    
                    {data: 'paguAkhir',className: "text-right", render: $.fn.dataTable.render.number( ',', '.', 0 )},
    
                    { data: "id", 
                        render: function (data, type, row) {
                                //return '<a href="javascript:;" onclick="UpdateInline(`'+data+'`)">1</a>';  
                                if(row.label == "MAK"){
                                    return '<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#login-modal"> <i class ="fas fa-plus"></i> APP</button>';                    
                                }else{
                                    return '';
                                }
                                
                    },
                    }
                ],
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: [1, "asc"],
                searching: true,
                bFilter: false,
                scrollCollapse: true,
                columnDefs: [],
    
                initComplete: function (settings, json) {
                    $(grid_tabel).wrap('<div class="table-responsive"></div>');
                },
            });
    
            } else {
        $(grid_tabel).DataTable().search("");
        $(grid_tabel).DataTable().ajax.reload(null, !is_current);
      }
    }
    
    // function Update(Id,selectObject) {
    //   var value = selectObject.value;  
    //   Swal.fire({
    //             title: "Apakah Yakin Ingin Merubah?",
    //             icon: "question",
    //             showCancelButton: true,
    //             confirmButtonText: "Ya, Ubah!",
    //             cancelButtonText: "Batal",
    //             }).then(function (result) {
    //                 if (result.value) {
    //                   Execute(Id, value);
    //                 }
    //             });
    // }
    
    function Update(selectObject) {
        var value = selectObject.value;
        var Id = selectObject.id;
            var formData = new FormData();
            formData.append("_token", '{{ csrf_token() }}');
            formData.append("id", Id);
            formData.append("flag", value);
    
                $.ajax({
                    type: "POST",
                    data: formData,
                    url: '{!!URL::to('/PembagianPagu/Update')!!}',
                    processData: false,
                    contentType: false,
                    success: function (data, textStatus, jqXHR) {
                        show_msg();
                    },
                    error: function (jqXHR, textStatus, errorThrown) { },
                });
            }
    
            function show_msg(){
                Swal.fire({
                  icon: 'success',
                  title: 'Berubah!',
                  text: 'Berhasil Diubah.',
                  showConfirmButton: true,
                  timer: 5000
              });
            }
     
    
            function showModal(){
                var modal = document.getElementById("AppModal");
                modal.style.display = "block";
            }
        
    
    function Detail() {
        $('#card_detail').fadeIn();
     
     }

     function Filter() {
        $('#card_table').fadeIn();
        set_grid_tabel(false);
     
     }
    
    
    
    </script>