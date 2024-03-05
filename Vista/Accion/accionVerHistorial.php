<?php
include_once("../../configuracion.php");

$datos = data_submitted();
$objCompraEstado = new C_CompraEstado();
$arrayCompraEstado = $objCompraEstado->buscar($datos);
if ($arrayCompraEstado != null) {
    $arrayJS = $objCompraEstado->arrayArmadoJS($arrayCompraEstado);
    echo json_encode(array('success' => $arrayJS));
} else {
    echo json_encode(array('success' => 0));
}


