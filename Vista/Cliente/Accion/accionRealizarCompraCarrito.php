<?php
include_once("../../../configuracion.php");
require_once __DIR__ . '/../../../vendor/autoload.php';

// config/packages/mailer.php
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;
use Symfony\Config\FrameworkConfig;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;


$transport = Transport::fromDsn('smtp://tommysaltosac@gmail.com:jcaiuerrvjyhabll@smtp.gmail.com:587');


// Crear el objeto Mailer
$mailer = new Mailer($transport);

$datos = data_submitted();
$objCompra = new C_Compra();
$arrayCompra = $objCompra->buscar($datos);
$objCompraEstado = new C_CompraEstado();
$modeloCompraEstado = new CompraEstado();
$arrayCompraEstado = $objCompraEstado->buscar($datos);
$idCompra["idCompra"] = $arrayCompraEstado[0]->getCompra()->getIdCompra();
$arrayObjProductoCarrito = obtenerProductos($idCompra);

if ($arrayObjProductoCarrito != null) {
    if (modificarEstadoCompra($datos, $arrayCompraEstado[0])) {
        $totalPrecio = 0; // Inicializar el total del precio
        foreach ($arrayObjProductoCarrito as $objProductoCarrito) {
            modificarStockProducto($objProductoCarrito);
            $totalPrecio += $objProductoCarrito->getObjProducto()->getProPrecio() * $objProductoCarrito->getCantidad();
        }
        $idCompraEstado = $arrayCompraEstado[0]->getIdCompraEstado();
        $mailUsuario = $modeloCompraEstado->obtenerMailUsuarioPorCompraEstado($idCompraEstado);
        // Construir el mensaje del correo electrónico con los datos del producto
        $mensaje = '¡Tu compra ha sido realizada con éxito!'. "\n";
        $mensaje .= 'Detalles de la compra:'. "\n";
        $mensaje .= "\n";
        foreach ($arrayObjProductoCarrito as $objProductoCarrito) {
            $mensaje .= 'Producto: ' . $objProductoCarrito->getObjProducto()->getNombre() . ''. "\n";
            $mensaje .= 'Precio: $' . $objProductoCarrito->getObjProducto()->getProPrecio() * $objProductoCarrito->getCantidad() .''. "\n";
            $mensaje .= 'Cantidad: ' . $objProductoCarrito->getCantidad() . ''. "\n";
            // Puedes agregar más detalles del producto según tu estructura de datos
            $mensaje .= "\n"; // Espaciado entre productos
        }
        $mensaje .= 'Precio total: $'.$totalPrecio. "\n";
        // Crear una instancia de Email y configurarlo
        $email = (new Email())
        ->from('tommysaltosac@gmail.com') // Reemplaza con tu dirección de correo electrónico
        ->to($mailUsuario) // El correo electrónico del usuario que realizó la compra
        ->subject('¡Gracias por tu compra!')
        ->text($mensaje);
        // Enviar el correo electrónico
        $mailer->send($email);

        echo json_encode(array('success' => 1));
    
     
    } else {
        echo json_encode(array('success' => 0));
    }
} else {
    echo json_encode(array('success' => 2));
}


/* Devuelve todos los productos del idCompra */
function obtenerProductos($idCompra)
{
    $objCompraItem = new C_CompraItem;
    $arrayCompraItem = $objCompraItem->buscar($idCompra);
    return $arrayCompraItem;
}

/* Modifica el estado de la compra a "iniciada" */
function modificarEstadoCompra($datos, $compraEstado)
{
    $objCompraEstado = new C_CompraEstado();
    $resp = false;
    $paramCompraEstado = null;
    $fecha = new DateTime();
    $fechaStamp = $fecha->format('Y-m-d H:i:s');
    $paramCompraEstado = [
        "idCompraEstado" => $datos["idCompraEstado"],
        "idCompra" => $compraEstado->getCompra()->getIdCompra(),
        "idCompraEstadoTipo" => 2,
        "ceFechaIni" => $fechaStamp,
        "ceFechaFin" => null,
    ];
    if ($objCompraEstado->modificacion($paramCompraEstado)) {
        $resp = true;
    }
    return $resp;
}

/* Modifica el es stock del producto */
function modificarStockProducto($objProductoCarrito)
{
    $objProducto = new C_Producto();
    $idProducto["idProducto"] = $objProductoCarrito->getObjProducto()->getIdProducto();
    $arrayProducto = $objProducto->buscar($idProducto);
    $resp = false;
    $stockTot = $arrayProducto[0]->getCantStock() - $objProductoCarrito->getCantidad();
    $paramProducto = [
        "idProducto" => $arrayProducto[0]->getIdProducto(),
        "proNombre" => $arrayProducto[0]->getNombre(),
        "proDetalle" => $arrayProducto[0]->getDetalle(),
        "proPrecio" => $arrayProducto[0]->getProPrecio(),
        "urlImagen" => $arrayProducto[0]->getUrlImagen(),
        "proCantStock" => $stockTot
    ];
    if ($objProducto->modificacion($paramProducto)) {
        $resp = true;
    }
    return $resp;
}
