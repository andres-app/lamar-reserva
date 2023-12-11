var tabla;

//funcion que se ejecuta al inicio
function init() {
  mostrarform(false);
  listar();

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });

  //cargamos los items al celect documento
  $.post("../ajax/documentos.php?op=selectDocumento", function (r) {
    $("#tipo_documento").html(r);
    $("#tipo_documento").selectpicker("refresh");
  });
}

//funcion limpiar
function limpiar() {
  $("#nombre").val("");
  $("#apellidos").val("");
  $("#num_documento").val("");
  $("#direccion").val("");
  $("#telefono").val("");
  $("#tipo_cliente").selectpicker("refresh");
  $("#email").val("");
  $("#licencia").val("");
  $("#idcliente").val("");
}

//funcion mostrar formulario
function mostrarform(flag) {
  limpiar();
  if (flag) {
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled", false);
    $("#btnagregar").hide();
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
          //messageTop: 'Reporte de clientes',
          title: "Reporte de clientes",
          sheetName: "Clientes",
          exportOptions: {
            columns: ":visible",
          },
        },
        {
          extend: "pdfHtml5",
          //messageTop: 'Reporte de clientes',
          title: "Reporte de clientes",
          download: "open",
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
        url: "../ajax/cliente.php?op=listarc",
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

//funcion para guardaryeditar
function guardaryeditar(e) {
  e.preventDefault(); //no se activara la accion predeterminada
  $("#btnGuardar").prop("disabled", true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../ajax/cliente.php?op=guardaryeditar",
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
}

function mostrar(idcliente) {
  $.post(
    "../ajax/cliente.php?op=mostrar",
    { idcliente: idcliente },
    function (data, status) {
      data = JSON.parse(data);
      mostrarform(true);
      $("#tipo_cliente").val(data.tipo_cliente);
      $("#tipo_cliente").selectpicker("refresh");
      $("#nombre").val(data.nombre);
      $("#apellidos").val(data.apellidos);
      $("#tipo_documento").val(data.tipo_documento);
      $("#tipo_documento").selectpicker("refresh");
      $("#num_documento").val(data.num_documento);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
      $("#email").val(data.email);
      $("#licencia").val(data.licencia);
      $("#idcliente").val(data.idcliente);
    }
  );
}

//funcion para desactivar
function eliminar(idcliente) {
  Swal.fire({
    //title: 'Eliminar?',
    text: "Esá seguro de eliminar ?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Si, borrar",
    cancelButtonText: "No, cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "../ajax/cliente.php?op=eliminar",
        { idcliente: idcliente },
        function (e) {
          Swal.fire(e, "Eliminado!", "success");
          var tabla = $("#tbllistado").DataTable();
          tabla.ajax.reload();
        }
      );
    }
  });
}

//FUNCION EFECTO MIETNRAS BUSCA A LA PERSONA
(function ($) {
  $.ajaxblock = function () {
    $("body").prepend(
      "<div id='ajax-overlay'><div id='ajax-overlay-body' class='center'><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i><span class='sr-only'>Loading...</span></div></div>"
    );
    $("#ajax-overlay").css({
      position: "absolute",
      color: "#FFFFFF",
      top: "0",
      left: "0",
      width: "100%",
      height: "100%",
      position: "fixed",
      background: "rgba(39, 38, 46, 0.67)",
      "text-align": "center",
      "z-index": "9999",
    });
    $("#ajax-overlay-body").css({
      position: "absolute",
      top: "40%",
      left: "50%",
      width: "120px",
      height: "48px",
      "margin-top": "-12px",
      "margin-left": "-60px",
      //background: 'rgba(39, 38, 46, 0.1)',
      "-webkit-border-radius": "10px",
      "-moz-border-radius": "10px",
      "border-radius": "10px",
    });
    $("#ajax-overlay").fadeIn(50);
  };
  $.ajaxunblock = function () {
    $("#ajax-overlay").fadeOut(100, function () {
      $("#ajax-overlay").remove();
    });
  };
})(jQuery);

function busqueda() {
  //$this.button('loading');
  $.ajaxblock();
  $.ajax({
    data: { nruc: $("#ruc").val() },
    type: "POST",
    dataType: "json",
    url: "../ajax/sunat/consulta.php",
  })
    .done(function (data, textStatus, jqXHR) {
      if (data["success"] != "false" && data["success"] != false) {
        $("#json_code").text(JSON.stringify(data, null, "\t"));
        $("#ruc").val("");
        var res = JSON.stringify(data["result"]["RUC"]);
        // alert(data['result']['RUC']);
        //console.log(data);
        // $("#direccion").val(data["result"]["Direccion"]);
        $("#nombre").val(data["result"]["RazonSocial"]);
        $("#num_documento").val(data["result"]["RUC"]);
        let documento = data["result"]["RUC"];

        if (documento.length === 11) {
          $("#tipo_documento").val("RUC");
          $("#tipo_documento").selectpicker("refresh");
          $("#tipo_persona").val("Juridica");
          $("#tipo_persona").selectpicker("refresh");
          //alert(documento.length)
        } else {
          $("#tipo_documento").val("DNI");
          //$("#tipo_documento").selectpicker('refresh');
        }
        if (typeof data["result"] != "undefined") {
          //$("#tbody").html("");
          $.each(data["result"], function (i, v) {
            //$("#tbody").append('<tr><td>'+i+'<\/td><td>'+v+'<\/td><\/tr>');
          });
        }

        $.ajaxunblock();
      } else {
        if (typeof data["msg"] != "undefined") {
          //alert(data["msg"]);
          Swal.fire({
            position: "center",
            icon: "warning",
            title: data["msg"],
            showConfirmButton: false,
            timer: 1000,
          });
          $("#ruc").val("");
          $("#direccion").val("");
          $("#num_documento").val("");
          $("#nombre").val("");
        }
        //$this.button('reset');
        $.ajaxunblock();
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      Swal.fire({
        position: "center",
        icon: "warning",
        title: "Solicitud fallida:" + textStatus,
        showConfirmButton: false,
        timer: 1000,
      });
      //alert("Solicitud fallida:" + textStatus);
      $.ajaxunblock();
    });
}

function busqueda_dni() {
  var nruc = $("#dni").val();

  if (nruc.length == "") {
    Swal.fire({
      position: "center",
      icon: "warning",
      title: "ingresa numero del documento",
      showConfirmButton: false,
      timer: 1000,
    });
    // alert("ingresa numero del documento");
  } else {
    $.ajaxblock();
    //$('.ajaxgif').removeClass('hide');
    $.post(
      "../ajax/reniec/consulta.php",
      { nruc: nruc },
      function (data, status) {
        data = JSON.parse(data);
        console.log(data);
        if (data == null) {
          $.ajaxunblock();
          Swal.fire({
            position: "center",
            icon: "warning",
            title: "Documento inválido o no existe",
            showConfirmButton: false,
            timer: 1000,
          });
          //bootbox.alert("Documento inválido o no existe");
          $("#dni").val("");
          limpiar();
        } else {
          $.ajaxunblock();
          $("#nombre").val(data.name);
          $("#apellidos").val(data.first_name + " " + data.last_name);
          $("#tipo_persona").val("Natural");
          $("#tipo_persona").selectpicker("refresh");
          $("#tipo_documento").val("DNI");
          $("#tipo_documento").selectpicker("refresh");
          $("#num_documento").val(data.dni);
          $("#dni").val("");
        }
      }
    );
  }
}

//FUNCION PARA HACER MAYUSCULAS Y MINUSCULAS LOS VALORES DEL FORMULARIO
function mayus(e) {
  e.value = e.value.toUpperCase();
}
function minus(e) {
  e.value = e.value.toLowerCase();
}

init();
