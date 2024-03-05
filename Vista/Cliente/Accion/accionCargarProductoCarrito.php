<?php
include_once("../../../configuracion.php");


$datos = data_submitted();
$objCompraEstadoBorrador = null;
$arrayCompras = null;
$objSesion = new C_Session();
$objCompraItem = new C_CompraItem();
$objCompraEstado = new C_CompraEstado();
$objUsuario = $objSesion->getUsuario();
$idUsuario["idUsuario"] = $objUsuario->getIdUsuario();
$arrayCompras = C_Compra::buscarComprasUsuario($idUsuario);
if ($arrayCompras != null) {
    $objCompraEstadoBorrador = $objCompraEstado->buscarCompraBorrador($arrayCompras);
    if ($objCompraEstadoBorrador != null) {
        $objCompraItem->cargarProducto($objCompraEstadoBorrador, $datos);
    }
}
if (($arrayCompras == null) || ($objCompraEstadoBorrador == null)) {
    $objCompraEstadoBorrador = C_Compra::crearCompra($idUsuario);
    $objCompraItem->cargarProducto($objCompraEstadoBorrador, $datos);
}

