<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class C_Mail
{
    
    public static function enviarCorreoCompraExitosa($correoDestino, $productos, $totalPrecio, $pdfContent)
    {
        $transport = Transport::fromDsn('smtp://tommysaltosac@gmail.com:jcaiuerrvjyhabll@smtp.gmail.com:587');

        // Crear el objeto Mailer
        $mailer = new Mailer($transport);

        // Crear el mensaje del correo electrónico
        $mensaje = self::crearMensajeCompraExitosa($productos, $totalPrecio);

        // Crear una instancia de Email y configurarlo
        $email = (new Email())
            ->from('tommysaltosac@gmail.com')
            ->to($correoDestino)
            ->subject('¡Gracias por tu compra!')
            ->text($mensaje);

        // Adjuntar el PDF
        $email->attach($pdfContent, 'comprobante_compra.pdf', 'application/pdf');

        // Enviar el correo electrónico
        $mailer->send($email);
    }

    private static function crearMensajeCompraExitosa($productos, $totalPrecio)
    {
        $mensaje = '¡Tu compra ha sido realizada con éxito!' . "\n";
        $mensaje .= 'Detalles de la compra:' . "\n";
        foreach ($productos as $producto) {
            $mensaje .= 'Producto: ' . $producto->getObjProducto()->getNombre() . '' . "\n";
            $mensaje .= 'Precio: $' . $producto->getObjProducto()->getProPrecio() * $producto->getCantidad() . '' . "\n";
            $mensaje .= 'Cantidad: ' . $producto->getCantidad() . '' . "\n";
            $mensaje .= "\n"; // Espaciado entre productos
        }
        $mensaje .= 'Precio total: $' . $totalPrecio . "\n";

        return $mensaje;
    }

    public static function generarPDFyCorreo($arrayObjProductoCarrito, $totalPrecio, $compraEstado)
    {
        $modeloCompraEstado = new CompraEstado();
        $objPdf = new C_Pdf();        
        $pdfContent = $objPdf->generarPDF($arrayObjProductoCarrito, $totalPrecio);
        $idCompraEstado = $compraEstado->getIdCompraEstado();
        $mailUsuario = $modeloCompraEstado->obtenerMailUsuarioPorCompraEstado($idCompraEstado);
        C_Mail::enviarCorreoCompraExitosa($mailUsuario, $arrayObjProductoCarrito, $totalPrecio, $pdfContent);
        return $pdfContent;
    }

    public static function enviarCorreoCambioEstadoCompra($correoDestino, $numeroCompra, $nuevoEstado)
    {
        $transport = Transport::fromDsn('smtp://tommysaltosac@gmail.com:jcaiuerrvjyhabll@smtp.gmail.com:587');

        // Crear el objeto Mailer
        $mailer = new Mailer($transport);

        // Crear el mensaje del correo electrónico
        $mensaje = 'Estimado usuario, queremos informarte que el estado de tu compra número ' . $numeroCompra . ' ha sido cambiado a: ' . $nuevoEstado;

        // Crear una instancia de Email y configurarlo
        $email = (new Email())
            ->from('tommysaltosac@gmail.com')
            ->to($correoDestino)
            ->subject('Cambio de estado de compra número: '. $numeroCompra)
            ->text($mensaje);

        // Enviar el correo electrónico
        $mailer->send($email);
    }


}
