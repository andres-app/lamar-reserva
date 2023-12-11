var tabla;

//funcion que se ejecuta al inicio
function init() {
  mostrarform(false);
  listar();

  $("#formulario").on("submit", function (e) {
    guardar(e);
  });

  $("#formulario_editar").on("submit", function (ed) {
    editar(ed);
  });

  $("#formulario_dev").on("submit", function (r) {
    guardaryeditar_dev(r);
  });

  $("#formulario_firma").on("submit", function (fi) {
    guardar_firma(fi);
  });

  //cargamos los items al celect cliente
  $.post("../ajax/cliente.php?op=selectCliente", function (r) {
    $("#idcliente").html(r);
    $("#idcliente").selectpicker("refresh");
  });

  //cargamos los items al celect vehiculo
  $.post("../ajax/vehiculo.php?op=select_disponibles", function (r) {
    $("#idvehiculo").html(r);
    $("#idvehiculo").selectpicker("refresh");
  });
}

//funcion limpiar
function limpiar() {
  $("#id").val("");
  $("#tipo").val("");
  $("#tipo").selectpicker("refresh");
  $("#idcliente").val("");
  $("#idcliente").selectpicker("refresh");
  $("#idvehiculo").val("");
  $("#idvehiculo").selectpicker("refresh");
  $("#dias").val("");
  $("#monto_dia").val("");
  $("#total_pagado").val("");
  $("#f_inicio").val("");
  $("#f_entrega_estimado").val("");
  $("#h_entrega_empresa").val("");
  $("#garantia").val("");
  $("#combustible_al").val("");
  $("#combustible_al").selectpicker("refresh");

  //devolucion
  $("#dias_exedidos").val("");
  $("#pago_exedido").val("");
  $("#km_entrega").val("");
  $("#punto_recepcion").val("");

  $("#combustible_al_dev").val("");
  $("#combustible_al_dev").selectpicker("refresh");

  //entrega
  $("#f_entrega_real").val("");
  $("#h_entrega_cliente").val("");
  $("#observaciones").val("");
  $("#observaciones_al").val("");
  $("#punto_entrega").val("");
}

$("#dias").change(function () {
  //calcula fecha automatico
  var dias = $("#dias").val();
  fecha = new Date($("#f_inicio").val());
  entrega = new Date();
  dia = fecha.getDate();
  mes = fecha.getMonth() + 1; // +1 porque los meses empiezan en 0
  anio = fecha.getFullYear();

  entrega.setDate(entrega.getDate() + parseInt(dias));
  dia_dev = ("0" + entrega.getDate()).slice(-2);
  mes_dev = ("0" + (entrega.getMonth() + 1)).slice(-2);
  fecha_dev = entrega.getFullYear() + "-" + mes_dev + "-" + dia_dev;
  console.log(fecha_dev);
  $("#f_entrega_estimado").val(fecha_dev);
});
$("#f_inicio").change(function () {
  //calcula fecha automatico
  var dias = $("#dias").val();
  fecha = new Date($("#f_inicio").val());
  entrega = new Date();
  dia = fecha.getDate();
  mes = fecha.getMonth() + 1; // +1 porque los meses empiezan en 0
  anio = fecha.getFullYear();

  entrega.setDate(entrega.getDate() + parseInt(dias));
  dia_dev = ("0" + entrega.getDate()).slice(-2);
  mes_dev = ("0" + (entrega.getMonth() + 1)).slice(-2);
  fecha_dev = entrega.getFullYear() + "-" + mes_dev + "-" + dia_dev;
  console.log(fecha_dev);
  $("#f_entrega_estimado").val(fecha_dev);
});
//funcion mostrar formulario
function mostrarform(flag) {
  limpiar();
  if (flag) {
    //obtenemos la fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + month + "-" + day;
    $("#f_inicio").val(today);

    var h = ("0" + now.getHours()).slice(-2);
    var m = ("0" + now.getMinutes()).slice(-2);
    var s = ("0" + now.getSeconds()).slice(-2);
    var hora = h + ":" + m + ":" + s;
    $("#h_entrega_empresa").val(hora);

    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled", false);
    $("#btnagregar").hide();
    $.post("../ajax/alquiler.php?op=lista_accesorios", function (r) {
      $("#accesorios").html(r);
    });
  } else {
    $("#listadoregistros").show();
    $("#formularioregistros").hide();
    $("#btnagregar").show();
  }
}

