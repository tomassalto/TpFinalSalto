<?php
include_once("../../../configuracion.php");


$datos = data_submitted();
if (C_CompraEstado::modificarEstadoCompra($datos)) {
    echo json_encode(array('success' => 1));
} else {
    echo json_encode(array('success' => 0));
}



