<?php
include '../../../connections/conection.php'; 
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$rows = array();
$jurado=$_POST["id_jurado"];

$trabajos = mysqli_query($link,"SELECT * FROM `tb_trabajo tb_jurado` 
                                INNER JOIN `tb_trabajo`
                                ON `tb_trabajo`.id_trabajo = `tb_trabajo tb_jurado`.`id_trabajo`
                                WHERE `id_jurado` =  $jurado");

while( $rows[] = $trabajos-> fetch_assoc() );

echo json_encode($rows);

?>