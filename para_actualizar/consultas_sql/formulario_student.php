<?php

function enviar_proyecto_cordi($uploaddir, $id_trabajo, $archivo, $modalidad, $link){
		$uploadfile = $uploaddir . basename($id_trabajo.'.pdf');
		if (move_uploaded_file($archivo, $uploadfile)) {
						if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`".$modalidad."` SET  `anteproyecto` =  '".$uploadfile."' WHERE  `".$modalidad."`.`id_trabajo` ='".$id_trabajo."'")){
							
									if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor` ='4', `recetor` =  '3', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'")){
										
										return true;	
										}
									
									else{return "Error al modificar el estado de proceso ".mysql_error();}
									
									}
									
								else{return "Error al guardar la ruta en la base de datos ".mysql_error();}							
								}
	}
	

function enviar_proyecto($uploaddir, $id_trabajo, $archivo, $emisor, $tabla, $link){
	
									$uploadfile = $uploaddir . basename($id_trabajo.'.pdf');
									if (copy($archivo, $uploadfile)) {
										
										if($emisor==3){$recetor='3';}
										else{$recetor='2';}
										
											if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`".$tabla."` SET  `anteproyecto` =  '".$uploadfile."' WHERE  `".$tabla."`.`id_trabajo` ='".$id_trabajo."'")){
												mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor` ='4', `recetor` =  '".$recetor."', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
												
												echo json_encode("El Proyecto se ha cargado con éxito");	
													
												}
												
											else{echo json_encode("Error al Actualizar los Datos");}
										
										}
										
									else{echo json_encode("Error al Cargar el Archivo");}
	
	}
	
	//aaaaaaaaaaa
function enviar_informe($uploaddir, $id_trabajo, $archivo, $modalidad, $link){
								$codi_traba=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo
										  FROM pegasoun_proyecto.tb_trabajo tb_trabajo
										 WHERE tb_trabajo.id_trabajo = '".$id_trabajo."'"));
	
								$uploadfile = $uploaddir. basename($codi_traba['codigo_trabajo'].'.doc');
								if (copy($archivo, $uploadfile)) {
									
										if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`".$modalidad."` SET  `informe_final` =  '".$uploadfile."' WHERE  `".$modalidad."`.`id_trabajo` ='".$id_trabajo."'")){
											mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='4', `recetor` =  '3', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
											
											echo json_encode("El informe se ha cargado con éxito");	
												
											}
											
										else{echo json_encode("Error al Actualizar los Datos");}
									
									}
									
								else{echo json_encode("Error al Cargar el Archivo");}
							
	}
	
	
function insert_integrantes($codigo, $nombre, $apellido, $telefono, $correo, $programa, $id_trabajo, $link){
	
						if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_usuario` (`id_usuario`, `nombre`, `apellido`, `telefono`, `correo`, `id_perfil`) VALUES ('".$codigo."', '".$nombre."', '".$apellido."', '".$telefono."', '".$correo."', '2')")){
							
							if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_estudiante` (`id_usuario`, `estado`, `id_programa`) VALUES ('".$codigo."', '1', '".$programa."');")){
								
								mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_trabajo tb_estudiante` (`estado`,`id_trabajo`, `id_usuario`) VALUES ('1', '".$id_trabajo."', '".$codigo."')");
									
								}
							}
											
						
											
						
	
	
	}
	
	
function subir_informe_avance_practi($codigo_trabajo, $id_trabajo, $archivo, $link){
	
	
	$fecha=date("Y-m-d");
	$uploaddir ="../documentos/practica_profesional/informe_avance/";
	$uploadfile = $uploaddir . basename($codigo_trabajo.'_'.$fecha.'.doc');
	
	$avances=mysqli_fetch_assoc(mysqli_query($link,"SELECT COUNT(tb_avances.informe_avance)AS cont
											FROM pegasoun_proyecto.tb_avances tb_avances
											WHERE tb_avances.id_trabajo = '".$id_trabajo."' "));

		if($avances['cont']<3){
								
				if (move_uploaded_file($archivo, $uploadfile)) {
										
										
						if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_avances` (`id_avance`, `informe_avance`, `fecha`, `id_trabajo`, `estado`) VALUES (NULL, '".$uploadfile."', '".$fecha."', '".$_POST['id_trabajo']."', '1')")){
											
								if(!mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_pofesional` SET  `informe_final` =  '".$uploadfile."' WHERE  `tb_trabajo tb_pofesional`.`id_trabajo`= '".$id_trabajo."'")){
												echo json_encode("Error ".mysql_error());
												}
												
								mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='4', `recetor` =  '3', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
											
											echo json_encode("El informe se Ha subido con éxito ");
											}
										else{
												echo json_encode("El informe se Ha subido con éxito ".mysql_error());
											}
										
										}
										
									else{echo json_encode("Error al Cargar el Archivo");}
								}
								
								else{echo json_encode("Ya has subidos los 3 Informes requeridos en Esta modalidad");}

	
	}
	
function subir_informe_avance_des($codigo_trabajo, $id_trabajo, $archivo, $link){
	$fecha=date("Y-m-d");
	$uploaddir ="../documentos/desarrollo_investigacion/informe_avance/";
	$uploadfile = $uploaddir . basename($codigo_trabajo.'_'.$fecha.'.doc');
	
	$avances=mysqli_fetch_assoc(mysqli_query($link,"SELECT COUNT(tb_avance.informe_avance)AS cont
													  FROM pegasoun_proyecto.tb_avance tb_avance
													 WHERE tb_avance.id_trabajo = '".$id_trabajo."' "));
													 
													 
	if($avances['cont']<3){
								
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
										
										
					if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_avance` (`id_avance`, `informe_avance`, `fecha`, `id_trabajo`, `estado`) VALUES (NULL, '".$uploadfile."', '".$fecha."', '".$_POST['id_trabajo']."', '1')")){
											
							if(!mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_desarrollo_investigcion` SET  `informe_final` =  '".$uploadfile."' WHERE  `tb_trabajo tb_desarrollo_investigcion`.`id_trabajo`= '".$_POST['id_trabajo']."'")){
												echo json_encode("Error ".mysql_error());
												}
												
							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='4', `recetor` =  '3', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");
											
						 echo json_encode("El informe se Ha subido con éxito ");
							}
							else{
								 echo json_encode("El informe se Ha subido con éxito ".mysql_error());
								}
										
						}
										
			else{echo json_encode("Error al Cargar el Archivo");}
								}
								
	else{echo json_encode("Ya has subidos los 3 Informes requeridos en Esta modalidad");}
	}

?>