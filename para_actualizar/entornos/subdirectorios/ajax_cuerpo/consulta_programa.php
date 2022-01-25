<?php
include '../../../connections/conection.php'; 
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$rows = array();
$programa=$_POST["id_programa"];

$trabajos = mysqli_query($link,"SELECT * FROM pegasoun_proyecto.tb_trabajo WHERE id_programa = $programa");

/*$trabajos = mysqli_query($link,"SELECT * 
                                FROM pegasoun_proyecto.tb_trabajo 
                                INNER JOIN tb_usuario
                                ON tb_usuario.id_usuario = tb_trabajo.usuario
                                WHERE id_programa = $programa");*/

while( $rows[] = $trabajos-> fetch_assoc() );

echo json_encode($rows); 

?>