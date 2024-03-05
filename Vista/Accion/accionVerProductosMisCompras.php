<?php
include_once("../../configuracion.php");

$datos = data_submitted();
$objCompraItem = new C_CompraItem();
$arrayCompraItem = $objCompraItem->buscar($datos);
if ($arrayCompraItem != null) {
    $arrayJS = $objCompraItem->arrayArmadoJS($arrayCompraItem);
    echo json_encode(array('success' => $arrayJS));
} else {
    echo json_encode(array('success' => 0));
}


