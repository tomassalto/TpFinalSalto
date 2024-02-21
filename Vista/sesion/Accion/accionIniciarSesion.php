<?php
include_once("../../../configuracion.php");
$datos = data_submitted();
$objSesion = new C_Session();

    if ($objSesion->valida($datos)) {
        echo json_encode(array('success'=>1));
    } else {
        echo json_encode(array('success'=>0));
    }

?>