<?php
include '../../../connections/conection.php'; 
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$rows = array();
$idTrabajo =$_POST["id_trabajo"];
$idjurado1 =$_POST["id_jurado1"];
$idjurado2 =$_POST["id_jurado2"];
$newjurado1 =$_POST["id_newjurado1"];
$newjurado2 =$_POST["id_newjurado2"];

$actualizarJurado1 = mysqli_query($link,"UPDATE `tb_trabajo tb_jurado` 
                                SET `id_jurado`= $newjurado1
                                WHERE `id_trabajo` = $idTrabajo AND `id_jurado`=$idjurado1");

$actualizarJurado2 = mysqli_query($link,"UPDATE `tb_trabajo tb_jurado` 
                                SET `id_jurado`= $newjurado2
                                WHERE `id_trabajo` = $idTrabajo AND `id_jurado`=$idjurado2");

echo json_encode('ok'); 

?>