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
				title: 'Reporte de garantias',
				sheetName: 'Garantias',
				exportOptions: {
                    columns: ':visible'
                }
			},
			{
                extend: 'pdfHtml5',
				//messageTop: 'Reporte de clientes',
				title: 'Reporte de garantias',
                download: 'open',
                //orientation: 'landscape',
                //pageSize: 'A3',
				exportOptions: {
                    columns: [ 1, 2, 3, 4,5,6,7,8,9,10,11 ]
                }
			},
			{
                extend: 'colvis',
				text: 'Selector'

			}
			 ],
		"ajax":
		{
			url:'../ajax/alquiler.php?op=listar_garantia',
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



//funcion para desactivar
function devolver_garantia(id){
	Swal.fire({
		//title: 'Eliminar?',
		text: "Esá seguro de devolver la garantía ?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonText: 'Si, devolver',
		cancelButtonText: 'No, cancelar'
	  }).then((result) => {
		if (result.isConfirmed) {
			$.post("../ajax/alquiler.php?op=dev_garantia", {id : id }, function(e){
		  Swal.fire(
			  e,
			  'Devuelto!',
			  'success');
			  var tabla = $('#tbllistado').DataTable();
			  tabla.ajax.reload();
	}
	)};
		  });
}




init();