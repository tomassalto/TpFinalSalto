<?php

include_once("../../../configuracion.php");

$datos = data_submitted();
$objCompraItem = new C_CompraItem();
if ($objCompraItem->eliminarProductoCarrito($datos)) {
    echo json_encode(array('success' => 1));
} else {
    echo json_encode(array('success' => 0));
}

