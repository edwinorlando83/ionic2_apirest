<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
$obj = json_decode(file_get_contents('php://input'));
$op = $obj->op;
if (!isset($op)) {
    echo json_encode("No se definió  la variable op");
   
}
include 'vendor/autoload.php';
require 'utils/auth.php';
include 'db/db.php';
$db = new db();
switch ($op) { 
    case 'update-usuario': 
        $sql = '  update usuario  set  usu_nombres=?,usu_password=?, rol_codigo=?  where usu_correo= ?  ';
        $update = $db->query($sql, $obj->usu_nombres, $obj->usu_password,  $obj->rol_codigo, $obj->usu_correo);
            if ($db->MensajeError) {
                echo json_encode($db->getResponse('ERROR: ' . $db->MensajeError));
                exit;
            }

            $filasafectadas = $update->affectedRows();
            if ($filasafectadas > 0) {
                $mensaje = "Se ha actulizado correctamente la información ";
            } else {
                $mensaje = "ERROR: No se actualizó la información, revise los criterios de condición   ";
            }

            $result = $db->getResponse($mensaje);
            echo json_encode($result);
         

        break;

        case 'lista-rol':     
            $sql = "SELECT * FROM rol  "     ;
            $row = $db->query($sql)->fetchAll();
     
            echo json_encode($row);
        break;

    default:
        echo json_encode("Error no existe la opcion " . $op);

}
?>