var tabla

//funcion que se ejecuta al inicio
function init(){

   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });

   $("#formulario_dev").on("submit",function(r){
    guardaryeditar_dev(r);
});

    //cargamos los items al celect marca
   	$.post("../ajax/cliente.php?op=selectCliente", function(r){
   	$("#idcliente").html(r);
   	$("#idcliente").selectpicker('refresh');
   });

    //cargamos los items al celect modelo
    $.post("../ajax/vehiculo.php?op=select_disponibles", function(r){
        $("#idvehiculo").html(r);
        $("#idvehiculo").selectpicker('refresh');
    });

    //obtenemos la fecha actual
	var now = new Date();
	var day =("0"+now.getDate()).slice(-2);
	var month=("0"+(now.getMonth()+1)).slice(-2);
	var today=now.getFullYear()+"-"+(month)+"-"+(day);
    $("#f_entrega_real").val(today);
    
    let h=now.getHours();
    let m=now.getMinutes();
    $("#h_entrega_cliente").val(h+':'+m);
}

//funcion limpiar
function limpiar(){

    $("#id").val("");
    $("#tipo").val("");
    $("#tipo").selectpicker('refresh');
    $("#idcliente").val("");
    $("#idcliente").selectpicker('refresh');
    $("#idvehiculo").val("");
    $("#idvehiculo").selectpicker('refresh');
    $("#dias").val("");
    $("#monto_dia").val("");
    $("#total_pagado").val("");
    $("#f_inicio").val("");
    $("#f_entrega_estimado").val("");
    $("#h_entrega_empresa").val("");
    $("#garantia").val("");

    //entrega
    $("#f_entrega_real").val("");
    $("#h_entrega_cliente").val("");
    $("#observaciones").val("");

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
				title: 'Reporte de alquiler',
				sheetName: 'Alquiler',
				exportOptions: {
                    columns: ':visible'
                }
			},
			{
                extend: 'pdfHtml5',
				//messageTop: 'Reporte de vehiculos',
				title: 'Reporte de alquiler',
                download: 'open',
                //orientation: 'landscape',
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
			url:'../ajax/alquiler.php?op=listar_alquiler',
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
     	url: "../ajax/alquiler.php?op=guardaryeditar",
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

	$.post("../ajax/alquiler.php?op=mostrar",{id : id},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);


            $("#tipo").val(data.tipo);
            $("#tipo").selectpicker('refresh');
            $("#idcliente").val(data.cliente);
            $("#idcliente").selectpicker('refresh');
            $("#idvehiculo").val(data.vehiculo);
            $("#idvehiculo").selectpicker('refresh');
			$("#dias").val(data.dias);
			$("#monto_dia").val(data.monto_dia);
            $("#total_pagado").val(data.total_pagado);
            $("#f_inicio").val(data.f_inicio);
            $("#f_entrega_estimado").val(data.f_entrega_estimado);
            $("#h_entrega_empresa").val(data.h_entrega_empresa);
            $("#garantia").val(data.garantia);
			$("#id").val(data.id);
		});
}

//FUNCION PARA HACER MAYUSCULAS Y MINUSCULAS LOS VALORES DEL FORMULARIO
function mayus(e) {
	e.value = e.value.toUpperCase();
}
function minus(e) {
	e.value = e.value.toLowerCase();
}

function operacion(){
    let dia = $("#dias").val();
    let monto = $("#monto_dia").val();
    let total = parseFloat(dia)*parseFloat(monto);
    $("#total_pagado").val(total.toFixed(2));
}

//funcion para guardar nuevo cliente
function mostrar_entrega(id){
    $("#Modaldevolucion").modal('show');
	$.post("../ajax/alquiler.php?op=mostrar",{id : id},
		function(data,status)
		{
            data=JSON.parse(data);
            //let idalquiler=data.id;
            $("#idalquiler").val(data.id);
            $("#idv").val(data.vehiculo);

		});
}

function guardaryeditar_dev(r){

    r.preventDefault();//no se activara la accion predeterminada 
    $("#btnGuardar_dev").prop("disabled",true);
    var formData=new FormData($("#formulario_dev")[0]);

    $.ajax({
        url: "../ajax/alquiler.php?op=devolucion",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos){
           var tabla = $('#tbllistado').DataTable();
console.log(datos);
               Swal.fire({
                   position: 'center',
                   icon: 'success',
                   title: datos,
                   showConfirmButton: false,
                   timer: 1000
                 });
                 $("#Modaldevolucion").modal('hide');
            tabla.ajax.reload();
        }
    });

    limpiar();
}
init();