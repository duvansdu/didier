<?php
include '../connections/conection.php';
include 'formularios.php';
$opcion=$_POST["opcion"];

switch($opcion){
	
	case 1:{	//El Administrador habilita plataforma para que los estudiantes suban sus documentos
				$fecha_inicio=$_POST['fecha_inicio'];
				$fecha_limite=$_POST['fecha_limite'];
				$programa=$_POST['programa'];
				
				if(mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_permiso_subir_archivo` (`id_permiso` ,`fecha_inicio` ,`fecha_final` ,`estado`) VALUES (NULL ,  '".$fecha_inicio."',  '".$fecha_limite."',  '1')")){
					
					
						$id_permiso=mysqli_insert_id($link);
						
						if($_POST['programa']==0){
							$programas=mysqli_query($link,"SELECT * FROM tb_programa");
					
							while($g=mysqli_fetch_array($programas)){
								mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_programa_permiso` (`id_programa_permiso`,`habilitar`, `id_programa`,`id_permiso`) VALUES (NULL ,  '1',  '".$g['id_programa']."',  '".$id_permiso."')");
								}
					
							}
							
						else{
								mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_programa_permiso` (`id_programa_permiso`,`habilitar`, `id_programa`,`id_permiso`) VALUES (NULL ,  '1',  '".$_POST['programa']."',  '".$id_permiso."')");
							}
							
							sleep(1);
							
						
						echo permisos_subirarchivos($link);

						
					    }
						
					else{
							echo json_encode('error '.mysql_error());
						
						}
			
		
		}break;
		
	case 2:{//El administrador registra los anuncios para los estudiantes
			$ausnto=$_POST['asunto'];
			$descrip=$_POST['descrip'];
			$programa=$_POST['programa'];
			$fecha_public=$_POST['fecha_public'];
			
		
			if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_anuncio` (`id_anuncio`, `asunto`, `descripcion`, `fecha_publicacion`) VALUES (NULL, '".$ausnto."', '".$descrip."', '".$fecha_public."')")){
				
				$id_anuncio=mysqli_insert_id($link);
				
					if($_POST['programa']==0){
						$programas=mysqli_query($link,"SELECT * FROM tb_programa");
						
						while($g=mysqli_fetch_array($programas)){
							mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_anuncio_programa` (`id_anuncio`, `id_programa`, `estado`) VALUES ('".$id_anuncio."', '".$g['id_programa']."', '1')");
							}
						
						}
						
					else{
							mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_anuncio_programa` (`id_anuncio`, `id_programa`, `estado`) VALUES ('".$id_anuncio."', '".$programa."', '1')");
						}
					
					echo json_encode("El Anuncio Se ha publicado");
					
				}
	
			else{echo json_encode("Error de Publicacion, Verifique todos los campos ".mysql_error());}
		
		}break;
		
	case 3:{ //El administrador registra los docentes
	
			if(mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_usuario` (`id_usuario` ,`nombre` ,`apellido` ,`telefono` ,`correo`,`id_perfil`) VALUES ('".$_POST['id_usuario']."',  '".$_POST['nombre']."',  '".$_POST['apellido']."',  '".$_POST['telefono']."',  ' ".$_POST['email']."',  '1')")){
					mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_especialidad` (`id_usuario`, `especialidad`) VALUES ('".$_POST['id_usuario']."', '".$_POST['especialidad']."')");
					echo json_encode("Los datos se han guardado con éxito");
				}
				
			else{
					echo json_encode("Error al guardar los datos ".mysqli_error($link));
				}
		
		}break;
		
	case 4:{//Insertamos un nuevo programa
			
			$programa=$_POST["programa"];
			
			
			if($codigo!="" && $programa!=""){
					
					
						
							if(mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_programa` (`id_programa` ,`nombre`) VALUES (NULL ,  '$programa')")){
							echo json_encode("Los Datos Se han guardado con éxito");
								}
							else{echo json_encode("Error al Guardar los Datos");}
						
			
			 }
			 
			 else{echo json_encode("Faltan datos, verifique que la informacion este completa");}
		
		
		}break;
		
	case 5:{//Se envian las cartas cuando el jurado aprueba el proyecto para informe
			if(isset($_FILES['archivo'])){
							$archivo=$_FILES['archivo']['name'];
							$id_trabajo=$_POST['id_trabajo'];
							$fecha=date("Y-m-d");
							$uploaddir="../documentos/cartas/";
							$uploadfile = $uploaddir . basename($id_trabajo.'_'.$fecha.'.pdf');
							if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
				
									if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_carta` (`id_carta`, `ruta`, `fecha_subida`, `id_trabajo`, `revisado`) VALUES (NULL, '".$uploadfile."', '".$fecha."', '".$id_trabajo."', 1)")){
										
										mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");
										
												echo json_encode("La Carta se Ha enviado con éxito");
											}
					
									 else{echo json_encode("Error al Cargar el Documento ".mysql_error());}
				
				}
				
			else{echo json_encode("Sobrecarga en el documento intente subilo de nuevo");}
					
					}
				else{
						echo json_encode("Debe cargar un achivo PDF");
					}
		
		}break;
		
	case 6:{//envia carta cuando el jurado aprueba el informe final y se da terminacion al rpoyecto
		
			if(isset($_FILES['archivo'])){
							$archivo=$_FILES['archivo']['name'];
							$id_trabajo=$_POST['id_trabajo'];
							$fecha=date("Y-m-d");
							$uploaddir="../documentos/cartas/";
							$uploadfile = $uploaddir . basename($id_trabajo.'_'.$fecha.'.pdf');
							if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
				
									if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_carta` (`id_carta`, `ruta`, `fecha_subida`, `id_trabajo`, `revisado`) VALUES (NULL, '".$uploadfile."', '".$fecha."', '".$id_trabajo."', '1')")){
										
										
										mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '0', `estado_proyecto` =  '2' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'"); 
										
												echo json_encode("La Carta se Ha enviado con éxito");
											}
					
									 else{echo json_encode("Error al Cargar el Documento ".mysql_error());}
						
								}
				
							else{echo json_encode("Sobrecarga en el documento intente subirlo de nuevo");}
					
					}
						
				else{
						echo json_encode("Debe cargar un achivo PDF");
					
					}

		}break;
		
	case 7:{//enviamos cartas de los proyectos
		
			if(isset($_FILES['archivo'])){
							$archivo=$_FILES['archivo']['name'];
							$id_trabajo=$_POST['id_trabajo'];
							$fecha=date("Y-m-d");
							$uploaddir="../documentos/cartas/";
							$uploadfile = $uploaddir . basename($id_trabajo.'_'.$fecha.'.pdf');
							if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
				
									if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_carta` (`id_carta`, `ruta`, `fecha_subida`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha."', '".$id_trabajo."');")){
										
										mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor` ='2', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
										
												echo json_encode("La Carta se Ha enviado con éxito");
											}
					
									 else{echo json_encode("Error al Cargar el Documento ".mysql_error());}
				
								}
				
							else{echo json_encode("Sobrecarga en el documento intente subirlo de nuevo");}
					
						}
			else{
						echo json_encode("Debe cargar un archivo PDF");
					
				}
		}break;
		
	case 8:{//enviamos cartas de los informes cuando se deben corregir o estan listos para entrega final por parte jura
		
				if(isset($_FILES['archivo'])){
							$archivo=$_FILES['archivo']['name'];
							$id_trabajo=$_POST['id_trabajo'];
							$fecha=date("Y-m-d");
							$uploaddir="../documentos/cartas/";
							$uploadfile = $uploaddir . basename($id_trabajo.'_'.$fecha.'.pdf');
							if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
				
									if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_carta` (`id_carta`, `ruta`, `fecha_subida`, `id_trabajo`, `revisado`) VALUES (NULL, '".$uploadfile."', '".$fecha."', '".$id_trabajo."', 1)")){
										
										mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='2', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
												echo json_encode("La Carta se Ha enviado con éxito");
											}
					
									 else{echo json_encode("Error al Cargar el Documento ".mysql_error());}
				
				}
				
			else{echo json_encode("Sobrecarga en el documento intente subilo de nuevo");}
					
					}
				else{
						echo json_encode("Debe cargar un achivo PDF");
					
					}
		}break;
		
	case 9:{//informes de avance practica profesional
			if(isset($_FILES['archivo'])){
							$id_trabajo=$_POST['id_trabajo'];
							$fecha=date("Y-m-d");
							$uploaddir="../documentos/actas_individuales/";
							
							$codigo_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo  FROM pegasoun_proyecto.tb_trabajo tb_trabajo WHERE tb_trabajo.id_trabajo = '".$id_trabajo."'"));
							
							$uploadfile = $uploaddir . basename($codigo_trabajo['codigo_trabajo'].'_'.$fecha.'.pdf');
							
							if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
				
									if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_concepto` (`id_concepto`, `ruta`, `fecha_subida`, `revisado`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha."', '1', '".$id_trabajo."')")){
										
										$avances=mysqli_query($link,"SELECT tb_avances.informe_avance
													  FROM pegasoun_proyecto.tb_avances tb_avances
													 WHERE tb_avances.id_trabajo = '".$id_trabajo."' ");
													 
										
										if(mysqli_num_rows($avances)==3){
											mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '0', `estado_proyecto` =  '2' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'"); 
											
											}
										else{
											mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'"); 
											
											}
												echo json_encode("La Carta se Ha enviado con éxito");
											}
					
									 else{echo json_encode("Error al Cargar el Documento ".mysql_error());}
						
								}
				
							else{echo json_encode("Sobrecarga en el documento intente subirlo de nuevo");}
					
					}
						
				else{
						echo json_encode("Debe cargar un achivo PDF");
					
					}
		}break;
		
	case 10:{
				$avances=mysqli_query($link,"SELECT MAX(tb_avances.id_avance) AS id_avance, tb_avances.informe_avance
									  FROM pegasoun_proyecto.tb_avances tb_avances
									 WHERE tb_avances.id_trabajo = '".$_POST['id_trabajo']."'");
									 
				if(isset($_FILES['archivo'])){
							$archivo=$_FILES['archivo']['name'];
							$id_trabajo=$_POST['id_trabajo'];
							$fecha=date("Y-m-d");
							$uploaddir="../documentos/cartas/";
							
							$codi_traba=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo
										  FROM pegasoun_proyecto.tb_trabajo tb_trabajo
										 WHERE tb_trabajo.id_trabajo = '".$id_trabajo."'"));
										 
							$uploadfile = $uploaddir . basename($codi_traba['codigo_trabajo'].'_'.$fecha.'.pdf');
							if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
				
									if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_concepto` (`id_concepto`, `ruta`, `fecha_subida`, `revisado`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha."', '1', '".$id_trabajo."')")){
										
										mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");

										$id_avance=mysqli_fetch_assoc($avances);
				 
				 						mysqli_query($link,"DELETE FROM `pegasoun_proyecto`.`tb_avances` WHERE `tb_avances`.`id_avance` = '".$id_avance['id_avance']."'");
				  						unlink($id_avance['informe_avance']);
				
				
										echo json_encode("El infome fue Devuelto");
											}
					
									 else{echo json_encode("Error al Cargar el Documento ".mysql_error());}
				
				}
				
			else{echo json_encode("Sobrecarga en el documento intente subirlo de nuevo");}
					
					}
				else{
						echo json_encode("Debe cargar un achivo PDF");
					
					}
		}break;
		
	case 11:{//informes de avance practica profesional
			if(isset($_FILES['archivo'])){
							$id_trabajo=$_POST['id_trabajo'];
							$fecha=date("Y-m-d");
							
							$id_modalidad=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.id_modalidad
  FROM pegasoun_proyecto.tb_trabajo tb_trabajo WHERE tb_trabajo.id_trabajo = '12'"));
  
									$uploaddir="../documentos/actas_individuales/";
								
						
							
							$codigo_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo  FROM pegasoun_proyecto.tb_trabajo tb_trabajo WHERE tb_trabajo.id_trabajo = '".$id_trabajo."'"));
							
							$uploadfile = $uploaddir . basename($codigo_trabajo['codigo_trabajo'].'_'.$fecha.'.pdf');
							
							if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
				
									if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_concepto` (`id_concepto`, `ruta`, `fecha_subida`, `revisado`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha."', '1', '".$id_trabajo."')")){
										mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_observaciones` SET  `estado` =  '0' WHERE  `tb_observaciones`.`id_trabajo` ='".$id_trabajo."'");
										$avances=mysqli_query($link,"SELECT tb_avance.informe_avance
															  FROM pegasoun_proyecto.tb_avance tb_avance
													WHERE tb_avance.id_trabajo = '".$id_trabajo."' ");
													 
										
										if(mysqli_num_rows($avances)==3){
											mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '0', `estado_proyecto` =  '2' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'"); 
											
											}
										else{
											mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'"); 
											
											}
												echo json_encode("La Carta se Ha enviado con éxito");
											}
					
									 else{echo json_encode("Error al Cargar el Documento ".mysql_error());}
						
								}
				
							else{echo json_encode("Sobrecarga en el documento intente subirlo de nuevo");}
					
					}
						
				else{
						echo json_encode("Debe cargar un achivo PDF");
					
					}
		}break;
	case 12:{
		
		$id_trabajo=$_POST['id_trabajo'];
		$fecha=date("Y-m-d");
		
		if(isset($_FILES['archivo'])){
			
			$archivo=$_FILES['archivo']['name'];
			$id_trabajo=$_POST['id_trabajo'];
			$fecha=date("Y-m-d");
			$uploaddir="../documentos/cartas/";
			$uploadfile = $uploaddir . basename($id_trabajo.'_'.$fecha.'.pdf');
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {

				mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_concepto` (`id_concepto`, `ruta`, `fecha_subida`, `revisado`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha."', 1, '".$id_trabajo."')");
			
				$avances=mysqli_query($link,"SELECT MAX(tb_avance.id_avance) AS id_avance, tb_avance.informe_avance FROM pegasoun_proyecto.tb_avance tb_avance WHERE tb_avance.id_trabajo = '".$id_trabajo."'");
				
				mysqli_query($link,"DELETE FROM `pegasoun_proyecto`.`tb_observacion` WHERE `tb_observacion`.`id_trabajo` = '".$id_trabajo."'");
				
				mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");
				
				$id_avance=mysqli_fetch_assoc($avances);
				
				mysqli_query($link,"DELETE FROM `pegasoun_proyecto`.`tb_avance` WHERE `tb_avance`.`id_avance` = '".$id_avance['id_avance']."'");
				
				unlink($id_avance['informe_avance']);
				
				echo json_encode("Se ha enviado a Correción");
			}
		}
		
		else{echo json_encode("Sobrecarga de Archivo");}
		
		}break;
	
	}
?>
