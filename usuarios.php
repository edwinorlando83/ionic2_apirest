<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
$op = $_POST['op'];
if (!isset($op)) {
    echo json_encode("No se definió  la variable op");
    exit;
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
            $texto = $_POST['texto'];
            $limite = $_POST['limite'];
               $rol = $_POST['rol'];
            
            $slimite=" limit 20 ";
            if( isset( $limite))
                $slimite=" limit 20 ";
            
            $where=" ";
            if( isset( $texto)){ 
                $texto  =  strtoupper( $texto );
                $where="  and  upper( CONCAT( correo , nombre )) like '%$texto%' ";
            }            

            $sql = "SELECT * FROM usuario  where rol= '$rol' " .$where . $slimite   ;
            $row = $db->query($sql)->fetchAll();
            $result = $db->getResponse($row);
       
        break;

        case 'getusuario':
            $result = $db->getResponseAuth();
            $correo = $_POST['correo']; 
            $sql = "SELECT * FROM usuario  where correo= '$correo' "  ;
            $row = $db->query($sql)->fetchArray();
            $result = $db->getResponse($row);         
            echo json_encode($result);
            break;

       case 'insert-usuario':
        $correo = $_POST['correo'];
        $nombre = $_POST['nombre'];
        $password = $_POST['password'];
       
        $rol = '1';
        $result = $db->getResponseAuth();
        if ($result['estado'] == 'VALIDO') {
            $sql = ' INSERT INTO usuario ( correo,nombre,password,rol  ) VALUES(?,?,?,? );  ';
            $insert = $db->query($sql, $correo, $nombre, $password,  $rol);
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
        } else {
            echo json_encode($result);
        }

        break;

    case 'delete-usuario':
        $correo = $_POST['correo'];
        $result = $db->getResponseAuth();
        if ($result['estado'] == 'VALIDO') {
            $sql = ' delete from  usuario  where  correo= ?  ';
            $delete = $db->query($sql, $correo);
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
        } else {
            echo json_encode($result);
        }

        break;

    case 'update-usuario':
        $correo = $_POST['correo'];
        $nombre = $_POST['nombre'];
        $password = $_POST['password'];
        
        $result = $db->getResponseAuth();
        if ($result['estado'] == 'VALIDO') {
            $sql = '  update usuario  set  nombre=?,password=?, updated=current_timestamp  where correo= ?  ';
            $update = $db->query($sql, $nombre, $password,  $correo);
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
        } else {
            echo json_encode($result);
        }

        break;
    default:
        echo json_encode("Error no existe la opcion " . $op);

}
?>