//cancelar form
function cancelarform() {
  limpiar();
  mostrarform(false);
}

function listar() {
  var tabla = $("#tbllistado")
    .dataTable({
      language: {
        search: "Buscar:",
        zeroRecords: "No se encontró nada, lo siento",
        info: "mostrando de _START_ a _END_ de _TOTAL_ elementos",
        infoEmpty: "No hay registros disponibles",
        paginate: {
          previous: "Anterior",
          next: "Siguiente",
        },
      },
      aProcessing: true, //activamos el procedimiento del datatable
      aServerSide: true, //paginacion y filrado realizados por el server
      lengthChange: false,
      buttons: [
        {
          extend: "excelHtml5",
          //messageTop: 'Reporte de vehiculos',
          title: "Reporte de alquiler",
          sheetName: "Alquiler",
          exportOptions: {
            columns: ":visible",
          },
        },
        {
          extend: "pdfHtml5",
          //messageTop: 'Reporte de vehiculos',
          title: "Reporte de alquiler",
          download: "open",
          //orientation: 'landscape',
          pageSize: "A3",
          exportOptions: {
            columns: ":visible",
          },
        },
        {
          extend: "colvis",
          text: "Selector",
        },
      ],
      ajax: {
        url: "../ajax/alquiler.php?op=listar_alquiler",
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      iDisplayLength: 10, //paginacion
      order: [[0, "desc"]], //ordenar (columna, orden)
      initComplete: function () {
        tabla
          .buttons()
          .container()
          .appendTo("#tbllistado_wrapper .col-md-6:eq(0)");
      },
    })
    .DataTable();
}

//funcion para guardar
function guardar(e) {
  e.preventDefault(); //no se activara la accion predeterminada
  $("#btnGuardar").prop("disabled", true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../ajax/alquiler.php?op=guardar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      var tabla = $("#tbllistado").DataTable();

      Swal.fire({
        position: "center",
        icon: "success",
        title: datos,
        showConfirmButton: false,
        timer: 1000,
      });
      mostrarform(false);
      tabla.ajax.reload();
    },
  });

  limpiar();
  alerta_fecha_inicio();
}

function calcular(id) {
  $("#accesorio_alqulado" + id)
    .on("change", function () {
      if ($("#accesorio_alqulado" + id).is(":checked")) {
        $("#accesorio_alqulado" + id).val("1");
        $("#" + id).val("1");
        $("#" + id).prop("disabled", true);
      } else {
        $("#accesorio_alqulado" + id).val("0");

        $("#" + id).val("0");
        $("#" + id).prop("disabled", false);
      }
    })
    .triggerHandler("change");
}

