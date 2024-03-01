<?php
include_once("../../../configuracion.php");

// Verificar si se recibieron los datos del formulario
$datos = data_submitted();

$objCompra = new C_Compra();
$objSesion = new C_Session();
$objCompraItem = new C_CompraItem();
$objModelCI = new CompraItem();
$objUsuario = $objSesion->getUsuario();
$idCompra = $datos["idCompra"];
$productos = $objCompraItem->buscar($idCompra);

$idUsuario["idUsuario"] = $objUsuario->getIdUsuario();
$idProductos = []; // Array para almacenar los ID de producto

if ($productos) {
    // Iterar sobre los productos y obtener los idProducto
    foreach ($productos as $producto) {
        $idProductos[] = $producto->getObjProducto()->getIdProducto();
    }
}

print_r($idProductos);
die;
// $compra = $objCompra->buscarPorId($datos['idCompra']);

// // Verificar si se encontró la compra y si su estado es "enviada"
// if ($compra && $compra->getEstado() == "enviada") {
//     // El estado de la compra es "enviada", podemos guardar la calificación
//     $objCalificacion = new C_Calificacion();
//     $parametros = array(
//         "idCompra" => $datos['idCompra'],
//         "calificacion" => $datos['calificacion']
//         // Puedes agregar más campos según tus necesidades
//     );
//     if ($objCalificacion->guardarCalificacion($parametros)) {
//         echo json_encode(array('success' => 1));
//     } else {
//         echo json_encode(array('success' => 0));
//     }
// } else {
//     // Si la compra no se encontró o su estado no es "enviada", retornar un mensaje de error
//     echo json_encode(array('success' => 0));
// }
