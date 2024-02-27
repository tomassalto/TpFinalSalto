<?php
include_once("Calificacion.php");

class C_Calificacion
{
    // Método para guardar una nueva calificación del 1 al 5
    public function guardarCalificacion($idCompra, $idUsuario, $puntuacion, $comentario)
    {
        // Validar que la puntuación esté en el rango correcto (de 1 a 5)
        if ($puntuacion < 1 || $puntuacion > 5) {
            // Manejar el error, lanzar una excepción, etc.
            return false;
        }

        // Crear una instancia de la clase Calificacion
        $calificacion = new Calificacion($idCompra, $idUsuario, $puntuacion, $comentario);

        // Guardar la calificación en la base de datos
        return $calificacion->guardarCalificacion();
    }
}
