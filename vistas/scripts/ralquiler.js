var tabla

//funcion que se ejecuta al inicio
function init(){
   listar();

}

function listar(){
    var tabla = $('#tbllistado').dataTable( {
		"language": {
			search: "Buscar:",
            "zeroRecords": "No se encontró nada, lo siento",
            info: "mostrando de _START_ a _END_ de _TOTAL_ elementos",
            "infoEmpty": "No hay registros disponibles",
			paginate: {
				previous:   "Anterior",
				next:       "Siguiente"
			},
        },
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
        lengthChange: false,
		buttons: [
			{
                extend: 'excelHtml5',
				//messageTop: 'Reporte de clientes',
				title: 'Reporte de alquiler devuelto',
				sheetName: 'Alquiler',
				exportOptions: {
                    columns: ':visible'
                }
			},
			{
                extend: 'pdfHtml5',
				//messageTop: 'Reporte de clientes',
				title: 'Reporte de alquiler devuelto',
                download: 'open',
                orientation: 'landscape',
                pageSize: 'A3',
				exportOptions: {
                    columns: ':visible'
                }
			},
			{
                extend: 'colvis',
				text: 'Selector'

			}
			 ],
		"ajax":
		{
			url:'../ajax/alquiler.php?op=listar_dev',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":10,//paginacion
		"order":[[0,"desc"]],//ordenar (columna, orden)
		initComplete: function () {
			tabla.buttons().container().appendTo('#tbllistado_wrapper .col-md-6:eq(0)');
		  }
    } ).DataTable();
}

init();