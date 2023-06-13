document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('print').addEventListener('click', function(){
        var params = '?';
        const forms = ["tanggal", "masuk", 'keluar', 'keterangan', 'status'];
        for(var name of forms){
            var formValue = document.getElementById(`${name}-form`).value;
            console.log(name, formValue);
            params += `${name}=${formValue}`;
            if(forms.indexOf(name) !== (forms.length - 1)){
                params += '&';
            }
        }

        window.open(`${window.location.href}/absensi/print${params}`, '_blank');
    });


    const table = $("#datatable").dataTable({
        processing: true,
        serverSide: true,
        searching: true,
        dom: 'Brtip',
        ajax : `${window.location.href}/absensi/datatable`,
        columns: [
            { data: 'no', name: 'no', orderable: false, searchable: false },
            { data: 'tanggal', name: 'tanggal'},
            { data: 'masuk', name: 'masuk'},
            { data: 'keluar', name: 'keluar'},
            { data: 'status', name: 'status'},
            { data: 'keterangan', name: 'keterangan'},
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i=1; i <= 6; i++){
                $(row).children(`:nth-child(${i})`).addClass(`${i === 6 ? "" : "text-center"} align-middle`);
            }
        },
        initComplete: function () {
            this.api().columns().every(function () {
                var table = this;
    
                // Event Form Input
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
                <div class="form-group mb-0">
                    <input type="month" class="form-control text-center" name="${name}" id="${name}-form">
                </div>
            `);
        }else if(name === "masuk" || name === "keluar"){
            $(this).html(`
                <div class="form-group mb-0">
                    <input type="time" class="form-control text-center" name="${name}" id="${name}-form">
                </div>
            `);
        }else if(name === "keterangan"){
            $(this).html(`
                <div class="form-group mb-0">
                    <input type="text" class="form-control text-center" name="${name}" id="${name}-form" placeholder="Cari ${name}">
                </div>
            `);
        }else if(name === "status"){
            $(this).html(`
                <div class="form-group" style="width: 100%;">
                    <select class="form-control select2 category-select text-center" name="${name}" id="${name}-form" data-index="${index}">
                        <option value="SEMUA">Semua</option>
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