function calcular_dev(id) {
  $("#accesorio_devuelto" + id)
    .on("change", function () {
      if ($("#accesorio_devuelto" + id).is(":checked")) {
        $("#accesorio_devuelto" + id).val("1");
        $("#" + id).val("1");
        $("#" + id).prop("disabled", true);
      } else {
        $("#accesorio_devuelto" + id).val("0");

        $("#" + id).val("0");
        $("#" + id).prop("disabled", false);
      }
    })
    .triggerHandler("change");
}
function editar(ed) {
  ed.preventDefault(); //no se activara la accion predeterminada
  $("#btnEditar").prop("disabled", true);
  var formData = new FormData($("#formulario_editar")[0]);

  $.ajax({
    url: "../ajax/alquiler.php?op=editar",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      var tabla = $("#tbllistado").DataTable();

      Swal.fire({
        position: "center",
        icon: "success",
        title: datos,
        showConfirmButton: false,
        timer: 1000,
      });
      $("#ModalEditar").modal("hide");
      tabla.ajax.reload();
    },
  });

  limpiar();
}
function mostrar(id, vehiculo) {
  $("#ModalEditar").modal("show");
  //cargamos los items al celect cliente
  $.post("../ajax/cliente.php?op=selectCliente", function (r) {
    $("#idcliente_e").html(r);
    $("#idcliente_e").selectpicker("refresh");
  });

  //cargamos los items al celect vehiculo
  $.post("../ajax/vehiculo.php?op=select_e", { id_e: vehiculo }, function (r) {
    $("#idvehiculo_e").html(r);
    $("#idvehiculo_e").selectpicker("refresh");
  });
  $.post(
    "../ajax/alquiler.php?op=mostrar",
    { id: id },
    function (data, status) {
      data = JSON.parse(data);
      $("#tipo_e").val(data.tipo);
      $("#tipo_e").selectpicker("refresh");
      $("#idcliente_e").val(data.cliente);
      $("#idcliente_e").selectpicker("refresh");
      $("#idvehiculo_e").val(data.vehiculo);
      $("#idvehiculo_e").selectpicker("refresh");
      $("#combustible_al").val(data.combustible_al);
      $("#combustible_al").selectpicker("refresh");
      $("#dias_e").val(data.dias);
      $("#km_e").val(data.km);
      $("#monto_dia_e").val(data.monto_dia);
      $("#total_pagado_e").val(data.total_pagado);
      $("#f_inicio_e").val(data.f_inicio);
      $("#f_entrega_estimado_e").val(data.f_entrega_estimado);
      $("#h_entrega_empresa_e").val(data.h_entrega_empresa);
      $("#garantia_e").val(data.garantia);
      $("#punto_entrega_e").val(data.punto_entrega);
      $("#observaciones_al_e").val(data.observaciones_al);
      $("#id").val(data.id);
    }
  );
}

//FUNCION PARA HACER MAYUSCULAS Y MINUSCULAS LOS VALORES DEL FORMULARIO
function mayus(e) {
  e.value = e.value.toUpperCase();
}
function minus(e) {
  e.value = e.value.toLowerCase();
}

function operacion() {
  let dia = $("#dias").val();
  let monto = $("#monto_dia").val();
  let total = parseFloat(dia) * parseFloat(monto);
  $("#total_pagado").val(total.toFixed(2));

  let dia_e = $("#dias_e").val();
  let monto_e = $("#monto_dia_e").val();
  let total_e = parseFloat(dia_e) * parseFloat(monto_e);
  $("#total_pagado_e").val(total_e.toFixed(2));
}

//funcion para guardar nuevo cliente
function mostrar_entrega(id) {
  $("#Modaldevolucion").modal("show");
  //obtenemos la fecha actual
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear() + "-" + month + "-" + day;
  $("#f_entrega_real").val(today);

  var h = ("0" + now.getHours()).slice(-2);
  var m = ("0" + now.getMinutes()).slice(-2);
  var s = ("0" + now.getSeconds()).slice(-2);
  var hora = h + ":" + m + ":" + s;
  $("#h_entrega_cliente").val(hora);

  $.post(
    "../ajax/alquiler.php?op=mostrar",
    { id: id },
    function (data, status) {
      data = JSON.parse(data);
      //let idalquiler=data.id;
      $("#idalquiler").val(data.id);
      $("#idv").val(data.vehiculo);
      var pago_ex = data.monto_dia;
      var h_estimado = data.h_entrega_empresa;
      var fecha_estimado = data.f_entrega_estimado;
      calcular_exedidos(pago_ex, h_estimado, fecha_estimado);
      $("#f_entrega_real").change(function () {
        calcular_exedidos(pago_ex, h_estimado, fecha_estimado);
      });
      $("#h_entrega_cliente").change(function () {
        calcular_exedidos(pago_ex, h_estimado, fecha_estimado);
      });
    }
  );
  $.post(
    "../ajax/alquiler.php?op=lista_accesorios_dev",
    { id: id },
    function (r) {
      $("#accesorios_dev").html(r);
    }
  );
}

