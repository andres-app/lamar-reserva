function init() {
  let horas_dev = setInterval("alerta_fecha_devolucion()", 15000);
  let horas_mant = setInterval("alerta_fecha_matenimiento()", 15000);
}

//Alerta de vencimiento de contratos de los autos (Dia de devolución)
function alerta_fecha_devolucion() {
  var d = new Date();
  let horas =
    ("00" + d.getHours()).slice(-2) + ":" + ("00" + d.getMinutes()).slice(-2);
  //console.log(horas);
  if (horas === "19:30") {
    $.post("../ajax/email.php?op=afechadevolucion", function (r) {
      if (r.length > 0) {
        //console.log(r);
        var datos = r;
        var asunto = "Vencimiento de contrato";
        enviar_alerta(datos, asunto);
      } else {
        console.log("no hay nada para enviar");
      }
    });
  }
}

//Alerta de próximo Mantenimiento de los autos
function alerta_fecha_matenimiento() {
  var d = new Date();
  let horas =
    ("00" + d.getHours()).slice(-2) + ":" + ("00" + d.getMinutes()).slice(-2);
  //console.log(horas);
  if (horas === "19:30") {
    $.post("../ajax/email.php?op=afechamantenimiento", function (r) {
      if (r.length > 0) {
        //console.log(r);
        var datos = r;
        var asunto = "Mantenimiento";
        enviar_alerta(datos, asunto);
      } else {
        console.log("no hay nada para enviar");
      }
    });
  }
}

function enviar_alerta(datos, asunto) {
  //console.log(asunto);
  $.post(
    "../ajax/email.php?op=validar_envio",
    { asunto: asunto },
    function (a) {
      if (a.length > 0) {
        console.log("Ya se envio el mensaje");
      } else {
        $.post(
          "../ajax/email.php?op=enviar_alerta",
          { datos: datos, asunto: asunto },
          function (r) {
            console.log(r);
          }
        );
      }
    }
  );
}
init();
