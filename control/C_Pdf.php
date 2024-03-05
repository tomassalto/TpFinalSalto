<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class C_Pdf
{
    public static function generarPDF($productos, $totalPrecio)
    {
        
        // Crear una instancia de Dompdf con algunas opciones predeterminadas
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
  
        $html = '<h1 style="text-align: center;">Gracias por comprar en MusicTime!</h1>';
        $html .= '<h2>Comprobante de Compra</h2>';
        $html .= '<p>Detalles de la compra:</p>';
        foreach ($productos as $producto) {
            // Obtener información del producto actual
            $nombreProducto = $producto->getObjProducto()->getNombre();
            $precioUnitario = $producto->getObjProducto()->getProPrecio();
            $cantidad = $producto->getCantidad();

            $html .= "<p><strong>Producto:</strong> " . $nombreProducto . "</p>\n";
            $html .= "<p><strong>Precio unitario:</strong> $" . $precioUnitario . "</p>\n";
            $html .= "<p><strong>Cantidad:</strong> " . $cantidad . "</p>\n";
            $html .= "\n";
            $html .= "\n";
            $html .= "\n";
        }
       
        $html .= '<p><strong>Precio Total:</strong> $' . $totalPrecio . '</p>';

        // Cargar el contenido HTML en Dompdf
        $dompdf->loadHtml($html);

        // Renderizar el PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $output = $dompdf->output();

        // Guardar el PDF en el servidor
        file_put_contents('comprobante_compra.pdf', $output);

        return $output;
    }
}
