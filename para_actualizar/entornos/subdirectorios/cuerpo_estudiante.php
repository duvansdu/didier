<?php
if(isset($_POST['user'])){
    include '../../connections/conection.php'; $id_documento=$_POST['user'];}
else{include '../connections/conection.php'; $id_documento=$_SESSION['user'];}
 
$estado_habilitado=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.id_programa, tb_trabajo.id_trabajo, tb_trabajo.titulo
  FROM pegasoun_proyecto.tb_trabajo tb_trabajo
 WHERE tb_trabajo.id_trabajo = '".$id_documento."'"));
 
 
$permisos=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_programa_permiso.habilitar, tb_comunicacion.habilita_plataforma
  FROM pegasoun_proyecto.tb_comunicacion tb_comunicacion
       CROSS JOIN pegasoun_proyecto.tb_programa_permiso tb_programa_permiso
       JOIN pegasoun_proyecto.tb_permiso_subir_archivo tb_permiso_subir_archivo
          ON (tb_programa_permiso.id_permiso =
                 tb_permiso_subir_archivo.id_permiso)
 WHERE     tb_permiso_subir_archivo.estado = '1'
       AND tb_comunicacion.habilita_plataforma = '1'
       AND tb_programa_permiso.id_programa = '".$estado_habilitado['id_programa']."' AND id_trabajo='".$id_documento."'"));

$anuncios= mysqli_query($link,"SELECT tb_anuncio.asunto, tb_anuncio.descripcion, fecha_publicacion
  FROM    pegasoun_proyecto.tb_anuncio_programa tb_anuncio_tb_programa
       JOIN
          pegasoun_proyecto.tb_anuncio tb_anuncio
       ON (tb_anuncio_tb_programa.id_anuncio = tb_anuncio.id_anuncio)
 WHERE tb_anuncio_tb_programa.id_programa = '".$estado_habilitado['id_programa']."' AND tb_anuncio_tb_programa.estado = 1 ORDER BY  `tb_anuncio`.`id_anuncio` DESC LIMIT 0 , 10");



 if($permisos['habilita_plataforma']==1 && $permisos['habilitar']==1){//para dar el permiso de subir archivos		
 				include "anuncios/subir_documento.php";
 		}
 
 else{
	 	if(mysqli_num_rows($anuncios)>0){//si el administrador ha subido un anuncio se mostraran los anuncios
			include "anuncios/anuncio1.php";
			}
			
		else{// si el administrador no ha realizado algun anuncio se mostrara uno por defecto
			include "anuncios/anuncio2.php";
				
			}
	 }
 
?>

