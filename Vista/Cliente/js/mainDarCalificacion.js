$(document).on("click", "#enviar_calificacion", function () {
  var calificacion = $("#calificacion").val(); // Obtener la calificación del formulario
  var idCompra = obtenerIdCompra(); // Obtener el ID de la compra actual
  var comentario = $("#comentario").innertext;
  $.ajax({
    type: "POST",
    url: "Accion/accionCalificarCompra.php",
    data: {
      idCompra: idCompra,
      calificacion: calificacion,
      comentario: comentario,
    },
    success: function (respuesta) {
      var jsonData = JSON.parse(respuesta);
      if (jsonData.success == "1") {
        mostrarMensajeExito();
      } else {
        mostrarMensajeError();
      }
    },
  });
});
