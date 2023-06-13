document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('print').addEventListener('click', function(){
        var params = '?';
        const forms = ["nama_nip", "jabatan", "pangkat", "golongan", "role"];
        for(var name of forms){
            var formValue = document.getElementById(`${name}-form`).value;
            params += `${name}=${formValue}`;
            if(forms.indexOf(name) !== (forms.length - 1)){
                params += '&';
            }
        }

        window.open(`${window.location.href}/print${params}`, '_blank');
    });

    const table = $("#datatable").dataTable({
        processing: true,
        serverSide: true,
        searching: true,
        dom: 'Brtip',
        ajax : `${window.location.href}/datatable`,
        columns: [
            { data: 'no', name: 'no', orderable: false, searchable: false },
            { 
                data: 'action', 
                name: 'action',
                render: function(_, type, pegawai, meta){
                    return `
                        <div class="btn-group dropright px-0 pr-2">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropright">
                                <a class="dropdown-item has-icon" href="${window.location.href}/${pegawai.id}/edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item has-icon delete-button" id="pegawai-${pegawai.id}" href="#">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    `;
                }
            },
            { 
                data: 'foto', 
                name: 'foto',
                render: function(_, type, pegawai, meta){
                    return pegawai.foto != '-' ? `
                        <a href="${pegawai.foto}" target="_blank">
                            <img src="${pegawai.foto}" style="width:80px; height:100px">
                        </a>
                    ` : "-";
                }
            },
            { 
                data: 'nama_nip', 
                name: 'nama_nip',
                render: function(_, type, pegawai, meta){
                    return `
                        ${pegawai.nama}<br>
                        ${pegawai.nip ? pegawai.nip + "<br>" : "" }
                        ${pegawai.email}
                    `;
                }
            },
            { data: 'jabatan', name: 'jabatan'},
            { data: 'pangkat', name: 'pangkat'},
            { data: 'golongan', name: 'golongan'},
            { data: 'role', name: 'role'},
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i=1; i <= 7; i++){
                $(row).children(`:nth-child(${i})`).addClass(`${i != 3 ? "text-center" : ""} align-middle`);
            }
        },
        initComplete: function () {
            this.api().columns().every(function () {
                var table = this;
    
                $('input', this.footer()).on('keyup change clear', function () {
                    table.search(this.value).draw();
                });

                $('select', this.footer()).on('keyup change clear', function () {
                    table.search(this.value).draw();
                });
            });
        }
    }); 

    // Pembuatan Individual Search Pada Bagian Footer
    $('#datatable tfoot th').each(function (index) {
        var name = $(this).attr('id');
    
        if(["nama_nip", "jabatan", "pangkat", "golongan"].includes(name)){
            var placeholder = $(this).html();
            $(this).html(`
                <div class="form-group mb-0 pr-4">
                    <input type="text" class="form-control text-center" name="${name}" id="${name}-form" placeholder="Cari ${placeholder}">
                </div>
            `);
        }else if(name === "role"){
            $(this).html(`
                <div class="form-group mb-0 pr-4" style="width: 100%">
                    <select class="form-control select2 category-select" name="${name}" id="${name}-form">
                        <option value="Semua" selected>Semua</option>
                        <option value="Pegawai">Pegawai</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
            `);
        }else{
            $(this).text('');
        }
    });

    $('#datatable').on('draw.dt', function (datatable) {
        const deleteButtons = datatable.target.getElementsByClassName('delete-button');
        for(let deleteButton of deleteButtons){
            deleteButton.addEventListener('click', function(e){
                e.preventDefault();
    
                var id = e.target.id.split('-')[1];

                confirmAlert(
                    "Konfirmasi Penghapusan Data Pegawai",
                    "Apakah Anda Yakin ingin Menghapus Data Pegawai?",
                    async function(){
                        const response = await fetch(
                            `${window.location.href}/${id}/delete`,
                            { method: "GET", headers: {'Content-Type': 'application/json'}}
                        );
            
                        const json = await response.json();
                        Swal.fire({icon: json.status, title: json.title, text: json.message});
                        if(json.status == 'success'){
                            table.api().ajax.reload(null, false);
                        }
                    }
                );
            });
        }
    });
});