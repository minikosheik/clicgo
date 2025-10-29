<?php
require_once("../config/conexion.php");
require_once("../models/Home.php");
$home = new Home();

switch ($_GET["op"]) {

    case "listar_comunicados":
        echo json_encode($home->listar_comunicados());
        break;

    case "listar_aniversarios":
        echo json_encode($home->listar_aniversarios());
        break;

    case "listar_eventos_mes":
        echo json_encode($home->listar_eventos_mes());
        break;


    case "listar_info":
        echo json_encode($home->listarInfoGeneral());
    break;

    case "listar_cumpleanios":
        $datos = $home->listar_cumpleanios();
        echo json_encode($datos);
    break;
}
?>
