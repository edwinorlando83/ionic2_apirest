<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
//header('Content-Type: multipart/form-data');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
$obj = json_decode(file_get_contents('php://input'));
include 'db/db.php';
$db = new db(); 
if( !isset($obj))
{
    echo "No se han enviado valores";    
}
else{
$correo = $obj->correo;
$data = $obj->file;
define('UPLOAD_DIR', 'imagenes/');
$img = $data;
$img = str_replace('data:image/jpeg;base64,', '', $img);
 
$data = base64_decode($img);
$nombre = UPLOAD_DIR . uniqid() . '.jpg';
$success = file_put_contents($nombre, $data);
 
$sql = " UPDATE  usuario SET usu_foto=?  WHERE usu_correo=? ";
//$ruta = 'http://apirest.ingenio-ti.net/imagenes/' . $nombre;
$ruta = 'http://192.168.100.9/ionic/' . $nombre;

$insert = $db->query($sql, $ruta, $correo);
if ($db->MensajeError) {
    echo json_encode($db->MensajeError);
} else {
    echo json_encode($insert->affectedRows());
}

}
?>