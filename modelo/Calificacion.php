<?php

class Calificacion
{
    private $idCalificacion;
    private $idCompra;
    private $idProducto;
    private $idUsuario;
    private $puntuacion;
    private $comentario;
    private $fecha;

    // Constructor, getters y setters

    public function __construct()
    {
        $this->idCompra = null;
        $this->idProducto =
            null;
        $this->idUsuario =
            null;
        $this->puntuacion =
            null;
        $this->comentario
            = null;
        $this->fecha = date('Y-m-d H:i:s');
    }

    // Métodos para guardar, obtener, actualizar, eliminar calificaciones
    // Por ejemplo, métodos como guardarCalificacion(), obtenerCalificacionPorId(), actualizarCalificacion(), eliminarCalificacion(), etc.

    /**
     * Get the value of idCalificacion
     */
    public function getIdCalificacion()
    {
        return $this->idCalificacion;
    }

    /**
     * Set the value of idCalificacion
     *
     * @return  self
     */
    public function setIdCalificacion($idCalificacion)
    {
        $this->idCalificacion = $idCalificacion;

        return $this;
    }

    /**
     * Get the value of idCompra
     */
    public function getIdCompra()
    {
        return $this->idCompra;
    }

    /**
     * Set the value of idCompra
     *
     * @return  self
     */
    public function setIdCompra($idCompra)
    {
        $this->idCompra = $idCompra;

        return $this;
    }

    /**
     * Get the value of idUsuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    /**
     * Set the value of idUsuario
     *
     * @return  self
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get the value of puntuacion
     */
    public function getPuntuacion()
    {
        return $this->puntuacion;
    }

    /**
     * Set the value of puntuacion
     *
     * @return  self
     */
    public function setPuntuacion($puntuacion)
    {
        $this->puntuacion = $puntuacion;

        return $this;
    }

    /**
     * Get the value of comentario
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set the value of comentario
     *
     * @return  self
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function setear($idCompra, $idProducto, $idUsuario, $puntuacion, $comentario)
    {
        $this->setIdCompra($idCompra);
        $this->setIdProducto($idProducto);
        $this->setIdUsuario($idUsuario);
        $this->setPuntuacion($puntuacion);
        $this->setComentario($comentario);
    }

    /**
     * Get the value of idProducto
     */
    public function getIdProducto()
    {
        return $this->idProducto;
    }

    /**
     * Set the value of idProducto
     *
     * @return  self
     */
    public function setIdProducto($idProducto)
    {
        $this->idProducto = $idProducto;

        return $this;
    }
}
