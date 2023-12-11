var tabla;

//funcion que se ejecuta al inicio
function init() {
  listar();
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
        url: "../ajax/email.php?op=listar_enviados",
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

//funcion para desactivar
function eliminar(id) {
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
      $.post("../ajax/email.php?op=eliminar", { id: id }, function (e) {
        Swal.fire(e, "Eliminado!", "success");
        var tabla = $("#tbllistado").DataTable();
        tabla.ajax.reload();
      });
    }
  });
}
init();
