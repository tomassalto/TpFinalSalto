<?php
// Incluir el archivo de configuración u otros archivos necesarios
include_once("../../../configuracion.php");

// Obtener los datos del formulario enviado
$datos = data_submitted();

// Verificar si se recibieron todos los datos necesarios
if (isset($datos["idCompra"], $datos["idUsuario"], $datos["puntuacion"], $datos["comentario"])) {
    // Obtener los datos necesarios del formulario
    $idCompra = $datos["idCompra"];
    $idUsuario = $datos["idUsuario"];
    $puntuacion = $datos["puntuacion"];
    $comentario = $datos["comentario"];

    // En este ejemplo, simplemente se retorna un JSON indicando éxito
    $response = array("success" => 1);
    echo json_encode($response);
} else {
    // Si faltan datos, se retorna un JSON indicando error
    $response = array("success" => 0, "message" => "Faltan datos necesarios para calificar la compra.");
    echo json_encode($response);
}
