<?php
include '../connections/conection.php';
$opcion=$_POST["opcion"];

switch($opcion){
	case 1:{//El estudiante sube la propuesta
				$password=hash('sha256',$_POST['password']);
				
				$subio=mysqli_num_rows(mysqli_query($link,"SELECT tb_trabajo.* FROM pegasoun_proyecto.tb_trabajo WHERE tb_trabajo.codigo_trabajo = '".$_POST['codigo']."'"));
				
				$permisos=mysqli_num_rows(mysqli_query($link,"SELECT tb_permiso_subir_archivo.estado, tb_programa_permiso.habilitar
							  FROM    pegasoun_proyecto.tb_programa_permiso tb_programa_permiso
								   JOIN
									  pegasoun_proyecto.tb_permiso_subir_archivo tb_permiso_subir_archivo
								   ON (tb_programa_permiso.id_permiso =
										  tb_permiso_subir_archivo.id_permiso)
							 WHERE     tb_programa_permiso.id_programa = '".$_POST['id_programa']."'
								   AND tb_permiso_subir_archivo.estado = '1'"));
								 
					if($subio==0){
								   
						if($permisos>0){
							
							if(mysqli_query($link,"INSERT INTO  `pegasoun_proyecto`.`tb_trabajo` (`id_trabajo` ,`codigo_trabajo` ,`titulo`, `usuario` ,`password` , `fecha_aprobacion` ,`id_programa`,`id_modalidad`) VALUES (NULL ,  '".$_POST['codigo']."',  '" .$_POST['titulo']."', '".$_POST['usuario']."',  '".$password."', NULL ,  '".$_POST['id_programa']."', '".$_POST['id_modalidad']."')")){
					
								$id_trabajo=mysqli_insert_id($link);
							
								mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`tb_comunicacion` (`id_trabajo`, `tipo_documento`,`emisor`,`recetor`, `habilita_plataforma`, `estado_proyecto`) VALUES('".$id_trabajo."', '0', '4', '3', '0', '1')");
					
		
								if($_POST['id_modalidad']==3){$uploaddir ="../documentos/formulacion_investigacion/propuestas/";$tabla="tb_trabajo tb_formulacion_investigacion"; $campo="propuesta";}
								if($_POST['id_modalidad']==5){$uploaddir ="../documentos/desarrollo_investigacion/solicitud_inclusion/";$tabla="tb_trabajo tb_desarrollo_investigcion"; $campo="solicitud_inclusion";}
								if($_POST['id_modalidad']==1){$uploaddir ="../documentos/desarrollo_tecnologico/propuestas/";$tabla="tb_trabajo tb_desarrollo tecnologico"; $campo="propuesta";}
								if($_POST['id_modalidad']==2){$uploaddir ="../documentos/practica_profesional/plan_trabajo/";$tabla="tb_trabajo tb_pofesional"; $campo="plan_trabajo";}
								if($_POST['id_modalidad']==4){$uploaddir ="../documentos/gestion_empresarial/propuestas/"; $tabla="tb_trabajo tb_gestion_empresarial"; $campo="propuesta";}
						
								$uploadfile = $uploaddir . basename($id_trabajo.'.pdf');
					
					
								if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadfile)) {
						
										if(mysqli_query($link,"INSERT INTO `pegasoun_proyecto`.`".$tabla."` (`".$campo."`, `id_trabajo`) VALUES ('".$uploadfile."','".$id_trabajo."')")){
								
										echo json_encode("Datos de Usuario para Ingresar a la Plataforma\n\n USUARIO: ".$_POST['usuario']." Y PASSWORD: ".$_POST['usuario']."\n\nEl documento se ha guardado con éxito");
										

									}
							
								else{echo json_encode("Las tablas o campos no coincien");}
						
								}
						
							else{echo json_encode("Sobrecarga en el documento intente subirlo de nuevo");}
					
								}	
								else{echo json_encode("Error al guardar los datos ".mysqli_error($link));}
			
							}//Pregunto si hay permisos para subir archivos
				
						else{
						
							echo json_encode("El administrador ha deshabilitado  la Plataforma para subir archivos");
						}
					}
					
			else{ echo json_encode("Ya hay una propuesta registrada para este usuario.");}
		}break;
	
	}
?>