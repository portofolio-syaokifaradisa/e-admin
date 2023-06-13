document.addEventListener("DOMContentLoaded", function(){
    document.getElementById('print').addEventListener('click', function(){
        var params = '?';
        const forms = ["luas_wilayah", 'jumlah_laki', 'jumlah_perempuan', "desa", "tahun", 'jumlah_kk', 'jumlah_warga'];
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
            { data: 'tahun',  name: 'tahun' },
            { data: 'desa',  name: 'desa' },
            { data: 'luas_wilayah',  name: 'luas_wilayah' },
            { data: 'jumlah_laki',  name: 'jumlah_laki' },
            { data: 'jumlah_perempuan',  name: 'jumlah_perempuan' },
            { data: 'jumlah_kk',  name: 'jumlah_kk' },
            { data: 'jumlah_warga',  name: 'jumlah_warga' },
        ], 
        createdRow: function( row, data, dataIndex ){
            for(var i = 1; i <= 8; i++){
                $(row).children(`:nth-child(${i})`).addClass(`${i != 4 ? 'text-center' : ''} align-middle`);
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
    
        if(["luas_wilayah", 'jumlah_laki', 'jumlah_perempuan', 'tahun', 'jumlah_kk', 'jumlah_warga'].includes(name)){
            $(this).html(`
                <div class="form-group mb-0 pr-4">
                    <input type="text" class="form-control text-center" id="${name}-form" name="${name}" placeholder="Filter">
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