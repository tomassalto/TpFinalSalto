<?php
include_once("../../../configuracion.php");

$datos = data_submitted();
$objPersona = new C_Usuario();

    if ($objPersona->alta($datos)) {
        echo json_encode(array('success'=>1));
    } else {
        echo json_encode(array('success'=>0));
    }

?>