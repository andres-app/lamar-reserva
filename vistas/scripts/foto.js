//funcion que se ejecuta al inicio
function init_dni() {
  $("#formulariodnia").on("submit", function (c) {
    agregar_dnia(c);
  });

  $("#formulariodnir").on("submit", function (e) {
    agregar_dnir(e);
  });
  //mostramos los permisos
}

//funcion limpiar_dni
function limpiar_dni() {
  // $("#imagenmuestra").attr("src", "");
  $("#idalquilerdnia").val("");
  $("#Modaldnia").modal("hide");
  $("#idalquilerdnir").val("");
  $("#Modaldnir").modal("hide");
}

function mostrar_modal_dnia(id) {
  $("#Modaldnia").modal("show");
  $("#idalquilerdnia").val(id);
}

function mostrar_modal_dnir(id) {
  $("#Modaldnir").modal("show");
  $("#idalquilerdnir").val(id);
}

//funcion para guardaryeditar
function agregar_dnia(c) {
  c.preventDefault(); //no se activara la accion predeterminada
  $("#btnGuardardnia").prop("disabled", true);
  var formData = new FormData($("#formulariodnia")[0]);

  $.ajax({
    url: "../ajax/alquiler.php?op=guardar_dni_anv",
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
      tabla.ajax.reload();
    },
  });
  limpiar_dni();
}

function agregar_dnir(e) {
  e.preventDefault(); //no se activara la accion predeterminada
  $("#btnGuardardnir").prop("disabled", true);
  var formData = new FormData($("#formulariodnir")[0]);

  $.ajax({
    url: "../ajax/alquiler.php?op=guardar_dni_rev",
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
      tabla.ajax.reload();
    },
  });
  limpiar_dni();
}
init_dni();
