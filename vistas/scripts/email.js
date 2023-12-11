var tabla;

//funcion que se ejecuta al inicio
function init() {
  mostrarform(false);
  listar();

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });
}

//funcion limpiar
function limpiar() {
  $("#id").val("");
  $("#host").val("");
  $("#usuario").val("");
  $("#clave").val("");
  $("#puerto").val("");
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

//funcion listar
function listar() {
  tabla = $("#tbllistado")
    .dataTable({
      aProcessing: true, //activamos el procedimiento del datatable
      aServerSide: true, //paginacion y filrado realizados por el server
      lengthChange: false,
      buttons: [
        {
          extend: "excelHtml5",
          //messageTop: 'Reporte de vehiculos',
          title: "Email",
          sheetName: "Email",
          exportOptions: {
            columns: ":visible",
          },
        },
        {
          extend: "pdfHtml5",
          //messageTop: 'Reporte de vehiculos',
          title: "Email",
          download: "open",
          //orientation: 'landscape',
          pageSize: "A4",
          exportOptions: {
            columns: ":visible",
          },
        },
      ],
      ajax: {
        url: "../ajax/email.php?op=listar",
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
    url: "../ajax/email.php?op=guardaryeditar",
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

function mostrar(id) {
  $.post("../ajax/email.php?op=mostrar", { id: id }, function (data, status) {
    data = JSON.parse(data);
    mostrarform(true);

    $("#host").val(data.host);
    $("#usuario").val(data.usuario);
    $("#clave").val(data.clave);
    $("#puerto").val(data.puerto);
    $("#receptor").val(data.receptor);
    $("#id").val(data.id);
  });
}

init();
