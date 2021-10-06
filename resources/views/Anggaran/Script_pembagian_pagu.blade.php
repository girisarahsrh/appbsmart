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
  if (!is_set_grid_tabel) {
    is_set_grid_tabel = true;
    $(grid_tabel).DataTable({
            serverSide: true,
            processing: true,
            searchDelay: 500,
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

                {data: 'id'},

                {data: 'uraian'},

                {data: 'paguAkhir',className: "text-right", render: $.fn.dataTable.render.number( ',', '.', 0 )},

                {data: 'paguAkhir',className: "text-right", render: $.fn.dataTable.render.number( ',', '.', 0 )},

                { data: "id", 
                    render: function (data, type, row) {
                            //return '<a href="javascript:;" onclick="UpdateInline(`'+data+'`)">1</a>';  
                            return '<select name="'+row.label+'" id="'+data+'" class="dt-select2" onchange="Update(this,'+row.satker+')"><option selected="selected" value='+row.flag+'>'+row.flag+'</option></select>';                    
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

            drawCallback: function() {
                $('.dt-select2').select2({
            placeholder: 'Pilih...',
            ajax: {
            url: '{!!URL::to('/findsex')!!}',
            width: "100%",
            type:'post',
            delay: 250,
            data: function(params) {
                        return {                      
                            _token: "{{ csrf_token() }}",
                            search: params.term
                        };
                    },
            processResults: function (data) {
                return {
                results:  $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.id,
                            selected: true
                        }
                    })
                };

                
            },
            cache: true
            }
                });
            }
            

      
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

function Update(selectObject, Satker) {
    var Value = selectObject.value;
    var Id = selectObject.id;
    var Label = selectObject.name;
    var Satker = Satker;
        var formData = new FormData();
        formData.append("_token", '{{ csrf_token() }}');
        formData.append("id", Id);
        formData.append("flag", Value);
        formData.append("label", Label);
        formData.append("satker", Satker);

            $.ajax({
                type: "POST",
                data: formData,
                url: '{!!URL::to('/PembagianPagu/Update')!!}',
                processData: false,
                contentType: false,
                success: function (data, textStatus, jqXHR) {
                    show_msg();
                    if(Label == "SATKER"){
                        set_grid_tabel(false);
                    }
                    
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