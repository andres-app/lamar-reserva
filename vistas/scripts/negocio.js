var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();
   mostrar_registros();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   })

   //cargamos los items al celect categoria
   $("#logomuestra").hide();
}

function mostrar_registros(){
$.ajax({
url: '../ajax/negocio.php?op=mostrar_registros',
type:'get',
dataType:'json',
success: function(i){
	 registros=i;
	 if (registros==0) {
	$("#btnagregar").show();
	 }else{
	 	$("#btnagregar").hide();
	 }
}

	});}
//funcion limpiar
function limpiar(){
	$("#codigo").val("");
	$("#nombre").val("");
	$("#ndocumento").val("");
	$("#documento").val("");
	$("#direccion").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#logomuestra").attr("src","");
	$("#logoactual").val("");
	$("#pais").val("");
	$("#ciudad").val("");
	$("#nombre_impuesto").val("");
	$("#monto_impuesto").val("");
	$("#moneda").val("");
	$("#simbolo").val("");
	$("#id_negocio").val("");
	mostrar_registros();
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
				title: 'Empresa',
				sheetName: 'Empresa',
				exportOptions: {
                    columns: ':visible'
                }
			},
			{
                extend: 'pdfHtml5',
				//messageTop: 'Reporte de vehiculos',
				title: 'Empresa',
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
			url:'../ajax/negocio.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[[0,"desc"]],//ordenar (columna, orden)
		initComplete: function () {
			tabla.buttons().container().appendTo('#tbllistado_wrapper .col-md-6:eq(0)');
		  }
	}).DataTable();
}
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/negocio.php?op=guardaryeditar",
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

function mostrar(id_negocio){
	$.post("../ajax/negocio.php?op=mostrar",{id_negocio : id_negocio},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);
			$("#codigo").val(data.codigo);
			$("#nombre").val(data.nombre);
			$("#ndocumento").val(data.ndocumento);
			$("#documento").val(data.documento);
			$("#direccion").val(data.direccion);
			$("#telefono").val(data.telefono);
			$("#email").val(data.email);
			$("#logomuestra").show();
			$("#logomuestra").attr("src","../files/negocio/"+data.logo);
			$("#logoactual").val(data.logo);
			$("#pais").val(data.pais);
			$("#ciudad").val(data.ciudad);
			$("#nombre_impuesto").val(data.nombre_impuesto);
			$("#monto_impuesto").val(data.monto_impuesto);
			$("#moneda").val(data.moneda);
			$("#simbolo").val(data.simbolo);
			$("#id_negocio").val(data.id_negocio);
		})
}


//funcion para desactivar
function desactivar(id_negocio){
	Swal.fire({
		//title: 'Eliminar?',
		text: "Esá seguro de desactivar ?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonText: 'Si, desactivar',
		cancelButtonText: 'No, cancelar'
	  }).then((result) => {
		if (result.isConfirmed) {
			$.post("../ajax/negocio.php?op=desactivar", {id_negocio : id_negocio}, function(e){
		  Swal.fire(
			  e,
			  'Desactivado!',
			  'success');
			  var tabla = $('#tbllistado').DataTable();
			  tabla.ajax.reload();
	}
	)};
		  });
}

function activar(id_negocio){
	Swal.fire({
		//title: 'Eliminar?',
		text: "Esá seguro de activar ?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: '#3085d6',
		confirmButtonText: 'Si, activar',
		cancelButtonText: 'No, cancelar'
	  }).then((result) => {
		if (result.isConfirmed) {
			$.post("../ajax/negocio.php?op=activar" , {id_negocio : id_negocio}, function(e){
		  Swal.fire(
			  e,
			  'Activado!',
			  'success');
			  var tabla = $('#tbllistado').DataTable();
			  tabla.ajax.reload();
	}
	)};
		  });
}


init();