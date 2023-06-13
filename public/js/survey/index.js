document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('evaluation').addEventListener('click', function(){
        var params = '?';
        const forms = ["tanggal"];
        for(var name of forms){
            var formValue = document.getElementById(`${name}-form`).value;
            params += `${name}=${formValue}`;
            if(forms.indexOf(name) !== (forms.length - 1)){
                params += '&';
            }
        }

        window.open(`${window.location.href}/evaluation${params}`, '_blank');
    });

    document.getElementById('print').addEventListener('click', function(){
        var params = '?';
        const forms = ["u1", "u2", "u3", "u4", "u5", "u6", "u7", "u8", "u9", "tanggal", 'jenis_kelamin', 'pendidikan'];
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
                render: function(_, type, survey, meta){
                    return `
                        <div class="btn-group dropright px-0 pr-2">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropright">
                                <a class="dropdown-item has-icon" href="${window.location.href}/${survey.id}/edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item has-icon delete-button" id="survey-${survey.id}" href="#">
                                    <i class="fas fa-trash-alt"></i>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    `;
                }
            },
            { data: 'tanggal', name: 'tanggal',},
            { data: 'jenis_kelamin', name: 'jenis_kelamin'},
            { data: 'pendidikan', name: 'pendidikan'},
            { data: 'u1', name: 'u1'},
            { data: 'u2', name: 'u2'},
            { data: 'u3', name: 'u3'},
            { data: 'u4', name: 'u4'},
            { data: 'u5', name: 'u5'},
            { data: 'u6', name: 'u6'},
            { data: 'u7', name: 'u7'},
            { data: 'u8', name: 'u8'},
            { data: 'u9', name: 'u9'},
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i=1; i <= 14; i++){
                $(row).children(`:nth-child(${i})`).addClass(`text-center align-middle`);
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
    
        if(["tanggal"].includes(name)){
            $(this).html(`
                <div class="form-group mb-0 pr-4">
                    <input type="text" class="form-control text-center" name="${name}" id="${name}-form" placeholder="Cari ${name}">
                </div>
            `);
        }else if(name === "jenis_kelamin"){
            $(this).html(`
                <div class="form-group mb-0 pr-4" style="width: 100%">
                    <select class="form-control select2 category-select" name="${name}" id="${name}-form">
                        <option value="Semua" selected>Semua</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            `);
        }else if(name === "pendidikan"){
            $(this).html(`
                <div class="form-group mb-0 pr-4" style="width: 100%">
                    <select class="form-control select2 category-select" name="${name}" id="${name}-form">
                        <option value="Semua" selected>Semua</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="D1-D3-D4">D1-D3-D4</option>
                        <option value="S1">S1</option>
                        <option value=">S2">>S2</option>
                    </select>
                </div>
            `);
        }else if(["u1", "u2", "u3", "u4", "u5", "u6", "u7", "u8", "u9"].includes(name)){
            $(this).html(`
                <div class="form-group mb-0 pr-4" style="width: 100%">
                    <select class="form-control select2 category-select" name="${name}" id="${name}-form">
                        <option value="Semua" selected>Semua</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
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
                    "Konfirmasi Penghapusan Data Survey",
                    "Apakah Anda Yakin ingin Menghapus Data Survey?",
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