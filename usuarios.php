<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
$op = $_POST['op'];
if (!isset($op)) {
    echo json_encode("No se definió  la variable op");
   
}
include 'vendor/autoload.php';
require 'utils/auth.php';
include 'db/db.php';
$db = new db();
switch ($op) {
    case 'login':
        $usu_correo = $_POST['usuario'];
        $usu_password = $_POST['password'];
        $sql = " SELECT  *   FROM usuario WHERE usu_correo = ? and usu_password=?  ";
        $select = $db->query($sql, $usu_correo, $usu_password)->fetchArray(); 
        echo json_encode($select);
        break;
    case 'lista-usuario':     
            $sql = "SELECT * FROM usuario  "  ;
            $row = $db->query($sql)->fetchAll();
     
            echo json_encode($row);
        break;

        case 'getusuario': 
            $correo = $_POST['usu_correo']; 
            $sql = "SELECT * FROM usuario  where usu_correo= '$correo' "  ;
            $row = $db->query($sql)->fetchArray();
            $result = $db->getResponse($row);         
            echo json_encode($result);
            break;
        
       case 'insert-usuario':
        $usu_correo = $_POST['usu_correo'];
        $usu_nombres = $_POST['usu_nombres'];
        $usu_password = $_POST['usu_password'];
        $rol_codigo = $_POST['rol_codigo'];
 
            $sql = ' INSERT INTO usuario ( usu_correo,usu_nombres,usu_password,rol_codigo  ) VALUES(?,?,?,? );  ';
            $insert = $db->query($sql, $usu_correo, $usu_nombres, $usu_password,  $rol_codigo);
            if ($db->MensajeError) {
                echo json_encode($db->getResponse('ERROR: ' . $db->MensajeError));
                exit;
            }

            $filasafectadas = $insert->affectedRows();
            if ($filasafectadas > 0) {
                $mensaje = "Se ha ingresado correctamente la información ";
            } else {
                $mensaje = "ERROR: No se pudo realizar la acción solicitada ";
            }

            $result = $db->getResponse($mensaje);
            echo json_encode($result);
         

        break;

    case 'delete-usuario':
        $usu_correo = $_POST['usu_correo']; 
            $sql = ' delete from  usuario  where  usu_correo= ?  ';
            $delete = $db->query($sql, $usu_correo);
            if ($db->MensajeError) {
                echo json_encode($db->getResponse('ERROR: ' . $db->MensajeError));
                exit;
            }

            $filasafectadas = $delete->affectedRows();
            if ($filasafectadas > 0) {
                $mensaje = "Se ha borrado correctamente la información ";
            } else {
                $mensaje = "ERROR: No se eliminó la información, revise los criterios de condición   ";
            }

            $result = $db->getResponse($mensaje);
            echo json_encode($result);
       

        break;

    case 'update-usuario':

        $rawdata = file_get_contents("php://input");
        // Let's say we got JSON
        echo $rawdata->usu_correo;


        $usu_correo = $_POST['usu_correo'];
        $usu_nombres = $_POST['usu_nombres'];
        $usu_password = $_POST['usu_password'];
        $rol_codigo = $_POST['rol_codigo'];
     
        $sql = '  update usuario  set  usu_nombres=?,usu_password=?, rol_codigo=?  where usu_correo= ?  ';
        $update = $db->query($sql, $usu_nombres, $usu_password,  $rol_codigo, $usu_correo);
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