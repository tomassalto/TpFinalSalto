<?php
class C_Compra
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param)
    {
        $objCompra = null;

        if (array_key_exists('idCompra', $param) and array_key_exists('coFecha', $param) and array_key_exists('idUsuario', $param)) {
            $objCompra = new Compra();
            if (!$objCompra->setear($param['idCompra'], $param['coFecha'], $param['idUsuario'])) {
                $objCompra = null;
            }
        }
        return $objCompra;
    }


    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idCompra'])) {
            $obj = new Compra();
            $obj->setear($param['idCompra'], null, null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idCompra'])) {
            $resp = true;
        }
        return $resp;
    }

    /**
     *
     * @param array $param
     * @return boolean
     */
    public function alta($param)
    {
        $resp = false;
        $param['idCompra'] = null;
        $fecha = new DateTime();
        $fechaStamp = $fecha->format('Y-m-d H:i:s');
        $param['coFecha'] = $fechaStamp;
        $objCompra = $this->cargarObjeto($param);
        if ($objCompra != null) {
            if ($objCompra->insertar()) {
                $resp = true;
            }
        }
        return $resp;
    }
    /**
     * permite eliminar un objeto
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompra = $this->cargarObjetoConClave($param);
            if ($objCompra != null and $objCompra->eliminar()) {
                $resp = true;
            }
        }

        return $resp;
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objCompra = $this->cargarObjeto($param);
            if ($objCompra != null and $objCompra->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param = "")
    {
        $where = " true ";
        if ($param <> null) {
            if (isset($param["idCompra"])) {
                $where .= " and idCompra =" . $param["idCompra"];
            }
            if (isset($param["idUsuario"])) {
                $where .= " and idUsuario =" . $param["idUsuario"];
            }
        }
        $objCompra = new Compra();
        $arregloCompras = $objCompra->listar($where);
        return $arregloCompras;
    }

    public function obtenerIdUsuarioPorCompra($idCompra)
    {
        $objCompra = new Compra();
        $compra = $objCompra->buscarPorId($idCompra);
        if ($compra) {
            // Asumiendo que el ID del usuario está almacenado en la propiedad "idUsuario" de la compra
            return $compra->getIdUsuario();
        }
        return null; // Maneja el caso donde no se encontró la compra
    }

    /* Busca con el id usuario todos las compras que realizo */
    public static function buscarComprasUsuario($idUsuario)
    {
        $objCompra = new C_Compra();
        $arrayCompra = $objCompra->buscar($idUsuario);
        return $arrayCompra;
    }

    /* Crea una compra y compraEstado con el idusuario */
    public static function crearCompra($idUsuario)
    {
        $objCompra = new C_Compra();
        $objCompraEstado = new C_CompraEstado();
        $arrayObjCompraEstado = null;
        if ($objCompra->alta($idUsuario)) {
            $arrayCompra = $objCompra->buscar($idUsuario);
            $fecha = new DateTime();
            $fechaStamp = $fecha->format('Y-m-d H:i:s');
            $paramCompraEstado = [
                "idCompra" => end($arrayCompra)->getIdCompra(),
                "idCompraEstadoTipo" => 1,
                "ceFechaIni" => $fechaStamp,
                "ceFechaFin" => null
            ];
            if ($objCompraEstado->alta($paramCompraEstado)) {
                $idCompra["idCompra"] = end($arrayCompra)->getIdCompra();
                $arrayObjCompraEstado = $objCompraEstado->buscar($idCompra);
            }
        }
        return $arrayObjCompraEstado[0];
    }

}
