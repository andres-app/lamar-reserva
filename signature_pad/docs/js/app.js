function deshabilitar() {
  $('#fborrar').hide();
  $('#fguardar').hide();
  $('#capturaFirma').hide();
  $('#fhabilitar').show();
  $('#Modalfirma').modal('hide');
}
var wrapper = document.getElementById('signature-pad');
//var clearButton = wrapper.querySelector('[data-action=clear]');
//var changeColorButton = wrapper.querySelector('[data-action=change-color]');
//var undoButton = wrapper.querySelector('[data-action=undo]');
//var captureButton = wrapper.querySelector('[data-action=capture]');
//var savePNGButton = wrapper.querySelector('[data-action=save-png]');
//var saveJPGButton = wrapper.querySelector('[data-action=save-jpg]');
//var saveSVGButton = wrapper.querySelector('[data-action=save-svg]');
var canvas = wrapper.querySelector('canvas');
var signaturePad = new SignaturePad(canvas, {
  // It's Necessary to use an opaque color when saving image as JPEG;
  // this option can be omitted if only saving as PNG or SVG
  backgroundColor: 'rgb(255, 255, 255)',
});

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
  $('#fborrar').show();
  $('#fguardar').show();
  $('#fhabilitar').hide();
  $('#capturaFirma').show();
  // When zoomed out to less than 100%, for some very strange reason,
  // some browsers report devicePixelRatio as less than 1
  // and only part of the canvas is cleared then.
  var ratio = Math.max(window.devicePixelRatio || 1, 1);
  // This part causes the canvas to be cleared
  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext('2d').scale(ratio, ratio);

  // This library does not listen for canvas changes, so after the canvas is automatically
  // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
  // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
  // that the state of this library is consistent with visual state of the canvas, you
  // have to clear it manually.
  signaturePad.clear();
}

// On mobile devices it might make more sense to listen to orientation change,
// rather than window resize events.

/*captureButton.addEventListener('click', function (event) {
  window.onresize = resizeCanvas;
  resizeCanvas();
});*/

/*function download(dataURL, filename) {
  if (
    navigator.userAgent.indexOf('Safari') > -1 &&
    navigator.userAgent.indexOf('Chrome') === -1
  ) {
    window.open(dataURL);
  } else {
    var blob = dataURLToBlob(dataURL);
    var url = window.URL.createObjectURL(blob);

    var a = document.createElement('a');
    a.style = 'display: none';
    a.href = url;
    a.download = filename;

    document.body.appendChild(a);
    a.click();

    window.URL.revokeObjectURL(url);
  }
}*/

// One could simply use Canvas#toBlob method instead, but it's just to show
// that it can be done using result of SignaturePad#toDataURL.
function dataURLToBlob(dataURL) {
  // Code taken from https://github.com/ebidel/filer.js
  var parts = dataURL.split(';base64,');
  var contentType = parts[0].split(':')[1];
  var raw = window.atob(parts[1]);
  var rawLength = raw.length;
  var uInt8Array = new Uint8Array(rawLength);

  for (var i = 0; i < rawLength; ++i) {
    uInt8Array[i] = raw.charCodeAt(i);
  }

  return new Blob([uInt8Array], { type: contentType });
}

/*clearButton.addEventListener('click', function (event) {
  signaturePad.clear();
});*/
function limpiar_pad() {
  signaturePad.clear();
}
/*undoButton.addEventListener('click', function (event) {
  var data = signaturePad.toData();

  if (data) {
    data.pop(); // remove the last dot or line
    signaturePad.fromData(data);
  }
});*/

/*changeColorButton.addEventListener('click', function (event) {
  var r = Math.round(Math.random() * 255);
  var g = Math.round(Math.random() * 255);
  var b = Math.round(Math.random() * 255);
  var color = 'rgb(' + r + ',' + g + ',' + b + ')';

  signaturePad.penColor = color;
});*/

//FIRMA EN PNG
/*savePNGButton.addEventListener('click', function (event) {
  if (signaturePad.isEmpty()) {
    alert('Primero proporcione una firma.');
  } else {
    var dataURL = signaturePad.toDataURL();
    //download(dataURL, 'signature.png');
    var idalquiler = $('#idAlquilerf').val();
    $.post(
      '../ajax/alquiler.php?op=mostrar_firma',
      { firma: dataURL, idalquiler: idalquiler },
      function (data, status) {
        // data = JSON.parse(data);
        //var tabla = $('#tbllistado').DataTable();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data,
          showConfirmButton: false,
          timer: 1000,
        });
        // $('#Modaldevolucion').modal('hide');
        //tabla.ajax.reload();
      },
    );
  }
});*/

function guardar_pad() {
  if (signaturePad.isEmpty()) {
    Swal.fire({
      position: 'center',
      icon: 'warning',
      title: 'Primero debe firmar',
      showConfirmButton: false,
      timer: 1000,
    });
  } else {
    var dataURL = signaturePad.toDataURL();
    //download(dataURL, 'signature.png');
    var idalquiler = $('#idAlquilerf').val();
    $.post(
      '../ajax/alquiler.php?op=mostrar_firma',
      { firma: dataURL, idalquiler: idalquiler },
      function (data, status) {
        // data = JSON.parse(data);
        var tabla = $('#tbllistado').DataTable();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data,
          showConfirmButton: false,
          timer: 1000,
        });
        limpiar_pad();
        deshabilitar();
        $('#Modalfirma').modal('hide');
        tabla.ajax.reload();
      },
    );
  }
}
//FIRMA EN JPG
/*saveJPGButton.addEventListener('click', function (event) {
  if (signaturePad.isEmpty()) {
    alert('Primero proporcione una firma.');
  } else {
    var dataURL = signaturePad.toDataURL('image/jpeg');
    //download(dataURL, 'signature.jpg');
    $.post(
      '../ajax/alquiler.php?op=mostrar_firma',
      { firma: dataURL },
      function (data, status) {
        // data = JSON.parse(data);
        alert(data);
      },
    );
  }
});*/

//firma en svg
/*saveSVGButton.addEventListener('click', function (event) {
  if (signaturePad.isEmpty()) {
    alert('Primero proporcione una firma.');
  } else {
    var dataURL = signaturePad.toDataURL('image/svg+xml');
    download(dataURL, 'signature.svg');
  }
});*/
deshabilitar();
