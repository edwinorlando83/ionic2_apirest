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
    
    case 'lista-productos':     
            $sql = "SELECT * FROM producto  " ;
            $row = $db->query($sql)->fetchAll();     
            echo json_encode($row);
        break;
    case 'lista-categorias':     
            $sql = "SELECT * FROM categoria  "     ;
            $row = $db->query($sql)->fetchAll();
     
            echo json_encode($row);
        break;
        
    default:
        echo json_encode("Error no existe la opcion " . $op);

}
?>