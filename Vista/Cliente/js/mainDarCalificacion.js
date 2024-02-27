
    // Script para manejar la petición AJAX del formulario de calificación
    $(document).ready(function () {
        $('form').submit(function (e) {
            e.preventDefault();
            const forms = document.querySelectorAll('.needs-validation');
            if (forms[0].checkValidity()) {
                $.ajax({
                    type: "POST",
                    url: 'accionCalificarCompra.php',
                    data: $(this).serialize(),
                    success: function (response) {
                        var jsonData = JSON.parse(response);

                        // Mostrar mensaje de éxito o error según la respuesta del servidor
                        if (jsonData.success == "1") {
                            cargaExitosa();
                        } else if (jsonData.success == "0") {
                            cargaFallida();
                        }
                    }
                });
            } else {
                forms[0].classList.add('was-validated');
            }
        });
    });

    function cargaExitosa() {
        Swal.fire({
            icon: 'success',
            title: 'El producto se ha calificado exitosamente.',
            showConfirmButton: false,
            timer: 1500
        });
        setTimeout(function () {
            recargarPagina();
        }, 1500);
    }

    function cargaFallida() {
        Swal.fire({
            icon: 'error',
            title: 'Error al calificar la compra.',
            showConfirmButton: false,
            timer: 1500
        });
        setTimeout(function () {
            recargarPagina();
        }, 1500);
    }

    function recargarPagina() {
        location.reload();
    }
