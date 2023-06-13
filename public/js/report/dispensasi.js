document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('print').addEventListener('click', function(){
        var params = '?';
        const forms = ["mempelai_laki", "mempelai_perempuan", 'tempat_nikah', 'tanggal_nikah', 'desa', "tahun"];
        for(var name of forms){
            var formValue = document.getElementById(`${name}-form`).value;
            console.log(name, formValue);
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
            { data: 'tahun',  name: 'tahun' },
            { data: 'desa',  name: 'desa' },
            { data: 'mempelai_perempuan',  name: 'mempelai_perempuan' },
            { data: 'mempelai_laki',  name: 'mempelai_laki' },
            { data: 'tempat_nikah',  name: 'tempat_nikah' },
            { data: 'tanggal_nikah',  name: 'tanggal_nikah' },
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i = 1; i <= 7; i++){
                $(row).children(`:nth-child(${i})`).addClass(`${i != 7 ? 'text-center' : ''} align-middle`);
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
    
        var placeholder = `Cari ${$(this).html()}`;
        if(["mempelai_laki", "mempelai_perempuan", 'tempat_nikah', "tahun"].includes(name)){
            $(this).html(`
                <div class="form-group mb-0 pr-4">
                    <input type="text" class="form-control text-center" id="${name}-form" name="${name}" placeholder="${placeholder}">
                </div>
            `);
        }else if(name === "tanggal_nikah"){
            $(this).html(`
                <div class="form-group mb-0 pr-4">
                    <input type="month" class="form-control text-center" name="${name}" id="${name}-form">
                </div>
            `);
        }else if(name === "desa"){
            const url = window.location.href.substring(0, window.location.href.lastIndexOf('/'));

            const response = await fetch(`${url.substring(0, url.lastIndexOf('/'))}/desa/json`);
            const desa = await response.json();

            var desaOptions = '';
            for(var i = 0; i < desa.length; i++){
                desaOptions += `<option value="${desa[i].id}"> ${desa[i].nama_desa} </option>`;
            }

            $(this).html(`
                <select class="form-control" name="${name}" id="${name}-form">
                    <option value="Semua">Semua</option>
                    ${desaOptions}
                </select>
            `);

            resetFooterFormEvent();
        }else{
            $(this).text('');
        }
    });
});