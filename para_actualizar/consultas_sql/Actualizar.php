<?php
include "../connections/conection.php";
include 'formularios.php';
$opcion=$_POST['opcion'];

switch($opcion){
	
		case 1:{ //Deshabilita los permisos por parte del administrador para no subir mas documentos
			mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_permiso_subir_archivo` SET  `estado` =  '0' WHERE  `tb_permiso_subir_archivo`.`id_permiso` ='".$_POST['id_permiso']."'");
				
				mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_programa_permiso` SET  `habilitar` =  '0' WHERE  `tb_programa_permiso`.`id_permiso` ='".$_POST['id_permiso']."'");
				
			echo permisos_subirarchivos($link);
			
			}break;
			
		case 2:{	//elimina todos los anunios por parte del administrador
					mysqli_query($link,"DELETE FROM `pegasoun_proyecto`.`tb_anuncio_programa`");
					mysqli_query($link,"DELETE FROM `pegasoun_proyecto`.`tb_anuncio`");
					echo json_encode('Se han eliminado todos los Anuncios Hasta la fecha');
			}break;
			
		case 3:{	//Asigno rol de Director a los docentes
		
				$selec_dir=$_POST['selec_dir'];
				$estado_dir=$_POST['estado_dir'];
				$codigo=$_POST['codigo'];
				
				
				
				if($selec_dir==1){//director  
					$exis_Dire=mysqli_num_rows(mysqli_query($link,"SELECT tb_director.id_director
  FROM pegasoun_proyecto.tb_director tb_director
 WHERE tb_director.id_usuario = '".$codigo."'"));
					if($exis_Dire>0){
							mysqli_query($link,"UPDATE tb_director SET estado='".$estado_dir."' WHERE id_usuario='".$codigo."'");
						
						}
					else{
							mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_director` (`id_director`, `estado`, `id_usuario`) VALUES (NULL, '".$estado_dir."', '".$codigo."')");						
						}				
				}		
				
				if($selec_dir==2){//director investi 
				
						$exis_Dire=mysqli_num_rows(mysqli_query($link,"SELECT tb_director_investi.id_director_inves
  FROM pegasoun_proyecto.tb_director_investi tb_director_investi
 WHERE tb_director_investi.id_usuario ='".$codigo."'")); 
 
 						if($exis_Dire>0){
								mysqli_query($link,"UPDATE tb_director_investi SET estado='".$estado_dir."' WHERE id_usuario='".$codigo."'");
							}
						else{
								mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_director_investi` (`id_director_inves`, `estado`, `id_usuario`) VALUES (NULL, '".$estado_dir."', '".$codigo."');");					
							}
				}
				
				if($selec_dir==3){//tutor
				
							$exis_Dire=mysqli_num_rows(mysqli_query($link,"SELECT tb_tutor_externo.id_tutor_externo
  FROM pegasoun_proyecto.tb_tutor_externo tb_tutor_externo
 WHERE tb_tutor_externo.id_usuario = '".$codigo."'"));
 
 							if($exis_Dire>0){
								mysqli_query($link,"UPDATE tb_tutor_externo SET estado='".$estado_dir."' WHERE id_usuario='".$codigo."'");
							}
							
							else{
									mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_tutor_externo` (`id_tutor_externo`, `estado`, `id_usuario`) VALUES (NULL, '".$estado_dir."', '".$codigo."');");				
								}
 				
				}
				
				echo json_encode("Los datos se han Actualizado.");
			}break;
			
		case 4:{//Asigno rol Jurado a los docentes
			
				$usuario=$_POST['usuario'];
				$pws=hash('sha256',$_POST['pws']);
				$codigo=$_POST['codigo'];
				$estado=$_POST['estado'];
				
				$existe=mysqli_query($link,"SELECT tb_jurado.id_jurado
							  FROM pegasoun_proyecto.tb_jurado tb_jurado
							 WHERE tb_jurado.id_usuario = '".$codigo."' ");
							 
				if(mysqli_num_rows($existe)){
					
					if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_jurado` SET  `usuario` =  '".$usuario."',
`password` =  '".$pws."', `estado` =  '".$estado."' WHERE  `tb_jurado`.`id_usuario` ='".$codigo."' ")){
					
							echo json_encode("Los Datos se han Modificado");
						}
						
					else{
							echo json_encode("Error ".mysql_error());
						}
					}
					
				else{
				
						if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_jurado` (`id_jurado`, `usuario`, `password`, `estado`, `id_usuario`) VALUES (NULL, '".$usuario."', '".$pws."', '".$estado."', '".$codigo."')")){
					
								echo json_encode("Los Datos se han guardado con éxito");
							}
					
						else{
								echo json_encode("Error Al guardar ".mysql_error());
							}
				}
			}break;
			
		case 5:{//Actualizo la informacion del docente por parte del administrador
				
				$codigo=$_POST['codigo'];
				$nombre=$_POST['nombre'];
				$apellido=$_POST['apellido'];
				$telefono=$_POST['telefono'];
				$correo=$_POST['correo'];
				$especialidad=$_POST['especialidad'];
				
				mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_usuario` SET  `nombre` =  '".$nombre."',`apellido` =  '".$apellido."', `telefono` =  '".$telefono."', `correo` =  '".$correo."' WHERE  `tb_usuario`.`id_usuario` =  '".$codigo."'");
				
				mysqli_query($link,"UPDATE tb_especialidad SET especialidad='".$especialidad."' WHERE `tb_especialidad`.`id_usuario` =  '".$codigo."' ");
				
				echo json_encode("Los Datos del Docente se han Actualizado");
			}break;
			
		case 6:{//asigno el comite a los docentes por su programa
			
			$codigo=$_POST['codigo'];
			$j=$_POST['j'];
			$estado=$_POST['select'];
			$cargo=$_POST['select_cargo'];
			$user=$_POST['user'];
			$psw=hash('sha256',$_POST['psw']);
			
			if($cargo!=0 ||$estado!=0){

			
					if(mysqli_num_rows(mysqli_query($link,"SELECT * FROM  `tb_comite` WHERE  `id_usuario` LIKE  '".$codigo."'"))==1){
						
					if($_POST['psw']!=""){
							$psw=hash('sha256',$_POST['psw']);
							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comite` SET  `usuario` =  '".$user."', `password` =  '".$psw."',`estado` =  '".$estado."' WHERE  `tb_comite`.`id_usuario` ='".$codigo."'");
							}
							
					else{
							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comite` SET  `usuario` =  '".$user."',`estado` =  '".$estado."' WHERE  `tb_comite`.`id_usuario` ='".$codigo."'");
						}
										
					$id_comite=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_comite.id_comite FROM  `tb_comite` WHERE  `id_usuario` LIKE  '".$codigo."'"));
		
						for($i=0; $i<$j; $i++){
							$programa=$_POST['check_'.$i];
							$estado=$_POST['estado_'.$i];
							
							if(mysqli_num_rows(mysqli_query($link,"SELECT tb_comite_programa.* FROM pegasoun_proyecto.tb_comite_programa tb_comite_programa WHERE tb_comite_programa.id_comite = '".$id_comite['id_comite']."' AND tb_comite_programa.id_programa = '".$programa."'"))==1){
							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comite_programa` SET  `estado` ='".$estado."' WHERE  `tb_comite_programa`.`id_comite` ='".$id_comite['id_comite']."' AND `tb_comite_programa`.`id_programa`='".$programa."' ");	
								}
								
						else{
								mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_comite_programa` (`id_comite_programa`, `estado`, `id_comite`, `id_programa`) VALUES (NULL, '".$estado."', '".$id_comite['id_comite']."', '".$programa."')");
								
								mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_usuario_cargo` (`id_usuario_cargo`, `id_cargo`, `id_usuario`) VALUES (NULL, '".$cargo."', '".$codigo."')");
							}
							
							}
							
							if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_usuario_cargo` SET  `id_cargo` =  '".$cargo."' WHERE  `tb_usuario_cargo`.`id_usuario` ='".$codigo."'")){
							
							echo json_encode("Los datos se han actualizado con éxito");}
							
							else{echo json_encode("Error ".mysql_error());}
						
						}
						
					else{
						 mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_comite` (`id_comite`, `usuario`, `password`, `estado`, `id_usuario`) VALUES (NULL, '".$user."', '".$psw."', '".$estado."', '".$codigo."');");
						 $id_comite=mysqli_insert_id($link);
						 for($i=0; $i<$j; $i++){
							$programa=$_POST['check_'.$i];
							$estado=$_POST['estado_'.$i];
							mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_comite_programa` (`id_comite_programa`, `estado`, `id_comite`, `id_programa`) VALUES (NULL, '".$estado."', '".$id_comite."', '".$programa."')");					
							
							}
							mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_usuario_cargo` (`id_usuario_cargo`, `id_cargo`, `id_usuario`) VALUES (NULL, '".$cargo."', '".$codigo."')");
							echo json_encode("Los datos se han guardado con éxito");
						}
				}
			
			}break;
			
		case 7:{//Asignamos las propuestas o Proyectos a sus respectivos miembros del comite Tb_comunicacion
				$comites=mysqli_query($link,"SELECT tb_comite.id_comite
							  FROM    pegasoun_proyecto.tb_comite_programa tb_comite_programa
								   JOIN
									  pegasoun_proyecto.tb_comite tb_comite
								   ON (tb_comite_programa.id_comite = tb_comite.id_comite)
							 WHERE     tb_comite.estado = '1'
								   AND tb_comite_programa.id_programa = '".$_POST['id_programa']."'
								   AND tb_comite_programa.estado = '1'");
							 
 		
		while($f=mysqli_fetch_array($comites)){
			
			if(mysqli_num_rows(mysqli_query($link,"SELECT * FROM pegasoun_proyecto.tb_comite_trabajo WHERE tb_comite_trabajo.id_comite='".$f['id_comite']."' AND tb_comite_trabajo.id_trabajo='".$_POST["id_trabajo"]."' "))!=0){
				
			mysqli_query($link,"UPDATE pegasoun_proyecto.tb_comite_trabajo SET estado=1 WHERE tb_comite_trabajo.id_comite='".$f['id_comite']."' AND tb_comite_trabajo.id_trabajo='".$_POST["id_trabajo"]."'");
			
					}
					
				else{
					mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_comite_trabajo` (`id_comite_trabajo` ,`estado` ,`id_comite` ,`id_trabajo`) VALUES (NULL ,  '1',  '".$f['id_comite']."',  '".$_POST["id_trabajo"]."')");
					}
			}
			
			if(mysqli_num_rows($comites)>0){
				
				//Propuestas
					if($_POST['doc']==1){
						
						if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '0', `emisor` ='3', `recetor` =  '1', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'")){
						
						echo json_encode("La Propueta se ha enviado al Comite con éxito");
						}
					}
			//Proyectos			
			if($_POST['doc']==2){
				
				if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor` ='3', `recetor` =  '1', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'")){
						
						echo json_encode("El Proyecto se ha enviado al Comite con éxito");
						}
				 }
				}
			
		else{echo json_encode("No Hay miembros del comite para este Programa");}
			
			}break;
			
		case 8:{//Comite envia observaciones de las propuestas y proyectos
				$id_trabajo=$_POST['id_trabajo'];
				$id_comite=$_POST['id_comite'];
				$observacion=$_POST['observacion'];
				$fecha=date("Y-m-d");
				
			
				mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comite_trabajo` SET  `estado` =  '0' WHERE  `tb_comite_trabajo`.`id_comite` ='".$id_comite."' AND `tb_comite_trabajo`.`id_trabajo` ='".$id_trabajo."'");
				
				$consult=mysqli_query($link,"SELECT tb_comite_trabajo.id_trabajo, tb_comite_trabajo.estado
	  FROM pegasoun_proyecto.tb_comite_trabajo tb_comite_trabajo WHERE tb_comite_trabajo.id_trabajo ='".$id_trabajo."'");
	  
				$contando=0;
				$num=mysqli_num_rows($consult);
				
				while($f=mysqli_fetch_array($consult)){
						if($f['estado']==0){$contando+=1;}
					}
					
					if($num==$contando){
						//Propuesta
						
						if($_POST['doc']==0){
								mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '0', `emisor` =  '1', `recetor` =  '3', `habilita_plataforma` =  '0', `estado_proyecto`='1'  WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
							}
						//Proyecto
						if($_POST['doc']==1){
								mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor` =  '1', `recetor` =  '3', `habilita_plataforma` =  '0', `estado_proyecto`='1'  WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
							}
							
						//Informe
						if($_POST['doc']==2){
								mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` =  '1', `recetor` =  '3', `habilita_plataforma` =  '0', `estado_proyecto`='1'  WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
							}
						
						}
						
					if(mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_observaciones` (`id_observacion` ,`observacion` ,`fecha` ,`estado`, `id_trabajo` ,`id_comite`) VALUES (NULL ,  '$observacion',  '$fecha', '1',  '$id_trabajo',  '$id_comite')")){
					
									echo json_encode("Observaciones Guardadas");
									}
					
					else{echo json_encode("Error al guardar ".mysql_error());}
				
			}break;
			
		case 9:{//Cuando la Propuesta es Aprobada, Aplazada o Rechazada
				
				$id_trabajo=$_POST['id_trabajo'];
				$fecha_aprobacion=date("Y-m-d");
				$uploaddir ="../documentos/actas_individuales/";
				
				
				if($_POST['opci']==1){//APROBADO
				
						$uploadfile = $uploaddir.basename($_POST['codigo_radi'].'_'.$fecha_aprobacion.'.pdf');
						$codigo_radi=$_POST['codigo_radi'];
						
						if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)){
							
							//Asignando el Director al Trabajo
							if(isset($_POST['id_director'])){
								 $id_director=$_POST['id_director'];
								 mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_trabajo tb_director` (`id_director`, `id_trabajo`, `estado`) VALUES ('".$id_director."', '".$id_trabajo."', '1')");
								 $doc=1;
								 $resp=true;
							}
							
							else{
								
								if(isset($_POST['id_director_inves'])){
									$id_dir=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_director_investi.id_director_inves
											FROM pegasoun_proyecto.tb_director_investi tb_director_investi
										WHERE tb_director_investi.id_usuario = '".$_POST['id_director_inves']."'"));
									
									mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_dir_trabajo` (`id_dir_trabajo`, `estado`, `id_director_inves`, `id_trabajo`) VALUES (NULL, '1' ,'".$id_dir['id_director_inves']."', '".$id_trabajo."')");
									$doc=1;
									$resp=true;
									}
									
									
								else{
							
									//Asignando los Tutores de practica al trabajo
									if(isset($_POST['id_tutor1']) || isset($_POST['id_tutor2'])){
									
										$usuario1=$_POST['id_tutor1'];
										$id_tutor_inter=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_tutor_interno.id_tutor_interno FROM pegasoun_proyecto.tb_tutor_interno tb_tutor_interno  WHERE tb_tutor_interno.id_usuario = '".$usuario1."'"));
										
										$usuario2=$_POST['id_tutor2'];
										$id_tutor_exter=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_tutor_externo.id_tutor_externo FROM pegasoun_proyecto.tb_tutor_externo tb_tutor_externo WHERE tb_tutor_externo.id_usuario = '".$usuario2."'"));



										$tutor_interno="INSERT INTO `pegasoun_proyecto`.`tb_histo_tuto_inter` (`id_histo_inter`, `estado`, `id_tutor_interno`, `id_trabajo`) VALUES (NULL, '1', '".$id_tutor_inter['id_tutor_interno']."', '".$id_trabajo."');";
										
										$tutot_externo="INSERT INTO `pegasoun_proyecto`.`tb_histo_tuto_exter` (`id_hist_exter`, `estado`, `id_tutor_externo`, `id_trabajo`) VALUES (NULL, '1', '".$id_tutor_exter['id_tutor_externo']."', '".$id_trabajo."');";
										
									
										if(mysqli_query($link,$tutor_interno)  || mysqli_query($link,$tutot_externo)){
											$doc=2;
											$resp=true;
											}
										else{$resp=false;}
									}
									
									else{
										  $resp=false;
										}
									
								}
							}
							
							
							if($_POST['id_modalidad']==5){$doc=2;}
							
							if($resp){
							
							
							mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_concepto` (`id_concepto`, `ruta`, `fecha_subida`, `revisado`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha_aprobacion."', '1', '".$id_trabajo."')");
							
							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo` SET  `codigo_trabajo` =  '".$codigo_radi."' , `fecha_aprobacion`='".$fecha_aprobacion."' WHERE  `tb_trabajo`.`id_trabajo` ='".$id_trabajo."'");
							
							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '".$doc."', `emisor`='3', `recetor` =  '4', `habilita_plataforma`='1', `estado_proyecto`='1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
							
							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_observaciones` SET  `estado` =  '0' WHERE  `tb_observaciones`.`id_trabajo` ='".$id_trabajo."'");
							
							echo json_encode("La propuesta fue Aprobada.");
							}
							
							else{echo json_encode("No se le han asignado docentes para el seguimiento del proyecto ");}
							
							
							}
							
						else{
 							 echo json_encode("El Archivo no se pudo Cargar");
							}
						
						
				}
				
				
				if($_POST['opci']==2){//APLAZADO
					$uploadfile = $uploaddir.basename($id_trabajo.'_'.$fecha_aprobacion.'.pdf');
					if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)){
					
						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '0', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo` SET   estado=2 WHERE  `tb_trabajo`.`id_trabajo` ='".$id_trabajo."'");
						mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_concepto` (`id_concepto`, `ruta`, `fecha_subida`, `revisado`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha_aprobacion."', '1', '".$id_trabajo."')");
	
						echo json_encode('La Propuesta fue Aplazada');
					}
					
				else{
						echo json_encode('Error al cargar el documento');
						
					}
				}
				
				if($_POST['opci']==3){//RECHAZADO
				
					$uploadfile = $uploaddir.basename($id_trabajo.'_'.$fecha_aprobacion.'.pdf');
					if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)){

					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '0', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo` SET   estado=3 WHERE  `tb_trabajo`.`id_trabajo` ='".$id_trabajo."'");
					mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_concepto` (`id_concepto`, `ruta`, `fecha_subida`, `revisado`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha_aprobacion."', '1', '".$id_trabajo."')");
	
					echo json_encode('La Propuesta fue Rechazada');
					}
				}
				
				
				if($_POST['opci']==4){//Revisado por el jurado pero el proyecto todavia no se aprueba por correciones
				
					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '7', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");

					echo json_encode('El proyecto fue Revisado por el Jurado');
				  
				}
			}break;
			
		case 10:{//Enviando actas
				$uploaddir ="../documentos/actas_generales/";
				$fecha=date('Y-m-d');
			 
			 //tengo que averiguar si hay documentos revisados antes de mover un archivo y llenar la tabla tb_actas
			 
				if($_POST['tipo']==1){//Actas Enviada a Propuestas
					
						$propuestas_revisados=mysqli_query($link,"SELECT tb_trabajo.id_trabajo
														  FROM    pegasoun_proyecto.tb_comunicacion tb_comunicacion
															   JOIN
																  pegasoun_proyecto.tb_trabajo tb_trabajo
															   ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
														 WHERE (   tb_comunicacion.tipo_documento = '3'
																OR tb_comunicacion.tipo_documento = '5'
																OR tb_comunicacion.tipo_documento = '6')");
					
					if(mysqli_num_rows($propuestas_revisados)>0){
						
						if(mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_acta` (`id_acta` ,`fecha_subida`) VALUES (NULL, '".$fecha."')")){
							  $id_acta=mysqli_insert_id($link);
							  $uploadfile = $uploaddir . basename($id_acta.'.pdf');
							  mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_acta` SET  `ruta` = '".$uploadfile."' WHERE  `tb_acta`.`id_acta` ='".$id_acta."'");
							  
						  }
						
						if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
							
							
							
						 $id_trabajo= mysqli_query($link,"SELECT tb_trabajo.id_trabajo, tb_comunicacion.tipo_documento
												  FROM    pegasoun_proyecto.tb_comunicacion tb_comunicacion
													   JOIN
														  pegasoun_proyecto.tb_trabajo tb_trabajo
													   ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
												 WHERE (   tb_comunicacion.tipo_documento = '3'
														OR tb_comunicacion.tipo_documento = '5'
														OR tb_comunicacion.tipo_documento = '6')");
			   
								
								while($f=mysqli_fetch_array($id_trabajo)){
									mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_acta_trabajo` (`id_acta` ,`id_trabajo`,`revisado`) VALUES ('". $id_acta."',  '".$f['id_trabajo']."', '1')");
									
									$id_modalidad=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.id_modalidad
																	  FROM pegasoun_proyecto.tb_trabajo tb_trabajo
																	 WHERE tb_trabajo.id_trabajo = '".$f['id_trabajo']."' "));
									if($id_modalidad['id_modalidad']==1 || $id_modalidad['id_modalidad']==1){ 
									
											if($f['tipo_documento']==3){$doc=1; $esta_proy=1;}
											if($f['tipo_documento']==5){$doc=0; $esta_proy=1;}
											if($f['tipo_documento']==6){$doc=0; $esta_proy=3;}
									}
									
									if($id_modalidad['id_modalidad']==2){$doc=2; $esta_proy=1;}
									
									mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '".$doc."', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '".$esta_proy."' WHERE  `tb_comunicacion`.`id_trabajo` ='".$f['id_trabajo']."'");

									}
							
							echo json_encode("El Acta se ha subido a la plataforma ");	
							}
						
						else{echo json_encode("Error al cargar el Archivo");}
						
						}
						
					else{echo json_encode("No se encontraron Documentos Aprobados, aplazados o rechazados");}
					
					}//Fin actas enviadas a propuestas
					
					
					
				if($_POST['tipo']==2){//Actas Enviada a Proyectos
						 $proyectos_revisados= mysqli_query($link,"SELECT tb_trabajo.id_trabajo, tb_comunicacion.tipo_documento
														  FROM    pegasoun_proyecto.tb_comunicacion tb_comunicacion
															   JOIN
																  pegasoun_proyecto.tb_trabajo tb_trabajo
															   ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
														 WHERE ( tb_comunicacion.tipo_documento = '4'
																OR tb_comunicacion.tipo_documento = '7')");
																								
						if(mysqli_num_rows($proyectos_revisados)>0){
							
							 if(mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_acta` (`id_acta` ,`fecha_subida`) VALUES (NULL, '".$fecha."')")){
								 
								 $id_acta=mysqli_insert_id($link);
					  			 $uploadfile = $uploaddir . basename($id_acta.'.pdf');
					  			 mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_acta` SET  `ruta` = '".$uploadfile."' WHERE  `tb_acta`.`id_acta` ='".$id_acta."'");
								 
								 }//lleno tb_acta
								 
							if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
								
								$id_trabajo= mysqli_query($link,"SELECT tb_trabajo.id_trabajo, tb_comunicacion.tipo_documento
														  FROM    pegasoun_proyecto.tb_comunicacion tb_comunicacion
															   JOIN
																  pegasoun_proyecto.tb_trabajo tb_trabajo
															   ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
														 WHERE (   tb_comunicacion.tipo_documento = '4'
																OR tb_comunicacion.tipo_documento = '7')");
								
								while($f=mysqli_fetch_array($id_trabajo)){
									
									if($f['tipo_documento']==7){$recetor='4'; $habilita='1';}
									else{$recetor='2'; $habilita='0';}
									
									mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_acta_trabajo` (`id_acta` ,`id_trabajo`,`revisado`) VALUES ('". $id_acta."',  '".$f['id_trabajo']."', '1')");
									
									mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor` ='3', `recetor` =  '".$recetor."', `habilita_plataforma` =  '".$habilita."', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$f['id_trabajo']."'");
							
								}//while
								
								echo json_encode("El Acta se ha subido a la plataforma");
							
								}//move_upload
							else{echo json_encode("Error al cargar el Archivo");}
							
							}//Si hay Proyectos revisados
									
						else{echo json_encode("No se encontraron Documentos Revisados");} 
								
				}
					
			}break;
			
		case 11:{//Se envia Proyecto a los Jurados
			
				  $id_trabajo=$_POST['id_trabajo'];
				  $jurado1=$_POST['jurado1'];
				  $jurado2=$_POST['jurado2'];
				  
				 $codigo_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo
  							FROM pegasoun_proyecto.tb_trabajo tb_trabajo WHERE tb_trabajo.id_trabajo = '".$id_trabajo."' "));
				  
				  $fecha_envio=date("Y-m-d");				  
				  $uploaddir ="../documentos/actas_individuales/";
				  $uploadfile = $uploaddir.basename($codigo_trabajo['codigo_trabajo'].'_'.$fecha_envio.'.pdf');
				  
				 if(isset($_FILES['archivo']['name'])){
				  
					  if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)){
						  
						  mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_concepto` (`id_concepto`, `ruta`, `fecha_subida`, `revisado`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha_envio."', '1', '".$id_trabajo."')");
					
								  if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_trabajo tb_jurado` (`id_trabajo`, `id_jurado`, `estado`, `asignado`) VALUES ('".$id_trabajo."', '".$jurado1."', '1', '1'), ('".$id_trabajo."', '".$jurado2."', '1', '1')")){
									  
					
									mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor` ='3', `recetor` =  '2', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");
					
									echo json_encode("El documento se ha enviado a los Jurados");
							  }
				  }
				}
				  
				 else{
					 
					 	mysqli_query($link,"DELETE FROM `pegasoun_proyecto`.`tb_trabajo tb_jurado` WHERE `tb_trabajo tb_jurado`.`id_trabajo` = '".$id_trabajo."'");
						mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_trabajo tb_jurado` (`id_trabajo`, `id_jurado`, `estado`) VALUES ('".$id_trabajo."', '".$jurado1."', '1'), ('".$id_trabajo."', '".$jurado2."', '1')");
					
						
						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor` ='3', `recetor` =  '2', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");
						
						echo json_encode("El documento se ha enviado a los Jurados");
					 
					 }
		  		
			}break;
			
		case 12:{//Jurado envia observaciones al coordinador de los proyectos e informes
				$codigo_user=$_POST['codigo_user'];
				$id_trabajo=$_POST['id_trabajo'];
				$observacion=$_POST['observacion'];
				$fecha=date("Y-m-d");
				
				if(isset($_FILES['archivo'])){
				$uploaddir ="../documentos/correciones/";
				$codi_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo
  FROM pegasoun_proyecto.tb_trabajo tb_trabajo WHERE tb_trabajo.id_trabajo = '".$id_trabajo."'"));
  
				mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_corregir_docu` (`id_correccion`, `ruta_doc`, `id_trabajo`) VALUES (NULL, NULL, '".$id_trabajo."');");

				$id_correccion=mysqli_insert_id($link);
				$uploadfile = $uploaddir . basename($codi_trabajo['codigo_trabajo'].'_'.$id_correccion.'.doc');
				
				if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_corregir_docu` SET  `ruta_doc` =  '".$uploadfile."', `revisado` ='1'  WHERE  `tb_corregir_docu`.`id_correccion` ='".$id_correccion."'");
					}
					
				else{echo json_encode("Error al Cargar el Documento");break;}
					}
				
				
				
						$id_jurado=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_jurado.id_jurado
									  FROM    pegasoun_proyecto.tb_jurado tb_jurado
										   JOIN
											  pegasoun_proyecto.tb_usuario tb_usuario
										   ON (tb_jurado.id_usuario = tb_usuario.id_usuario)
									 WHERE tb_usuario.id_usuario = '".$codigo_user."' "));
									 
						if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_observa_jurado` (`id_observa_jurado`, `observacion`, `fecha`, `estado`, `id_trabajo`, `id_jurado`) VALUES (NULL, '".$observacion."', '".$fecha."', '1', '".$id_trabajo."', '".$id_jurado['id_jurado']."');")){
							
							
							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_jurado` SET  `estado` =  '0' WHERE  `tb_trabajo tb_jurado`.`id_trabajo` ='".$id_trabajo."' AND  `tb_trabajo tb_jurado`.`id_jurado` ='".$id_jurado['id_jurado']."'");
							
							$conta=mysqli_query($link,"SELECT `tb_trabajo tb_jurado`.id_trabajo
										  FROM pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
										 WHERE     `tb_trabajo tb_jurado`.id_trabajo = '".$id_trabajo."'
											   AND `tb_trabajo tb_jurado`.estado = '1' ");
											   
							if(mysqli_num_rows($conta)==0){
								
									if(isset($_POST['doc'])){
										
										mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='2', `recetor` =  '3', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."' ");
										
										
										}
									else{
								
											mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor` ='2', `recetor` =  '3', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."' ");
									}
								
								}
							
							echo json_encode("Se han Guardado Las Observaciones");
							
							}
							
						else{
								echo json_encode("Error al Guardado Las Observaciones ".mysql_error());
							
							}
			
			}break;
			
		case 13:{//Coordinador envia los informes a sus respectivos Jurados.
				if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '2', `habilita_plataforma` =  '0', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'")){
				
				$id_jurados=mysqli_query($link,"SELECT `tb_trabajo tb_jurado`.id_jurado
								  FROM pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
								 WHERE `tb_trabajo tb_jurado`.id_trabajo ='".$_POST['id_trabajo']."' ");
								 
				while($f=mysqli_fetch_array($id_jurados)){
					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_jurado` SET  `estado` =  '1' WHERE  `tb_trabajo tb_jurado`.`id_trabajo` ='".$_POST['id_trabajo']."' AND  `tb_trabajo tb_jurado`.`id_jurado` ='".$f['id_jurado']."'");
					
					}
				

				echo json_encode("El Informe se ha enviado al Jurado ");
				
				}
				
			else{
					echo json_encode("Error al Actualizar ".mysql_error());
				}
			
			}break;
			
	case 14:{//Cuando el administrador envia para Correccion por parte de él MISMO
				$fecha=date("Y-m-d");
		
				if($_POST['opci']==1){//Corregir Las Propuestas
						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '0', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");

				
						mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_observacion` (`id_observacion` ,`observacion` ,`fecha_publicacion` ,`id_trabajo`) VALUES (NULL ,  '".$_POST['observacion']."',  '".$fecha."',  '".$_POST['id_trabajo']."')");
				
				echo json_encode(array("mensaje"=>"Se ha enviado la sugerencia", "url"=>"subdirectorios/ajax_cuerpo/propuestas.php"));
				
				}
				
				if($_POST['opci']==2){//Corregir los Proyectos
						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");

				
				mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_observacion` (`id_observacion` ,`observacion` ,`fecha_publicacion` ,`id_trabajo`) VALUES (NULL ,  '".$_POST['observacion']."',  '".$fecha."',  '".$_POST['id_trabajo']."')");
				echo json_encode(array("mensaje"=>"Se ha enviado la sugerencia", "url"=>"subdirectorios/ajax_cuerpo/proyectos.php"));
				}
				
			if($_POST['opci']==3){//Rechazo de la Propuesta por parte del administrador
						mysqli_query($link,"UPDATE  `pegasoun_proy  ecto`.`tb_comunicacion` SET  `tipo_documento` =  '0', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");
						
				mysqli_query($link,"DELETE FROM `pegasoun_proyecto`.`tb_observacion` WHERE `tb_observacion`.`id_trabajo` = '".$_POST['id_trabajo']."'");
				
				mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_observacion` (`id_observacion` ,`observacion` ,`fecha_publicacion` ,`id_trabajo`) VALUES (NULL ,  '".$_POST['observacion']."',  '".$fecha."',  '".$_POST['id_trabajo']."')");
				
				echo json_encode(array("mensaje"=>"Se ha enviado la sugerencia", "url"=>"subdirectorios/ajax_cuerpo/propuestas.php"));
				
				//echo json_encode("Se ha enviado la sugerencia preguntar si se almacenan las propuestas o eliminan actualizar case 14 opc 3");
				}
		}break;
		
	case 15:{//El administrador envia observaciones de los informes tecno-gestion para corregir
					$fecha=date('Y-m-d');
				
					if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_documento']."'")
){
						
						if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_observacion` (`id_observacion`, `observacion`, `fecha_publicacion`, `id_trabajo`) VALUES (NULL, '".$_POST['string']."', '".$fecha."', '".$_POST['id_documento']."');")){
							
							$id_modalidad=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.id_modalidad
  																			FROM pegasoun_proyecto.tb_trabajo tb_trabajo  WHERE tb_trabajo.id_trabajo = '".$_POST['id_documento']."'"));
																			
								
							
							echo json_encode("El Informe se ha Devuelto");
							}
						else{
								echo json_encode("Error al guardar las Observaciones ".mysql_error());
							}
						
							
						}
		}break;
		
	case 16:{
	
			 $id_trabajo=$_POST['id_trabajo'];
			 $tipo=$_POST['tipo'];
			 $obervacion=$_POST['obervacion'];
			 
			 $fecha=date("Y-m-d");
			 
			 $id_modalidad=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.id_modalidad
  FROM pegasoun_proyecto.tb_trabajo tb_trabajo WHERE tb_trabajo.id_trabajo = '".$id_trabajo."'"));
  
  			if($id_modalidad['id_modalidad']==2){			 
			  $avances=mysqli_query($link,"SELECT MAX(tb_avances.id_avance) AS id_avance, tb_avances.informe_avance FROM pegasoun_proyecto.tb_avances tb_avances WHERE tb_avances.id_trabajo = '".$id_trabajo."'");
												  $con=mysqli_num_rows($avances);
			}
			
			if($id_modalidad['id_modalidad']==5){
				$avances=mysqli_query($link,"SELECT MAX(tb_avance.id_avance) AS id_avance, tb_avance.informe_avance FROM pegasoun_proyecto.tb_avance tb_avance WHERE tb_avance.id_trabajo = '".$id_trabajo."'");
												  $con=mysqli_num_rows($avances);
				}
			
								 
			 if($con==1){
					 mysqli_query($link,"DELETE FROM `pegasoun_proyecto`.`tb_observacion` WHERE `tb_observacion`.`id_trabajo` = '".$id_trabajo."'");		 
					 }
					 
			mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_observacion` (`id_observacion`, `observacion`, `fecha_publicacion`, `id_trabajo`) VALUES (NULL, '".$obervacion."', '".$fecha."', '".$id_trabajo."')");
				 
			mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");
								 
								 
			 
			 if($tipo==1){
				 
				 
				 echo json_encode("El infome se ha Aprobado");
			 }
				 
			 
			 if($tipo==2){
				 
				 $id_avance=mysqli_fetch_assoc($avances);
				 
				 if($id_modalidad['id_modalidad']==2){
					  mysqli_query($link,"DELETE FROM `pegasoun_proyecto`.`tb_avances` WHERE `tb_avances`.`id_avance` = '".$id_avance['id_avance']."'");
					 }
					 
				 if($id_modalidad['id_modalidad']==5){
					   mysqli_query($link,"DELETE FROM `pegasoun_proyecto`.`tb_avance` WHERE `tb_avance`.`id_avance` = '".$id_avance['id_avance']."' ");
					 }
				
				  unlink($id_avance['informe_avance']);
				
				
				echo json_encode("El infome fue Devuelto");
				
				 }
		
		
		}break;
	case 17:{
			 $id_trabajo=$_POST['id_trabajo'];
		     $fecha_aprobacion=date("Y-m-d");
		     $uploaddir ="../documentos/actas_individuales/";
			 
			 $codigo_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo
						  FROM pegasoun_proyecto.tb_trabajo tb_trabajo
						 WHERE tb_trabajo.id_trabajo = '".$id_trabajo."'"));
						 
			 $uploadfile = $uploaddir.basename($codigo_trabajo['codigo_trabajo'].'_'.$fecha_aprobacion.'.pdf');
			 
		     if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)){
				 
				 mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_concepto` (`id_concepto`, `ruta`, `fecha_subida`, `revisado`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha_aprobacion."', '1', '".$id_trabajo."')");
				 
				 mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor`='3', `recetor` =  '4', `habilita_plataforma`='1', `estado_proyecto`='1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
				 
				 echo json_encode("Se ha enviado El concepto");
				 
				 }
				 
			else{echo json_encode("Error al Cargar el Archivo");}
		
		}break;
		
	case 18:{
			 $id_trabajo=$_POST['id_trabajo'];
		     $fecha_aprobacion=date("Y-m-d");
		     $uploaddir ="../documentos/cartas/";
			 
			 $codigo_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo
						  FROM pegasoun_proyecto.tb_trabajo tb_trabajo
						 WHERE tb_trabajo.id_trabajo = '".$id_trabajo."'"));
						 
			 $uploadfile = $uploaddir.basename($codigo_trabajo['codigo_trabajo'].'_'.$fecha_aprobacion.'.pdf');
			 
		     if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)){
				 
				 if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_carta` (`id_carta`, `ruta`, `fecha_subida`, `id_trabajo`, `revisado`) VALUES (NULL, '".$uploadfile."', '".$fecha_aprobacion."', '".$id_trabajo."', 1)")){
				 
				 mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '1', `emisor`='2', `recetor` =  '4', `habilita_plataforma`='1', `estado_proyecto`='1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
				 
				 echo json_encode("Se ha enviado El documento con las correcciones por parte del Jurado");
				 }
				 
				 else{echo json_encode("error ".mysql_error());}
				 
				 }
				 
			else{echo json_encode("Error al Cargar el Archivo");}
		
		
		}break;
		
	case 19:{
				$id_trabajo=$_POST['id_trabajo'];
				
				mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `emisor` =  '3', `recetor` =  '5' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."' ");
				
				echo json_encode("El Informe se Ha enviado Al Tutor");
		
		}break;
		
	case 20:{
			    $id_trabajo=$_POST['id_trabajo'];
				$id_tutor=$_POST['id_tutor'];
				$observacion=$_POST['observacion'];
				$fecha=date("Y-m-d");


			   if(isset($_FILES['archivo'])){

                    $uploaddir ="../documentos/correciones/";
                    $codi_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo FROM pegasoun_proyecto.tb_trabajo tb_trabajo WHERE tb_trabajo.id_trabajo = '".$id_trabajo."'"));
				 
				    mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_corregir_docu` (`id_correccion`, `ruta_doc`, `id_trabajo`) VALUES (NULL, NULL, '".$id_trabajo."');");
			        $id_correccion=mysqli_insert_id($link);
				    $uploadfile = $uploaddir . basename($codi_trabajo['codigo_trabajo'].'_'.$id_correccion.'.doc');

				  if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_corregir_docu` SET  `ruta_doc` =  '".$uploadfile."', `revisado` ='1'  WHERE  `tb_corregir_docu`.`id_correccion` ='".$id_correccion."'");
					}
					
				   else{echo json_encode("Error al Cargar el Documento");}
				}


				  mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_observa_tutor` (`id_observa_tutor`, `observacion`, `fecha`, `estado`, `id_trabajo`, `id_tutor_interno`) VALUES (NULL, '".$observacion."', '".$fecha."', '1', '".$id_trabajo."', '".$id_tutor."' )");
			          mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` =  '5', `recetor` =  '3', `habilita_plataforma` =  '0', `estado_proyecto`='1'  WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
				
				  echo json_encode("Las Observaciones se han Guardado");
		
		}break;
		
	case 21:{//informes de avance practica empresarial
		
			$codigo=$_POST['codigo'];
			$j=$_POST['j'];
			$estado=$_POST['select'];
			$user=$_POST['user'];
			$psw=hash('sha256',$_POST['psw']);
			
			
			if(mysqli_num_rows(mysqli_query($link,"SELECT * FROM  `tb_comite` WHERE  `id_usuario` LIKE  '".$codigo."'"))==1){
				
			if($_POST['psw']!=""){
					$psw=hash('sha256',$_POST['psw']);
					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comite` SET  `usuario` =  '".$user."', `password` =  '".$psw."',`estado` =  '".$estado."' WHERE  `tb_comite`.`id_usuario` ='".$codigo."'");
					}
					
			else{
					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comite` SET  `usuario` =  '".$user."',`estado` =  '".$estado."' WHERE  `tb_comite`.`id_usuario` ='".$codigo."'");
				}
								
			$id_comite=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_comite.id_comite FROM  `tb_comite` WHERE  `id_usuario` LIKE  '".$codigo."'"));

				for($i=0; $i<$j; $i++){
					$programa=$_POST['check_'.$i];
					$estado=$_POST['estado_'.$i];
					
					if(mysqli_num_rows(mysqli_query($link,"SELECT tb_comite_programa.* FROM pegasoun_proyecto.tb_comite_programa tb_comite_programa WHERE tb_comite_programa.id_comite = '".$id_comite['id_comite']."' AND tb_comite_programa.id_programa = '".$programa."'"))==1){
					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comite_programa` SET  `estado` ='".$estado."' WHERE  `tb_comite_programa`.`id_comite` ='".$id_comite['id_comite']."' AND `tb_comite_programa`.`id_programa`='".$programa."' ");	
						}
						
				else{
						mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_comite_programa` (`id_comite_programa`, `estado`, `id_comite`, `id_programa`) VALUES (NULL, '".$estado."', '".$id_comite['id_comite']."', '".$programa."')");
					}
					
					}
					
					echo json_encode("Los datos se han actualizado con éxito");
				
				}
				
			else{
				 mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_comite` (`id_comite`, `usuario`, `password`, `estado`, `id_usuario`) VALUES (NULL, '".$user."', '".$psw."', '".$estado."', '".$codigo."');");
				 $id_comite=mysqli_insert_id($link);
				 for($i=0; $i<$j; $i++){
					$programa=$_POST['check_'.$i];
					$estado=$_POST['estado_'.$i];
					mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_comite_programa` (`id_comite_programa`, `estado`, `id_comite`, `id_programa`) VALUES (NULL, '".$estado."', '".$id_comite."', '".$programa."')");
					}
					echo json_encode("Los datos se han guardado con éxito");
				}
			
		
		}break;
		
	case 22:{
				  $id_trabajo=$_POST['id_trabajo'];
				  
				 $codigo_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo
  							FROM pegasoun_proyecto.tb_trabajo tb_trabajo WHERE tb_trabajo.id_trabajo = '".$id_trabajo."' "));
				  
				  $fecha_envio=date("Y-m-d");				  
				  $uploaddir ="../documentos/actas_individuales/";
				  $uploadfile = $uploaddir.basename($codigo_trabajo['codigo_trabajo'].'_'.$fecha_envio.'.pdf');
				  
				 if(isset($_FILES['archivo']['name'])){
				  
					  if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)){
						  
						  mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_concepto` (`id_concepto`, `ruta`, `fecha_subida`, `revisado`, `id_trabajo`) VALUES (NULL, '".$uploadfile."', '".$fecha_envio."', '1', '".$id_trabajo."')");
					
					
									mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '1', `estado_proyecto` =  '1' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_trabajo']."'");
					
									echo json_encode("Se ha Enviado los Conceptos  del Comite");
							  
				  }
				}		
		}break;
		
		case 23:{//El administrador envia observaciones de los informes Aprobados de Formulacion de Investigación
					$fecha=date('Y-m-d');
				
					if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '4', `habilita_plataforma` =  '0', `estado_proyecto` =  '2' WHERE  `tb_comunicacion`.`id_trabajo` ='".$_POST['id_documento']."'")
){
						
						if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_observacion` (`id_observacion`, `observacion`, `fecha_publicacion`, `id_trabajo`) VALUES (NULL, '".$_POST['string']."', '".$fecha."', '".$_POST['id_documento']."');")){
							
							echo json_encode("Informe Aprobado");
							}
						else{
								echo json_encode("Error al guardar las Observaciones ".mysql_error());
							}
						
							
						}			
			}break;
			
		case 24:{
				$id_trabajo=$_POST['id_trabajo'];
				
				$comite=mysqli_query($link,"SELECT tb_comite.id_comite
							  FROM pegasoun_proyecto.tb_comite tb_comite
							 WHERE tb_comite.estado = '1'");
							 
				mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `tipo_documento` =  '2', `emisor` ='3', `recetor` =  '1', `habilita_plataforma` =  '0', `estado_proyecto` =  '2' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");
				
				
				
				while($f=mysqli_fetch_array($comite)){
					mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_comite_trabajo` (`id_comite_trabajo`, `estado`, `id_comite`, `id_trabajo`) VALUES (NULL, '1', '".$f['id_comite']."', '".$id_trabajo."')");
				}
				
				echo json_encode("El informe se ha enviado al Comite");
			}break;
			
		case 25:{//Asigno Rol tutor a los Docentes
		
				$usuario=$_POST['usuario'];
				$pws=hash('sha256',$_POST['pws']);
				$codigo=$_POST['codigo'];
				$estado=$_POST['estado'];
				
				$existe=mysqli_query($link,"SELECT tb_tutor_interno.id_tutor_interno
									  FROM pegasoun_proyecto.tb_tutor_interno tb_tutor_interno
									 WHERE tb_tutor_interno.id_usuario = '".$codigo."' ");
									 
			if(mysqli_num_rows($existe)>0){
				
						if($_POST['pws']!=""){
							if(mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_tutor_interno` SET  `usuario` =  '".$usuario."', `password` =  '".$pws."', `estado` =  '".$estado."'  WHERE `tb_tutor_interno`.`id_usuario` ='".$codigo."' ")){
							
							echo json_encode("Los Datos se han Modificado");
						}
						
						else{
								echo json_encode("Error ".mysql_error());
									
							}
						}
						
						else{
								mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_tutor_interno` SET  `usuario` =  '".$usuario."',  `estado` =  '".$estado."'  WHERE `tb_tutor_interno`.`id_usuario` ='".$codigo."' ");
								echo json_encode("Los Datos se han Modificado ".$estado);
							}
				
				}
				
			else{
						
						if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_tutor_interno` (`id_tutor_interno`, `usuario`, `password`, `estado`, `id_usuario`)  VALUES (NULL, '".$usuario."', '".$pws."', '".$estado."', '".$codigo."')")){
								
								echo json_encode("Los Datos se han guardado con éxito");
							}
							
						 else{
								echo json_encode("Error Al guardar FWFFASFAFAEE".mysql_error());
							}
					}
	
			
			}break;
			
		case 26:{
					$id_trabajo=$_POST['id_trabajo'];
					$id_director=$_POST['director'];
					$jurado1=$_POST['jurado1'];
					$jurado2=$_POST['jurado2'];
					
					$director=mysqli_query($link,
					"SELECT `tb_trabajo tb_director`.id_director, `tb_trabajo tb_director`.estado  
						FROM pegasoun_proyecto.`tb_trabajo tb_director` `tb_trabajo tb_director`
				 		WHERE `tb_trabajo tb_director`.estado = 1
					   	AND `tb_trabajo tb_director`.id_trabajo = '".$id_trabajo."'
					   	AND `tb_trabajo tb_director`.id_director ='".$id_director."'");
				//si el director junto con el trabajo esta asignado	   
					   
					$dir_desabili=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_director`.id_director, `tb_trabajo tb_director`.estado FROM pegasoun_proyecto.`tb_trabajo tb_director` `tb_trabajo tb_director`
						 WHERE     `tb_trabajo tb_director`.id_trabajo = '".$id_trabajo."'
							   AND `tb_trabajo tb_director`.id_director = '".$id_director."'"));
							   
				//si el director junto con el trabajo esta desabilitado					   
								   
									   
						   
					if(mysqli_num_rows($director)==0 || $dir_desabili['estado']==0){
						
							$direc_actual=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_director`.id_director, `tb_trabajo tb_director`.estado
									  FROM pegasoun_proyecto.`tb_trabajo tb_director` `tb_trabajo tb_director`
									 WHERE     `tb_trabajo tb_director`.id_trabajo = '".$id_trabajo."'
										   AND `tb_trabajo tb_director`.estado = 1"));
											 
					 		$dir_desab=mysqli_query($link,"SELECT `tb_trabajo tb_director`.id_director
									  FROM pegasoun_proyecto.`tb_trabajo tb_director` `tb_trabajo tb_director`
									 WHERE     `tb_trabajo tb_director`.id_director = '".$id_director."'
										   AND `tb_trabajo tb_director`.id_trabajo = '".$id_trabajo."'
										   AND `tb_trabajo tb_director`.estado = 0");
									   
					if(mysqli_num_rows($dir_desab)==1){
						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_director` SET  `estado` =  '1' WHERE  `tb_trabajo tb_director`.`id_director` ='".$id_director."' AND `tb_trabajo tb_director`.`id_trabajo` ='".$id_trabajo."'");
						
						}
						
					else{
							mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_trabajo tb_director` (`id_director_trabajo`, `estado`, `id_trabajo`, `id_director`) VALUES (NULL, '1', '".$id_trabajo."', '".$id_director."')");
						
						}
						
						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_director` SET  `estado` =  '0' WHERE  `tb_trabajo tb_director`.`id_director` ='".$direc_actual['id_director']."'");
						
						echo json_encode("El Director se Ha Actualizado");
						
						}

						
						
					if(!empty($_POST['jurado1']) && !empty($_POST['jurado2'])){

							if($_POST['jurado1']!=$_POST['jurado2']){

								jurado($id_trabajo, $jurado1, $jurado2);
								jurado($id_trabajo, $jurado2, $jurado1);

								echo json_encode("Los jurados se han Actualizado");	

							}

							else{

								echo json_encode("Verifique que los Jurados son distintos");	

							}
							
					}

									
			}break;

		case 27:{

					$id_trabajo=$_POST['id_trabajo'];
					$tuto_inter=$_POST['tuto_inter'];
					$tuto_exter=$_POST['tuto_exter'];

					 $sql_interno="SELECT tb_histo_tuto_inter.id_trabajo, tb_histo_tuto_inter.estado
										  FROM pegasoun_proyecto.tb_histo_tuto_inter tb_histo_tuto_inter
										 WHERE     tb_histo_tuto_inter.id_trabajo = '".$id_trabajo."'
										       AND tb_histo_tuto_inter.id_tutor_interno = '".$tuto_inter."'";

					$sql_externo="SELECT tb_histo_tuto_exter.id_trabajo, tb_histo_tuto_exter.estado
								  FROM pegasoun_proyecto.tb_histo_tuto_exter tb_histo_tuto_exter
								 WHERE     tb_histo_tuto_exter.id_trabajo ='".$id_trabajo."'
								       AND tb_histo_tuto_exter.id_tutor_externo = '".$tuto_exter."'";
					

					if(mysqli_num_rows(mysqli_query($link,$sql_interno))==0){

						$tuto_actu=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_histo_tuto_inter.id_histo_inter
									  FROM pegasoun_proyecto.tb_histo_tuto_inter tb_histo_tuto_inter
									 WHERE tb_histo_tuto_inter.estado = 1 AND tb_histo_tuto_inter.id_trabajo = '".$id_trabajo."'"));

						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_histo_tuto_inter` SET  `estado` =  '0' WHERE  `tb_histo_tuto_inter`.`id_histo_inter` ='".$tuto_actu['id_histo_inter']."'");
						mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_histo_tuto_inter` (`id_histo_inter`, `estado`, `id_tutor_interno`, `id_trabajo`) VALUES (NULL, '1', '".$tuto_inter."', '".$id_trabajo."');");

						$mensaje="El tutor Interno se ha modificado";
						}


					$tuto1=mysqli_fetch_assoc(mysqli_query($link,$sql_interno));

					if ($tuto1['estado']==0) {

						$tuto_actu=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_histo_tuto_inter.id_histo_inter
									  FROM pegasoun_proyecto.tb_histo_tuto_inter tb_histo_tuto_inter
									 WHERE tb_histo_tuto_inter.estado = 1 AND tb_histo_tuto_inter.id_trabajo = '".$id_trabajo."'"));

						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_histo_tuto_inter` SET  `estado` =  '0' WHERE  `tb_histo_tuto_inter`.`id_histo_inter` ='".$tuto_actu['id_histo_inter']."'");
						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_histo_tuto_inter` SET  `estado` =  '1' WHERE  `tb_histo_tuto_inter`.`id_trabajo` ='".$id_trabajo."' AND   `tb_histo_tuto_inter`.`id_tutor_interno` ='".$tuto_inter."'");
						$mensaje="El tutor Interno se ha modificado";
					}

					//Tutor Externo


					if(mysqli_num_rows(mysqli_query($link,$sql_externo))==0){

						$tuto_actu=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_histo_tuto_inter.id_histo_inter
									  FROM pegasoun_proyecto.tb_histo_tuto_inter tb_histo_tuto_inter
									 WHERE tb_histo_tuto_inter.estado = 1 AND tb_histo_tuto_inter.id_trabajo = '".$id_trabajo."'"));

						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_histo_tuto_inter` SET  `estado` =  '0' WHERE  `tb_histo_tuto_inter`.`id_histo_inter` ='".$tuto_actu['id_histo_inter']."'");
						mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_histo_tuto_inter` (`id_histo_inter`, `estado`, `id_tutor_interno`, `id_trabajo`) VALUES (NULL, '1', '".$tuto_inter."', '".$id_trabajo."');");

						$mensaje="El tutor Interno se ha modificado";
						}


					$tuto1=mysqli_fetch_assoc(mysqli_query($link,$sql_externo));

					if ($tuto1['estado']==0) {

						$tuto_actu=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_histo_tuto_inter.id_histo_inter
									  FROM pegasoun_proyecto.tb_histo_tuto_inter tb_histo_tuto_inter
									 WHERE tb_histo_tuto_inter.estado = 1 AND tb_histo_tuto_inter.id_trabajo = '".$id_trabajo."'"));

						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_histo_tuto_inter` SET  `estado` =  '0' WHERE  `tb_histo_tuto_inter`.`id_histo_inter` ='".$tuto_actu['id_histo_inter']."'");
						mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_histo_tuto_inter` SET  `estado` =  '1' WHERE  `tb_histo_tuto_inter`.`id_trabajo` ='".$id_trabajo."' AND   `tb_histo_tuto_inter`.`id_tutor_interno` ='".$tuto_inter."'");
						$mensaje="El tutor Interno se ha modificado";
					}

					echo json_encode("El tutor Interno se ha modificado");


			}break;

		case 28:{
					$id_trabajo=$_POST['id_trabajo'];
					$dir_investi=$_POST['dir_investi'];

					$director=mysqli_query($link,"SELECT tb_dir_trabajo.id_dir_trabajo
											  FROM pegasoun_proyecto.tb_dir_trabajo tb_dir_trabajo
											 WHERE tb_dir_trabajo.id_trabajo = '".$id_trabajo."' AND tb_dir_trabajo.id_director_inves = '".$dir_investi."' ");

					$id_dir_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_dir_trabajo.id_dir_trabajo
									  FROM pegasoun_proyecto.tb_dir_trabajo tb_dir_trabajo
									 WHERE tb_dir_trabajo.estado = 1 AND tb_dir_trabajo.id_trabajo = '".$id_trabajo."' "));

					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_dir_trabajo` SET  `estado` =  '0' WHERE  `tb_dir_trabajo`.`id_dir_trabajo` ='".$id_dir_trabajo['id_dir_trabajo']."'");

					if(mysqli_num_rows($director)==0){

	
						mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_dir_trabajo` (`id_dir_trabajo`, `estado`, `id_director_inves`, `id_trabajo`) VALUES (NULL, '1', '".$dir_investi."', '".$id_trabajo."');");

						}

					else{

							mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_dir_trabajo` SET  `estado` =  '1' WHERE  `tb_dir_trabajo`.`id_director_inves` ='".$dir_investi."' AND  `tb_dir_trabajo`.`id_trabajo` = '".$id_trabajo."' ");


					    }

					    echo json_encode("El Director de Investigación se ha modificado");

			}break;

		case 29:{

					$id_usuario=$_POST['id_usuario'];
					$desercion=$_POST['desercion'];
					$archivo=$_FILES['archivo']['name'];
					$fecha=date("Y-m-d");

					$uploaddir ="../documentos/desvinculacion/";
				    $uploadfile = $uploaddir.basename($id_usuario.'_'.$fecha.'.pdf');
				  
				    if(isset($_FILES['archivo']['name'])){
				  
					   if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)){

					   	mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_estudiante` SET  `motivo_desercion` =  '".$desercion."',
`fecha_desercion` =  '".$fecha."', `doc_desvin` =  '".$uploadfile."',
`estado` =  '0' WHERE  `tb_trabajo tb_estudiante`.`id_usuario` =  '".$id_usuario."';");

					   	echo json_encode("El integrante se ha desvinculado del proyecto");


					   }
					}
		}break;

	case 30:{

			$id_trabajo=$_POST['id_trabajo'];

			mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_comunicacion` SET  `estado_proyecto` =  '3' WHERE  `tb_comunicacion`.`id_trabajo` ='".$id_trabajo."'");

			echo json_encode('El Proyecto ha sido Cancelado');
	}break;
	
	case 31:{
			$id_usuario=$_POST['id_usuario'];
			$user=$_POST['user'];
			$pasword=hash('sha256',$_POST['pasword']);
			
			if(mysqli_query($link,"UPDATE `tb_administrador` SET `user` = '".$user."', `password` = '".$pasword."' WHERE `tb_administrador`.`id_usuario` = '".$id_usuario."' ")){
					echo json_encode('Los datos se han actualiado');
				}
			else{
					echo json_encode("Error al actualizar los datos ".mysqli_error());
				}
		}break;
		
	case 32:{
			
			$codigo=$_POST['codigo'];
			$nombre=$_POST['nombre'];
			$apellido=$_POST['apellido'];
			$user=$_POST['usuario'];
			$pasword=hash('sha256',$_POST['passw']);
			
			if(mysqli_query($link,"INSERT INTO tb_usuario (id_usuario, nombre, apellido, id_perfil) VALUES ('".$codigo."', '".$nombre."', '".$apellido."', 1)")){
				
				mysqli_query($link,"UPDATE tb_administrador SET estado=0 WHERE estado=1");
				
				if(mysqli_query($link, "INSERT INTO tb_administrador (id_usuario, user, password, estado) VALUES('".$codigo."', '".$user."', '".$pasword."', 1)")){
					
					echo json_encode("Se ha creado un nuevo administrador");
					}
				else{echo json_encode("Error al Crear el administrdor "+mysqli_error());}
				}
				
			else{echo json_encode("Error al guardar los datos "+mysqli_error());}
		
		}break;
		
	case 33:{	$codigo=$_POST['CodigoAdmin'];
				$user=$_POST['user'];
				$pasword=hash('sha256',$_POST['pass']);
				
				mysqli_query($link,"UPDATE tb_administrador SET estado=0 WHERE estado=1");
				if(mysqli_query($link,"UPDATE `tb_administrador` SET `user` = '".$user."', `password` = '".$pasword."', `estado` = '1' WHERE `tb_administrador`.`id_usuario` = '".$codigo."' ")){
						echo json_encode("El usaurio se ha habilitado satisfactoriamente");
					}
				else{echo json_encode("Error al realizar la habilitacion del usaurio".mysqli_error());}
		
		}break;
		
	case 34:{ 	$codigo=$_POST['CodigoAdmin'];
				$user=$_POST['user'];
				$pasword=hash('sha256',$_POST['pass']);
				mysqli_query($link,"UPDATE tb_administrador SET estado=0 WHERE estado=1");
				
				if(mysqli_query($link,"INSERT INTO `tb_administrador` (`id_admin`, `id_usuario`, `user`, `password`, `estado`) VALUES (NULL, '".$codigo."', '".$user."', '".$pasword."', '1'); ")){
					 echo json_encode("Se ha creado un nuevo administrador");
					}
					
				else{echo json_encode("Error al Crear el administrdor ".mysqli_error($link));}
		}break;
		
	case 35:{
		
			$id_usuario=$_POST['id_usaurio'];
			$NComite=$_POST['NComite'];
			$AComite=$_POST['AComite'];
			$TComite=$_POST['TComite'];
			$CComite=$_POST['CComite'];
			$EComite=$_POST['EComite'];
			$UComite=$_POST['UComite'];
			$PComite=hash('sha256', $_POST['PComite']);
			
			if(mysqli_query($link,"UPDATE `tb_usuario` SET `nombre` = '".$NComite."', `apellido` = '".$AComite."', `telefono` = '".$TComite."', `correo` = '".$CComite."' WHERE `tb_usuario`.`id_usuario` = '".$id_usuario."'")){
				
				mysqli_query($link,"UPDATE tb_especialidad SET especialidad='".$EComite."' WHERE `id_usuario` = '".$id_usuario."' ");
				
				if(mysqli_query($link,"UPDATE `tb_comite` SET `usuario` = '".$UComite."', `password` = '".$PComite."' WHERE `tb_comite`.`id_usuario` = '".$id_usuario."' ")){
					echo json_encode("Los datos se han Actualizado");
					}
				else{echo json_encode("Error Al Actualizar ".mysqli_error($link));}
				
				}
				
			else{echo json_encode("Error Al Actualizar ".mysqli_error($link));}
			
			
		}break;
		
	case 36:{
		
			$id_usaurio=$_POST['id_usaurio'];
			$NJurado=$_POST['NComite'];
			$AJurado=$_POST['AComite'];
			$TJurado=$_POST['TComite'];
			$CJurado=$_POST['CComite'];
			$EJurado=$_POST['EComite'];
			$UJurado=$_POST['UComite'];
			$PJurado=hash('sha256', $_POST['PComite']);
			
			if(mysqli_query($link,"UPDATE `tb_usuario` SET `nombre` = '".$NJurado."', `apellido` = '".$AJurado."', `telefono` = '".$TJurado."', `correo` = '".$CJurado."', `especialidad` = '".$EJurado."' WHERE `tb_usuario`.`id_usuario` = '".$id_usaurio."'")){
				
				if(mysqli_query($link,"UPDATE `tb_jurado` SET `usuario` = '".$UJurado."', `password` = '".$PJurado."' WHERE `tb_jurado`.`id_usuario` = '".$id_usaurio."' ")){
					echo json_encode("Los datos se han Actualizado");
					}
				else{echo json_encode("Error Al Actualizar ".mysqli_query());}
				
				}
				
			else{echo json_encode("Error Al Actualizar ".mysqli_query());}
		
		
		}break;
		
		
	case 37:{
			if(mysqli_query($link,"UPDATE `tb_usuario` SET `nombre` = '".$_POST['nombre']."', `apellido` = '".$_POST['apellido']."', `telefono` = '".$_POST['telefono']."', `correo` = '".$_POST['correo']."' WHERE `tb_usuario`.`id_usuario` = '".$_POST['id_tutor']."'; ")){
				
				mysqli_query($link,"UPDATE tb_especialidad SET especialidad='".$_POST['especialidad']."' WHERE  id_usuario = '".$_POST['id_tutor']."'; ");
				echo json_encode("Se han actuazido los datos para el estudiante $_POST[nombre]");
				
				}
				
			else{echo json_encode("Error al Actualizar ".mysqli_error($link));}
		
		
		}break;
	
		
		}
		

		
function jurado($id_trabajo, $jurado1, $jurado2){
	
			$jurados=mysqli_query($link,"SELECT `tb_trabajo tb_jurado`.asignado
						  FROM pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
						 WHERE     `tb_trabajo tb_jurado`.id_jurado = '".$jurado1."'
							   AND `tb_trabajo tb_jurado`.id_trabajo = '".$id_trabajo."'");
		

			$jura_habili=mysqli_fetch_assoc($jurados);	
			
			if(mysqli_num_rows($jurados)>0){

				$jurado_cambio=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_jurado`.id_trabajo_jurado,
						       `tb_trabajo tb_jurado`.id_jurado
						  FROM pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
						 WHERE     `tb_trabajo tb_jurado`.id_jurado != '".$jurado2."'
						       AND `tb_trabajo tb_jurado`.id_trabajo = '".$id_trabajo."'
						       AND `tb_trabajo tb_jurado`.asignado = 1"));

				mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_jurado` SET  `asignado` =  '0', `estado` =  '0' WHERE  `tb_trabajo tb_jurado`.`id_trabajo_jurado` ='".$jurado_cambio['id_trabajo_jurado']."' ");
															
				mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_jurado` SET  `asignado` =  '1' WHERE  `tb_trabajo tb_jurado`.`id_jurado` ='".$jurado1."'");

		}

		elseif (mysqli_num_rows($jurados)==0) {
		

				$jurado=mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM  `tb_trabajo tb_jurado` WHERE  `id_trabajo` ='".$id_trabajo."' AND  `id_jurado` !='".$jurado2."' "));

				mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_jurado` SET  `asignado` =  '0', `estado` =  '0' WHERE  `tb_trabajo tb_jurado`.`id_trabajo_jurado` ='".$jurado['id_trabajo_jurado']."'");
		
				mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_trabajo tb_jurado` (`id_trabajo_jurado`, `estado`, `asignado`, `id_trabajo`, `id_jurado`) VALUES (NULL, '0', '1', '".$id_trabajo."', '".$jurado1."')");
		}
		
	}	
?>

