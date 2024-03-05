<?php
// include_once("../../../configuracion.php");
// require_once __DIR__ . '/../../../vendor/autoload.php';

// $datos = data_submitted();
// $objCompra = new C_Compra();
// $arrayCompra = $objCompra->buscar($datos);
// $objCompraEstado = new C_CompraEstado();
// $modeloCompraEstado = new CompraEstado();
// $arrayCompraEstado = $objCompraEstado->buscar($datos);
// $idCompra["idCompra"] = $arrayCompraEstado[0]->getCompra()->getIdCompra();
// $arrayObjProductoCarrito = C_CompraItem::obtenerProductos($idCompra);

// if ($arrayObjProductoCarrito != null) {
//     if (C_CompraEstado::modificarEstadoCompraIniciada($datos, $arrayCompraEstado[0])) {
//         $totalPrecio = 0; // Inicializar el total del precio
//         foreach ($arrayObjProductoCarrito as $objProductoCarrito) {
//             C_Producto::modificarStockProducto($objProductoCarrito);
//             $totalPrecio += $objProductoCarrito->getObjProducto()->getProPrecio() * $objProductoCarrito->getCantidad();
//         }       
//         $pdfContent = Pdf::generarPDF($arrayObjProductoCarrito, $totalPrecio);         
//         $idCompraEstado = $arrayCompraEstado[0]->getIdCompraEstado();     
//         $mailUsuario = $modeloCompraEstado->obtenerMailUsuarioPorCompraEstado($idCompraEstado); 
//         C_Mail::enviarCorreoCompraExitosa($mailUsuario, $arrayObjProductoCarrito, $totalPrecio, $pdfContent);

//         echo json_encode(array('success' => 1));
//     } else {
//         echo json_encode(array('success' => 0));
//     }
// } else {
//     echo json_encode(array('success' => 2));
// }

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
