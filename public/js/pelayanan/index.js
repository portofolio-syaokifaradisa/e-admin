document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('print').addEventListener('click', function(){
        var params = '?';
        const forms = ["nama", "layanan", "tanggal", "desa", "gender"];
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
                render: function(_, type, pelayanan, meta){
                    return `
                        <div class="btn-group dropright px-0 pr-2">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropright">
                                <a class="dropdown-item has-icon" href="${window.location.href}/${pelayanan.id}/edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item has-icon delete-button" id="pelayanan-${pelayanan.id}" href="#">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    `;
                }
            },
            { data: 'tanggal',  name: 'tanggal' },
            { data: 'layanan',  name: 'layanan' },
            { data: 'desa',  name: 'desa' },
            { data: 'nama',  name: 'nama' },
            { data: 'gender',  name: 'gender' },
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i=1; i <= 7; i++){
                $(row).children(`:nth-child(${i})`).addClass(`${[5,6].includes(i) ? "" : "text-center"} align-middle`);
            }
        },
        initComplete: function () {
            resetFooterFormEvent();
        }
    }); 

    function resetFooterFormEvent(){
        table.api().columns().every(function () {
            var table = this;

            // Event Form Input
            $('input', this.footer()).on('keyup change clear', function () {
                table.search(this.value).draw();
            });

            // Event Form Dropdown
            $('select', this.footer()).on('keyup change clear', function () {
                table.search(this.value).draw();
            });
        });
    }

    // Pembuatan Individual Search Pada Bagian Footer
    $('#datatable tfoot th').each(async function (index) {
        var name = $(this).attr('id');
    
        if(name === "nama"){
            $(this).html(`
                <div class="form-group pr-4">
                    <input type="text" class="form-control text-center" name="${name}" id="${name}-form" placeholder="Cari ${name}">
                </div>
            `);
        }else if(name == "tanggal"){
            $(this).html(`
                <div class="form-group pr-4">
                    <input type="month" class="form-control text-center" name="${name}" id="${name}-form">
                </div>
            `);
        }else if(name === "layanan"){
            const url = window.location.href;

            const response = await fetch(`${url.substring(0, url.lastIndexOf('/'))}/service/json`);
            const layanan = await response.json();

            var layananOptions = '';
            for(var i = 0; i < layanan.length; i++){
                layananOptions += `<option value="${layanan[i].id}"> ${layanan[i].nama} </option>`;
            }

            $(this).html(`
                <select class="form-control" name="${name}" id="${name}-form" data-index="${index}">
                    <option value="Semua">Semua</option>
                    ${layananOptions}
                </select>
            `);

            resetFooterFormEvent();
        }else if(name === "desa"){
            const url = window.location.href;

            const response = await fetch(`${url.substring(0, url.lastIndexOf('/'))}/desa/json`);
            const desa = await response.json();

            var desaOptions = '';
            for(var i = 0; i < desa.length; i++){
                desaOptions += `<option value="${desa[i].id}"> ${desa[i].nama_desa} </option>`;
            }

            $(this).html(`
                <select class="form-control" name="${name}" id="${name}-form" data-index="${index}">
                    <option value="Semua">Semua</option>
                    ${desaOptions}
                </select>
            `);

            resetFooterFormEvent();
        }else if(name === "gender"){
            $(this).html(`
                <select class="form-control" name="${name}" id="${name}-form">
                    <option value="Semua">Semua</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
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
                    "Konfirmasi Penghapusan Catatan Pelayanan",
                    "Apakah Anda Yakin ingin Menghapus Catatan Pelayanan?",
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