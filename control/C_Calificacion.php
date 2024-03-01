<?php
include_once("Calificacion.php");

class C_Calificacion
{
    // Método para guardar una nueva calificación del 1 al 5
    // public function guardarCalificacion($idCompra, $idUsuario, $puntuacion, $comentario)
    // {
    //     // Validar que la puntuación esté en el rango correcto (de 1 a 5)
    //     if ($puntuacion < 1 || $puntuacion > 5) {
    //         // Manejar el error, lanzar una excepción, etc.
    //         return false;
    //     }

    //     // Crear una instancia de la clase Calificacion
    //     $calificacion = new Calificacion($idCompra, $idUsuario, $puntuacion, $comentario);

    //     // Guardar la calificación en la base de datos
    //     return $calificacion->guardarCalificacion();
    // }

    private function cargarObjetoCalificacion($param)
    {
        $obj = null;
        if (
            array_key_exists('idCompra', $param) &&
            array_key_exists('idProducto', $param) &&
            array_key_exists('idUsuario', $param) &&
            array_key_exists('puntuacion', $param) &&
            array_key_exists('comentario', $param)
        ) {
            $obj = new Calificacion();
            $obj->setIdCompra($param['idCompra']);
            $obj->setIdProducto($param['idProducto']);
            $obj->setIdUsuario($param['idUsuario']);
            $obj->setPuntuacion($param['puntuacion']);
            $obj->setComentario($param['comentario']);
            // Si deseas establecer la fecha actual, puedes hacerlo aquí
            // $obj->setFecha(date('Y-m-d H:i:s'));
        }
        return $obj;
    }

}
