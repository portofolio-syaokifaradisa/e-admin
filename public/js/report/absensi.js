document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('summary').addEventListener('click', function(){
        var params = '?';
        const forms = ["tanggal"];
        for(var name of forms){
            var formValue = document.getElementById(`${name}-form`).value;
            params += `${name}=${formValue}`;
            if(forms.indexOf(name) !== (forms.length - 1)){
                params += '&';
            }
        }

        window.open(`${window.location.href}-summary${params}`, '_blank');
    });

    document.getElementById('print').addEventListener('click', function(){
        var params = '?';
        const forms = ["tanggal", "pagi", 'sore', 'pegawai', 'keterangan', 'status'];
        for(var name of forms){
            var formValue = document.getElementById(`${name}-form`).value;
            params += `${name}=${formValue}`;
            if(forms.indexOf(name) !== (forms.length - 1)){
                params += '&';
            }
        }

        window.open(`${window.location.href}-report${params}`, '_blank');
    });

    const table = $("#datatable").dataTable({
        processing: true,
        serverSide: true,
        searching: true,
        dom: 'Brtip',
        ajax : `${window.location.href}-datatable`,
        columns: [
            { data: 'no', name: 'no', orderable: false, searchable: false },
            { data: 'tanggal', name: 'tanggal'},
            { 
                data: 'pegawai', 
                name: 'pegawai',
                render: function(_, type, absensi, meta){
                    return `
                        ${absensi.nama} <br>
                        NIP.${absensi.nip}
                    `;
                }
            },
            { data: 'status', name: 'status'},
            { data: 'masuk', name: 'masuk'},
            { data: 'keluar', name: 'keluar'},
            { data: 'keterangan', name: 'keterangan'},
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i=1; i <= 7; i++){
                $(row).children(`:nth-child(${i})`).addClass(`${i === 3 && i === 7 ? "" : "text-center"} align-middle`);
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
    
        if(name === "tanggal"){
            $(this).html(`
                <div class="form-group mb-0 pr-4">
                    <input type="month" class="form-control text-center" name="${name}" id="${name}-form">
                </div>
            `);
        }else if(name === "pagi" || name === "sore"){
            $(this).html(`
                <div class="form-group mb-0 pr-4">
                    <input type="time" class="form-control text-center" name="${name}" id="${name}-form">
                </div>
            `);
        }else if(name === "pegawai" || name === "keterangan"){
            $(this).html(`
                <div class="form-group mb-0 pr-4">
                    <input type="text" class="form-control text-center" name="${name}" id="${name}-form">
                </div>
            `);
        }else if(name === "status"){
            $(this).html(`
                <div class="form-group pr-4" style="width: 100%;">
                    <select class="form-control select2 category-select text-center" name="${name}" id="${name}-form" data-index="${index}">
                        <option value="Semua">Semua</option>
                        <option value="Hadir">Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Dinas Luar">Dinas Luar</option>
                    </select>
                </div>
            `);
        }else{
            $(this).text('');
        }
    });
});