function calcular_exedidos(pago_ex, h_estimado, fecha_estimado) {
  var fecha1 = moment(fecha_estimado);
  var fecha2 = moment($("#f_entrega_real").val());
  var dias = fecha2.diff(fecha1, "days");
  if (dias > 0) {
    $("#horas_exedidos").html(dias + "Dias.");
    $("#dias_exedidos").val(dias);
    var total_ex = dias * pago_ex;
    $("#pago_exedido").val(total_ex);
  } else {
    function newDate(partes) {
      var date = new Date(0);
      date.setHours(partes[0]);
      date.setMinutes(partes[1]);
      return date;
    }

    function prefijo(num) {
      return num < 10 ? "0" + num : num;
    }

    var dateDesde = newDate(h_estimado.split(":"));
    var dateHasta = newDate($("#h_entrega_cliente").val().split(":"));

    //var hour = Math.floor(seconds / 3600);
    var minutos = (dateHasta - dateDesde) / 1000 / 60;
    var horas = Math.floor(minutos / 60);
    var segundos = Math.floor(minutos * 60);

    //console.log("horas: " + horas);
    //console.log("minutos: " + minutos);
    //console.log("segundos: " + segundos);

    if (segundos > 3600) {
      $("#horas_exedidos").html(prefijo(horas) + "Hrs.");
      $("#dias_exedidos").val("1");
      var total_ex = 1 * pago_ex;
      $("#pago_exedido").val(total_ex);
    } else {
      $("#horas_exedidos").html(prefijo(horas));
      $("#dias_exedidos").val("0");
      $("#pago_exedido").val("0");
    }
  }
}

function guardaryeditar_dev(r) {
  r.preventDefault(); //no se activara la accion predeterminada
  $("#btnGuardar_dev").prop("disabled", true);
  var formData = new FormData($("#formulario_dev")[0]);

  $.ajax({
    url: "../ajax/alquiler.php?op=devolucion",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      var tabla = $("#tbllistado").DataTable();
      console.log(datos);
      Swal.fire({
        position: "center",
        icon: "success",
        title: datos,
        showConfirmButton: false,
        timer: 1000,
      });
      $("#Modaldevolucion").modal("hide");
      tabla.ajax.reload();
    },
  });

  limpiar();
}

function mostrar_modal_firma(id) {
  $("#Modalfirma").modal("show");
  $("#idAlquilerf").val(id);
  $("#capturaFirma").html("hola");
}

function guardar_firma(fi) {
  r.preventDefault(); //no se activara la accion predeterminada
  $("#btnGuardar_firma").prop("disabled", true);
  var formData = new FormData($("#formulario_firma")[0]);

  $.ajax({
    url: "../ajax/alquiler.php?op=devolucion",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,

    success: function (datos) {
      var tabla = $("#tbllistado").DataTable();
      console.log(datos);
      Swal.fire({
        position: "center",
        icon: "success",
        title: datos,
        showConfirmButton: false,
        timer: 1000,
      });
      $("#Modalfirma").modal("hide");
      tabla.ajax.reload();
    },
  });

  limpiar();
}

//Alerta de inicio de contratos de los autos
function alerta_fecha_inicio() {
  $.post("../ajax/email.php?op=afechainicio", function (r) {
    if (r.length > 0) {
      //console.log(r);
      var datos = r;
      var asunto = "Inicio de contrato";
      enviar_alerta(datos, asunto);
    } else {
      console.log("no hay nada para enviar");
    }
  });
}

function enviar_alerta(datos, asunto) {
  //console.log(asunto);
  $.post(
    "../ajax/email.php?op=enviar_alerta",
    { datos: datos, asunto: asunto },
    function (r) {
      console.log(r);
    }
  );
}

function ver_dni(id) {
  $.post(
    "../ajax/alquiler.php?op=mostrar",
    { id: id },
    function (data, status) {
      data = JSON.parse(data);
      $("#ModalVerDNI").modal("show");
      $("#dnianverso").attr(
        "src",
        "../files/documentos/" + data.dni_cliente_anv
      );
      $("#dnireverso").attr(
        "src",
        "../files/documentos/" + data.dni_cliente_rev
      );
      //console.log(data.dni_cliente_anv);
      //console.log(data.dni_cliente_rev);
    }
  );
}
function imprimir() {
  $("#print").printArea();
}
init();
