var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();

}


//funcion mostrar formulario
function mostrarform(flag){
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").hide();
	}
}


//funcion listar
function listar(){
	tabla=$('#tbllistado').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
        lengthChange: false,
		buttons: [
			{
                extend: 'excelHtml5',
				//messageTop: 'Reporte de vehiculos',
				title: 'Permisos',
				sheetName: 'Permisos',
				exportOptions: {
                    columns: ':visible'
                }
			},
			{
                extend: 'pdfHtml5',
				//messageTop: 'Reporte de vehiculos',
				title: 'Permisos',
                download: 'open',
                //orientation: 'landscape',
                pageSize: 'A3',
				exportOptions: {
                    columns: ':visible'
                }
			}
			 ],
		"ajax":
		{
			url:'../ajax/permiso.php?op=listar',
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
	}).DataTable();
}


init();