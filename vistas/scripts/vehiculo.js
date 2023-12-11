var tabla

//funcion que se ejecuta al inicio
function init(){

   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });

    //cargamos los items al celect marca
   	$.post("../ajax/op_vehiculo.php?op=selectMarca", function(r){
   	$("#marca").html(r);
   	$("#marca").selectpicker('refresh');
   });

    //cargamos los items al celect modelo
    $.post("../ajax/op_vehiculo.php?op=selectModelo", function(r){
        $("#modelo").html(r);
        $("#modelo").selectpicker('refresh');
    });
    //cargamos los items al celect poliza
    $.post("../ajax/poliza.php?op=selectPoliza", function(r){
        $("#poliza").html(r);
        $("#poliza").selectpicker('refresh');
    });

    //cargamos los items al celect tipo
    $.post("../ajax/op_vehiculo.php?op=selectTipo", function(r){
        $("#tipo").html(r);
        $("#tipo").selectpicker('refresh');
    });
}

//funcion limpiar
function limpiar(){

	$("#placa").val("");
    $("#marca").selectpicker('refresh');
    $("#modelo").selectpicker('refresh');
    $("#anio").val("");
    $("#color").val("");
    $("#motor").val("");
    $("#tipo").selectpicker('refresh');
    $("#poliza").selectpicker('refresh');
    $("#ult_mantenimiento").val("");
    $("#prox_mantenimiento").val("");
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
				//messageTop: 'Reporte de vehiculos',
				title: 'Reporte de vehiculos',
				sheetName: 'Vehiculos',
				exportOptions: {
                    columns: ':visible'
                }
			},
			{
                extend: 'pdfHtml5',
				//messageTop: 'Reporte de vehiculos',
				title: 'Reporte de vehiculos',
				download: 'open',
				orientation: 'landscape',
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
			url:'../ajax/vehiculo.php?op=listar',
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
     	url: "../ajax/vehiculo.php?op=guardaryeditar",
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
	$.post("../ajax/vehiculo.php?op=mostrar",{id : id},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#placa").val(data.placa);
            $("#marca").val(data.marca);
            $("#marca").selectpicker('refresh');
            $("#modelo").val(data.modelo);
            $("#modelo").selectpicker('refresh');
			$("#anio").val(data.anio);
			$("#color").val(data.color);
            $("#motor").val(data.motor);
            $("#tipo").val(data.tipo);
            $("#tipo").selectpicker('refresh');
            $("#poliza").val(data.poliza);
            $("#poliza").selectpicker('refresh');
            $("#ult_mantenimiento").val(data.ult_mantenimiento);
            $("#prox_mantenimiento").val(data.prox_mantenimiento);
			$("#id").val(data.id);
		});
}

//funcion para desactivar
function desactivar(id){
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
			$.post("../ajax/vehiculo.php?op=desactivar", {id : id }, function(e){
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

//funcion para desactivar
function activar(id){
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
			$.post("../ajax/vehiculo.php?op=activar", {id : id }, function(e){
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
//FUNCION PARA HACER MAYUSCULAS Y MINUSCULAS LOS VALORES DEL FORMULARIO
function mayus(e) {
	e.value = e.value.toUpperCase();
}
function minus(e) {
	e.value = e.value.toLowerCase();
}


init();