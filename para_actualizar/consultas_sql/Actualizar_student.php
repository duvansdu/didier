<?php
include "../connections/conection.php";
include "formulario_student.php";

$opcion=$_POST['opcion'];

switch($opcion){
	
		case 1:{//inserta proyecto con los integrantes
				$id_modalidad=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_modalidad.id_modalidad
										  FROM    pegasoun_proyecto.tb_trabajo tb_trabajo
											   JOIN
												  pegasoun_proyecto.tb_modalidad tb_modalidad
											   ON (tb_trabajo.id_modalidad = tb_modalidad.id_modalidad)
										 WHERE tb_trabajo.id_trabajo = '".$_POST['id_trabajo']."'"));
										 
				switch($id_modalidad['id_modalidad']){
					
					case 1:{
							$uploaddir ="../documentos/desarrollo_tecnologico/proyecto/";
							
							 $resp=enviar_proyecto_cordi($uploaddir, $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], 'tb_trabajo tb_desarrollo tecnologico', $link);
							 
							 if($resp==true){
								 	//Insertando los integrantes del proyecto
								for($i=1; $i<=3; $i++){
										if(isset($_POST['codigo'.$i]) && isset($_POST['nombre'.$i]) && isset($_POST['apellido'.$i]) && isset($_POST['telefono'.$i]) && isset($_POST['correo'.$i]) && isset($_POST['programa'.$i])){
											
													insert_integrantes($_POST['codigo'.$i], $_POST['nombre'.$i], $_POST['apellido'.$i], $_POST['telefono'.$i], $_POST['correo'.$i],$_POST['programa'.$i], $_POST['id_trabajo'], $link);
											
												}
											
											}
								
								echo json_encode("Los datos se han guardado con  éxito");	
										
							  }
							  
							  else{
								  	echo json_encode($resp);
								  
								  }
						}break;
						
				case 3:{
							$uploaddir ="../documentos/formulacion_investigacion/proyecto/";
							 $resp=enviar_proyecto_cordi($uploaddir, $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], 'tb_trabajo tb_formulacion_investigacion', $link);
							 
							 if($resp==true){
								 	//Insertando los integrantes del proyecto
								for($i=1; $i<=3; $i++){
									if(isset($_POST['codigo'.$i]) && isset($_POST['nombre'.$i]) && isset($_POST['apellido'.$i]) && isset($_POST['telefono'.$i]) && isset($_POST['correo'.$i]) && isset($_POST['programa'.$i])){
											
										insert_integrantes($_POST['codigo'.$i], $_POST['nombre'.$i], $_POST['apellido'.$i], $_POST['telefono'.$i], $_POST['correo'.$i],$_POST['programa'.$i], $_POST['id_trabajo'], $link);
											
												}
											}
								
								echo json_encode("Los datos se han guardado con  éxito");	
										
							  }
							  
							  else{
								  	echo json_encode($resp);
								  
								  }
							 
							
						}break;
						
				case 4:{
						$uploaddir ="../documentos/gestion_empresarial/proyecto/";
					
						$resp=enviar_proyecto_cordi($uploaddir, $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], 'tb_trabajo tb_gestion_empresarial', $link);
							 
							 if($resp==true){
								//Insertando los integrantes del proyecto
								for($i=1; $i<=3; $i++){
							if(isset($_POST['codigo'.$i]) && isset($_POST['nombre'.$i]) && isset($_POST['apellido'.$i]) && isset($_POST['telefono'.$i]) && isset($_POST['correo'.$i]) && isset($_POST['programa'.$i])){
											
									insert_integrantes($_POST['codigo'.$i], $_POST['nombre'.$i], $_POST['apellido'.$i], $_POST['telefono'.$i], $_POST['correo'.$i],$_POST['programa'.$i], $_POST['id_trabajo'], $link);
											
												}
											
											}
							
								echo json_encode("Los datos se han guardado con  éxito");	
										
							  }
							  
							  else{
								  	echo json_encode($resp);
								  
								  }
					}break;
				}
			}break;
			
			
	case 2:{//inserta informes
		
			$id_modalidad=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_modalidad.id_modalidad
						  FROM    pegasoun_proyecto.tb_trabajo tb_trabajo
							   JOIN
								  pegasoun_proyecto.tb_modalidad tb_modalidad
							   ON (tb_trabajo.id_modalidad = tb_modalidad.id_modalidad)
						 WHERE tb_trabajo.id_trabajo = '".$_POST['id_trabajo']."'"));
						 
			
						 
					switch($id_modalidad['id_modalidad']){
						
						case 1:{
								$uploaddir ="../documentos/desarrollo_tecnologico/informes/";
								$modalidad="tb_trabajo tb_desarrollo tecnologico";
								enviar_informe($uploaddir, $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], $modalidad, $link);
								
								
							}break;
							
						case 2:{
							
							$codi_traba=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo
										  FROM pegasoun_proyecto.tb_trabajo tb_trabajo
										 WHERE tb_trabajo.id_trabajo = '".$_POST['id_trabajo']."'"));
								$fecha=date("Y-m-d");
							    $uploaddir ="../documentos/practica_profesional/informe_avance/";
								$uploadfile = $uploaddir . basename($codi_traba['codigo_trabajo'].'_'.$fecha.'.doc');
								
								
								$avances=mysqli_fetch_assoc(mysqli_query($link,"SELECT COUNT(tb_avances.informe_avance)AS cont
													  FROM pegasoun_proyecto.tb_avances tb_avances
													 WHERE tb_avances.id_trabajo = '".$_POST['id_trabajo']."' "));
													 
								if($avances['cont']<3){
								
									if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
										
										
										if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_avances` (`id_avance`, `informe_avance`, `fecha`, `id_trabajo`, `estado`) VALUES (NULL, '".$uploadfile."', '".$fecha."', '".$_POST['id_trabajo']."', '1')")){
											
											if(!mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_trabajo tb_pofesional` SET  `informe_final` =  '".$uploadfile."' WHERE  `tb_trabajo tb_pofesional`.`id_trabajo`= '".$_POST['id_trabajo']."'")){
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
							
							}break;
						
						
						case 3:{
								$uploaddir ="../documentos/formulacion_investigacion/informe_final/";
								$modalidad="tb_trabajo tb_formulacion_investigacion";
								enviar_informe($uploaddir, $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], $modalidad, $link);
							
							}break;
							
							
						case 4:{
								$uploaddir ="../documentos/gestion_empresarial/informes/";
								$modalidad="tb_trabajo tb_gestion_empresarial";
								enviar_informe($uploaddir, $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], $modalidad, $link);
							
							}break;
						case 5:{
							
							$codi_traba=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo
										  FROM pegasoun_proyecto.tb_trabajo tb_trabajo
										 WHERE tb_trabajo.id_trabajo = '".$_POST['id_trabajo']."'"));
								$fecha=date("Y-m-d");
							    $uploaddir ="../documentos/desarrollo_investigacion/informe_avance/";
								$uploadfile = $uploaddir . basename($codi_traba['codigo_trabajo'].'_'.$fecha.'.doc');
								
								
								$avances=mysqli_fetch_assoc(mysqli_query($link,"SELECT COUNT(tb_avance.informe_avance)AS cont
													  FROM pegasoun_proyecto.tb_avance tb_avance
													 WHERE tb_avance.id_trabajo = '".$_POST['id_trabajo']."' "));
													 
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
							
							}break;
						
							
					}
		}break;
		
	case 3:{//actualiza el proyecto por correcciones
			$id_modalidad=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_modalidad.id_modalidad
						  FROM    pegasoun_proyecto.tb_trabajo tb_trabajo
							   JOIN
								  pegasoun_proyecto.tb_modalidad tb_modalidad
							   ON (tb_trabajo.id_modalidad = tb_modalidad.id_modalidad)
						 WHERE tb_trabajo.id_trabajo = '".$_POST['id_trabajo']."'"));
						 
			$emisor=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_comunicacion.emisor
												  FROM pegasoun_proyecto.tb_comunicacion tb_comunicacion
												 WHERE tb_comunicacion.id_trabajo = '".$_POST['id_trabajo']."' "));
						 
					switch($id_modalidad['id_modalidad']){
						
						case 1:{
		
									$uploaddir ="../documentos/desarrollo_tecnologico/proyecto/";
									
									enviar_proyecto($uploaddir, $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], $emisor['emisor'], "tb_trabajo tb_desarrollo tecnologico", $link);
									
									
							}break;
						case 3:{
		
									$uploaddir ="../documentos/formulacion_investigacion/proyecto/";
									
									enviar_proyecto($uploaddir, $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], $emisor['emisor'],"tb_trabajo tb_formulacion_investigacion", $link);
									
									
							}break;
					
						case 4:{
									$uploaddir ="../documentos/gestion_empresarial/proyecto/";
									enviar_proyecto($uploaddir, $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], $emisor['emisor'], "tb_trabajo tb_gestion_empresarial", $link);
						
						
						
							}break;
					}
		
		
		
		}break;
		
	case 4:{
				$id_concepto=$_POST['id_concepto'];
				$id_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_concepto.id_trabajo
							  FROM pegasoun_proyecto.tb_concepto tb_concepto
							 WHERE tb_concepto.id_concepto = '".$id_concepto."'"));
											
				
				if($_POST['tipo_doc']==1){
					
					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_carta` SET  `revisado` =  '0' WHERE  `tb_carta`.`id_carta` ='".$id_concepto."'");
					}
				
				
				if($_POST['tipo_doc']==2){
				
					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_concepto` SET  `revisado` =  '0' WHERE  `tb_concepto`.`id_concepto` ='".$id_concepto."'");
				}
				
				if($_POST['tipo_doc']==3){
				
					mysqli_query($link,"UPDATE  `pegasoun_proyecto`.`tb_corregir_docu` SET  `revisado` =  '0' WHERE  `tb_corregir_docu`.`id_correccion` ='".$id_concepto."'");
				}
				
				echo json_encode(1);
		}break;
		
	case 5:{
			$id_modalidad=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.id_modalidad
											  FROM pegasoun_proyecto.tb_trabajo tb_trabajo
											 WHERE tb_trabajo.id_trabajo = '".$_POST['id_trabajo']."'"));
			//Insertando los integrantes del proyecto
			for($i=1; $i<=3; $i++){
							if(isset($_POST['codigo'.$i]) && isset($_POST['nombre'.$i]) && isset($_POST['apellido'.$i]) && isset($_POST['telefono'.$i]) && isset($_POST['correo'.$i]) && isset($_POST['programa'.$i])){
											
									insert_integrantes($_POST['codigo'.$i], $_POST['nombre'.$i], $_POST['apellido'.$i], $_POST['telefono'.$i], $_POST['correo'.$i],$_POST['programa'.$i], $_POST['id_trabajo'], $link);
											
												}
				}

	
			$codi_traba=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo
										  FROM pegasoun_proyecto.tb_trabajo tb_trabajo
										 WHERE tb_trabajo.id_trabajo = '".$_POST['id_trabajo']."'"));
			
			if($id_modalidad['id_modalidad']==2){
			
			subir_informe_avance_practi($codi_traba['codigo_trabajo'], $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], $link);
			}
			
			if($id_modalidad['id_modalidad']==5){
				
				subir_informe_avance_des($codi_traba['codigo_trabajo'], $_POST['id_trabajo'], $_FILES['archivo']['tmp_name'], $link);
				
				}
		}break;
		
	case 6:{
			$id_documento=$_POST['id_documento'];
			$user=$_POST['user'];
			$pass=hash('sha256',$_POST['pass']);
			
			if(mysqli_query($link,"UPDATE `tb_trabajo` SET `usuario` = '".$user."', `password` = '".$pass."' WHERE `tb_trabajo`.`id_trabajo` = '".$id_documento."' ")){
					
					echo json_encode("los datos se han actualizado");
				
				}
			else{
					echo json_encode("Error al Actualizar los datos ".mysqli_error());
				
				}
		}break;
		
	case 7:{
		
			if(mysqli_query($link,"UPDATE `tb_usuario` SET `nombre` = '".$_POST['nombre']."', `apellido` = '".$_POST['apellido']."', `telefono` = '".$_POST['telefono']."', `correo` = '".$_POST['correo']."' WHERE `tb_usuario`.`id_usuario` = '".$_POST['id_estudiante']."'; ")){
				
				echo json_encode("Se han actuazido los datos para el estudiante $_POST[nombre]");
				
				}
				
			else{echo json_encode("Error al Actualizar ".mysqli_error($link));}
		
		}break;
	}
?>
