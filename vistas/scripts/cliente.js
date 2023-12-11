var tabla

//funcion que se ejecuta al inicio
function init(){

   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });

       //cargamos los items al celect documento
   	$.post("../ajax/documentos.php?op=selectDocumento", function(r){
   	$("#tipo_documento").html(r);
   	$("#tipo_documento").selectpicker('refresh');
   });
}

//funcion limpiar
function limpiar(){

	$("#nombre").val("");
	$("#apellidos").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#licencia").val("");
	$("#idcliente").val("");
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
				title: 'Reporte de clientes',
				sheetName: 'Clientes',
				exportOptions: {
                    columns: ':visible'
                }
			},
			{
                extend: 'pdfHtml5',
				//messageTop: 'Reporte de clientes',
				title: 'Reporte de clientes',
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
			url:'../ajax/cliente.php?op=listarc',
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
     	url: "../ajax/cliente.php?op=guardaryeditar",
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

function mostrar(idcliente){
	$.post("../ajax/cliente.php?op=mostrar",{idcliente : idcliente},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#nombre").val(data.nombre);
			$("#apellidos").val(data.apellidos);
			$("#tipo_documento").val(data.tipo_documento);
			$("#tipo_documento").selectpicker('refresh');
			$("#num_documento").val(data.num_documento);
			$("#direccion").val(data.direccion);
			$("#telefono").val(data.telefono);
			$("#email").val(data.email);
			$("#licencia").val(data.licencia);
			$("#idcliente").val(data.idcliente);
		});
}

//funcion para desactivar
function eliminar(idcliente){
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
			$.post("../ajax/cliente.php?op=eliminar", {idcliente : idcliente }, function(e){
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