<?php
include '../../../connections/conection.php'; 
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$rows = array();
$modalidad=$_POST["id_modalidad"];

$trabajos = mysqli_query($link,"SELECT * FROM pegasoun_proyecto.tb_trabajo WHERE id_modalidad  = $modalidad");

while( $rows[] = $trabajos-> fetch_assoc() );

echo json_encode($rows); 

?>