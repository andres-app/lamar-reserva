var tabla

//funcion que se ejecuta al inicio
function init(){

   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });

}

//funcion limpiar
function limpiar(){

	$("#valor").val("");
	$("#id").val("");
}

//funcion mostrar formulario 
function mostrarform(flag){

	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//cancelar form
function cancelarform(){
	limpiar();
	mostrarform(false);
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
				title: 'Reporte de tipo vehiculo',
				sheetName: 'Tipo vehiculo',
				exportOptions: {
                    columns: ':visible'
                }
			},
			{
                extend: 'pdfHtml5',
				//messageTop: 'Reporte de clientes',
				title: 'Reporte de tipo vehiculo',
				download: 'open',
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
			url:'../ajax/op_vehiculo.php?op=listartipo',
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

//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/op_vehiculo.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
			var tabla = $('#tbllistado').DataTable();

				Swal.fire({
					position: 'center',
					icon: 'success',
					title: datos,
					showConfirmButton: false,
					timer: 1000
				  });
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();
}

function mostrar(id){
	$.post("../ajax/op_vehiculo.php?op=mostrar",{id : id},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#item").val(data.item);
			$("#valor").val(data.valor);
			$("#id").val(data.id);
		});
}

//funcion para desactivar
function eliminar(id){
	Swal.fire({
		//title: 'Eliminar?',
		text: "Esá seguro de eliminar ?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonText: 'Si, borrar',
		cancelButtonText: 'No, cancelar'
	  }).then((result) => {
		if (result.isConfirmed) {
			$.post("../ajax/op_vehiculo.php?op=eliminar", {id : id }, function(e){
		  Swal.fire(
			  e,
			  'Eliminado!',
			  'success');
			  var tabla = $('#tbllistado').DataTable();
			  tabla.ajax.reload();
	}
	)};
		  });
}

//FUNCION PARA HACER MAYUSCULAS Y MINUSCULAS LOS VALORES DEL FORMULARIO
function mayus(e) {
	e.value = e.value.toUpperCase();
}
function minus(e) {
	e.value = e.value.toLowerCase();
}


init();