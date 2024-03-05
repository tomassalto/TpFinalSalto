<?php

include_once("../../../configuracion.php");
require_once __DIR__ . '/../../../vendor/autoload.php';

$datos = data_submitted();
$objCompra = new C_Compra();
$arrayCompra = $objCompra->buscar($datos);
$objCompraEstado = new C_CompraEstado();
$arrayCompraEstado = $objCompraEstado->buscar($datos);
$idCompra["idCompra"] = $arrayCompraEstado[0]->getCompra()->getIdCompra();
$arrayObjProductoCarrito = C_CompraItem::obtenerProductos($idCompra);

if ($arrayObjProductoCarrito != null) {
    if ($objCompraEstado->modificarEstadoCompraIniciada($datos, $arrayCompraEstado[0])) {        
        foreach ($arrayObjProductoCarrito as $objProductoCarrito) {
            C_Producto::modificarStockProducto($objProductoCarrito);
        }
        $totalPrecio = C_CompraItem::calcularTotalPrecio($arrayObjProductoCarrito);
        $pdfContent = C_Mail::generarPDFyCorreo($arrayObjProductoCarrito, $totalPrecio, $arrayCompraEstado[0]);

        echo json_encode(array('success' => 1));
    } else {
        echo json_encode(array('success' => 0));
    }
} else {
    echo json_encode(array('success' => 2));
}
