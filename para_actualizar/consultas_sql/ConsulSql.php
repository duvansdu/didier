<?php
include "../connections/conection.php";
include "formularios.php";
$opcion=$_POST['opcion'];
$html="";
switch($opcion){
	
	case 1:{//Buscamos Docentes para darles roles o modificarlos
				$docente=$_POST['docente'];
				$j=$_POST['color'];
			
				$cosul=mysqli_query($link,"SELECT tb_usuario.id_usuario, CONCAT(tb_usuario.nombre,' ',tb_usuario.apellido) AS nombre FROM pegasoun_proyecto.tb_usuario tb_usuario WHERE tb_usuario.id_perfil = 1 AND (nombre LIKE '%".$docente."%' OR apellido LIKE '%".$docente."%') LIMIT 0 , 3");
				
				$html='<div id="docente_docente" style="margin-bottom:10px">
							<div class="titulos_roles" id="titulo_docente" style="background:#0000; background:#06F">Docente</div>
				<table border="1" align="center" width="100%" cellspacing="0" style="border:0px;">';
				$i=1;	
				while($f=mysqli_fetch_array($cosul)){
						$id_docente=$f['id_usuario'];
						$html.='<tr bgcolor="#FFFFFF">
									<td onclick="colorear'.$j.'('.$i.', '.$id_docente.')"  id="td_'.$j.'_'.$i.'" style="cursor:pointer">'.$f['nombre'].'</td>
								</tr>';
						$i++;
					}
					$html.='</table></div>';
					echo $html;
		
		
		}break;
		
	case 2:{//Consultamos los roles de los docentes si no tienen se les asignan
				$codigo=$_POST['codigo'];
				
				$Sql_director=mysqli_query($link,'SELECT tb_director.estado, tb_director.id_usuario, tb_director.usuario, tb_director.password  FROM pegasoun_proyecto.tb_director tb_director WHERE tb_director.id_usuario = "'.$codigo.'" AND tb_director.estado=1 ');
				
				$Sql_jurado=mysqli_query($link,'SELECT tb_jurado.estado,tb_jurado.id_usuario, tb_jurado.usuario, tb_jurado.password  FROM pegasoun_proyecto.tb_jurado tb_jurado WHERE tb_jurado.id_usuario = "'.$codigo.'" And tb_jurado.estado=1 ');
				
				$Sql_tutor=mysqli_query($link,'SELECT tb_tutor_interno.estado, tb_tutor_interno.id_usuario, tb_tutor_interno.usuario, tb_tutor_interno.password FROM pegasoun_proyecto.tb_tutor_interno tb_tutor_interno
 WHERE     tb_tutor_interno.id_usuario = "'.$codigo.'" AND tb_tutor_interno.estado = 1');
				
				echo roles_docentes($Sql_tutor, $Sql_jurado, $codigo, $link);
		
		}break;
		
	case 3:{//Consultamos y mostramos el Docente a modificar
				$codigo=$_POST['codigo'];
				$docente=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_usuario.nombre,
       tb_usuario.apellido,
       tb_usuario.telefono,
       tb_usuario.correo,
       tb_especialidad.especialidad
  FROM pegasoun_proyecto.tb_especialidad tb_especialidad
       INNER JOIN pegasoun_proyecto.tb_usuario tb_usuario
          ON (tb_especialidad.id_usuario = tb_usuario.id_usuario)
 WHERE tb_usuario.id_usuario = '$codigo'"));
		
			echo modificacion_docente($codigo, $docente);
		}break;
		
	case 4:{//Buscamos Docentes para miembros del comite
			$SQL=mysqli_query($link,"SELECT tb_usuario.id_usuario, CONCAT(tb_usuario.nombre,' ',tb_usuario.apellido) AS nombre FROM pegasoun_proyecto.tb_usuario tb_usuario WHERE tb_usuario.id_perfil = 1 AND  tb_usuario.nombre LIKE '%".$_POST['string']."%' OR tb_usuario.apellido LIKE '%".$_POST['string']."%' LIMIT 0 , 3");


				 $html='<div id="docente_docente" style="margin-bottom:10px; margin:0 auto">
							<div class="titulos_roles" id="titulo_docente" style="background:#0000; background:#06F">Docente</div>
				<table border="1" align="center" width="100%" cellspacing="0" style="border:0px;">';
				$i=1;	
 				$datos='';
 			
				while($f=mysqli_fetch_array($SQL)){
					
					$html.='<tr bgcolor="#FFFFFF">
									<td onclick="coloreando1('.$i.', '.$f['id_usuario'].')" id="td_1_'.$i.'" style="cursor:pointer">'.$f['nombre'].'</td>
								</tr>';
								
								$i++;
					}
					$html.='</table></div>';
					echo $html;
		
		
		}break;
		
	case 5:{
			 $codigo=$_POST['codigo'];
			 
			 echo asignar_comite($codigo, $link);
		
		
		}break;

	case 6:{
				$id_usuario=$_POST['id_usuario'];

				$datos=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_usuario.correo, tb_usuario.telefono
							  FROM pegasoun_proyecto.tb_usuario tb_usuario
							 WHERE tb_usuario.id_usuario = '".$id_usuario."'"));	

				echo json_encode(array("correo"=>$datos['correo'], "telefono"=>$datos['telefono']));	
		}break;
		
	case 7:{
				$id_docente=$_POST['id_docente'];
				
				$datos_docente=mysqli_query($link,"SELECT tb_usuario.nombre, tb_usuario.apellido
  FROM pegasoun_proyecto.tb_administrador tb_administrador
       INNER JOIN pegasoun_proyecto.tb_usuario tb_usuario
          ON (tb_administrador.id_usuario = tb_usuario.id_usuario)
 WHERE tb_administrador.id_usuario = '".$id_docente."'");
 
 				$datos_docente3=mysqli_query($link,"SELECT tb_usuario.nombre, tb_usuario.apellido
  FROM pegasoun_proyecto.tb_usuario tb_usuario
 WHERE tb_usuario.id_usuario ='".$id_docente."'");
							 
				
				if(mysqli_num_rows($datos_docente)>0){
					$datos_docente2=mysqli_fetch_assoc($datos_docente);
					echo json_encode(array('datos'=>1,'nombre'=>$datos_docente2['nombre'], 'apellido'=>$datos_docente2['apellido']));
					}
				else{
						if(mysqli_num_rows($datos_docente3)>0){
							$datos_docente2=mysqli_fetch_assoc($datos_docente3);
					echo json_encode(array('datos'=>2,'nombre'=>$datos_docente2['nombre'], 'apellido'=>$datos_docente2['apellido']));
							
							}
						
						else{echo json_encode(array('datos'=>0));}
					
					}
							 
				
		
		}break;
		
	case 8:{
			$id_documento=$_POST['id_documento'];
			
			$integrantes=mysqli_query($link,"SELECT tb_usuario.id_usuario,
									   tb_usuario.nombre,
									   tb_usuario.apellido,
									   tb_usuario.telefono,
									   tb_usuario.correo
								  FROM pegasoun_proyecto.tb_usuario tb_usuario
									   CROSS JOIN
									   pegasoun_proyecto.`tb_trabajo tb_estudiante` tb_trabajo_tb_estudiante
									   INNER JOIN pegasoun_proyecto.tb_trabajo tb_trabajo
										  ON (tb_trabajo_tb_estudiante.id_trabajo = tb_trabajo.id_trabajo)
								 WHERE     tb_usuario.id_usuario = tb_trabajo_tb_estudiante.id_usuario
									   AND tb_trabajo.id_trabajo = '$id_documento'");
									   
		
		$html.='<table align="center" border="0">';
		$i=1;
		while($f=mysqli_fetch_array($integrantes)){
			
			$html.='<tr>
						<td><label>Código</label></td>
						<td><input type="text" id="CODEstu_'.$i.'" style="width:200px; height:35px; border-radius:5px;border:1px solid #000;  font-size:20px" value="'.$f['id_usuario'].'" readonly></td>
					</tr>
						
				    <tr>
					    <td><label>Nombre</label></td>
						<td><input type="text" id="NEs_'.$i.'" style="width:200px; height:35px; border-radius:5px;border:1px solid #000;  font-size:20px" value="'.$f['nombre'].'"></td>
					</tr>
					
					<tr>
					    <td><label>Apellido</label></td>
						<td><input type="text" id="AEs_'.$i.'" style="width:200px; height:35px; border-radius:5px;border:1px solid #000;  font-size:20px" value="'.$f['apellido'].'"></td>
					</tr>
					
					<tr>
					    <td><label>Teléfono</label></td>
						<td><input type="text" id="TEs_'.$i.'" style="width:200px; height:35px; border-radius:5px;border:1px solid #000;  font-size:20px" value="'.$f['telefono'].'"></td>
					</tr>
					
					<tr>
					    <td><label>Correo</label></td>
						<td><input type="text" id="CEs_'.$i.'" style="width:200px; height:35px; border-radius:5px;border:1px solid #000;  font-size:20px" value="'.$f['correo'].'"></td>
					</tr>
					
					<tr>
					    <td align="center" colspan="2"><button class="btn_anuncio"  onClick="ActualizarEstuden('.$i.')" style="margin-bottom:15px;">Actualizar</button></td>
					</tr>';
					$i++;
			
			}
			
			echo $html.'</table>';
										
		}break;
		
	case 9:{
			$id_tutor=$_POST['id_tutor'];
			
			$tutor=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_usuario.id_usuario,
							   tb_usuario.nombre,
							   tb_usuario.apellido,
							   tb_usuario.telefono,
							   tb_usuario.correo,
							   tb_tutor_interno.usuario,
							   tb_especialidad.especialidad
						  FROM (pegasoun_proyecto.tb_tutor_interno tb_tutor_interno
								INNER JOIN pegasoun_proyecto.tb_usuario tb_usuario
								   ON (tb_tutor_interno.id_usuario = tb_usuario.id_usuario))
							   INNER JOIN pegasoun_proyecto.tb_especialidad tb_especialidad
								  ON (tb_especialidad.id_usuario = tb_usuario.id_usuario)
						 WHERE tb_usuario.id_usuario = '$id_tutor'"));
									   
	
		$html.='<table align="center" border="0" style="width:50%; margin-top:20px;">';
		
			
			$html.='<tr>
						<td><label>Cédula</label></td>
						<td><input type="text" id="cedTutor" style="width:200px; height:35px; border-radius:5px;border:1px solid #000;  font-size:20px" value="'.$tutor['id_usuario'].'" readonly></td>
					</tr>
						
				    <tr>
					    <td><label>Nombre</label></td>
						<td><input type="text" id="NTutor" style="width:200px; height:35px; border-radius:5px;border:1px solid #000;  font-size:20px" value="'.$tutor['nombre'].'"></td>
					</tr>
					
					<tr>
					    <td><label>Apellido</label></td>
						<td><input type="text" id="ATutor" style="width:200px; height:35px; border-radius:5px;border:1px solid #000;  font-size:20px" value="'.$tutor['apellido'].'"></td>
					</tr>
					
					<tr>
					    <td><label>Teléfono</label></td>
						<td><input type="text" id="TTutor" style="width:200px; height:35px; border-radius:5px;border:1px solid #000;  font-size:20px" value="'.$tutor['telefono'].'"></td>
					</tr>
					
					<tr>
					    <td><label>Correo</label></td>
						<td><input type="text" id="CTutor" style="width:200px; height:35px; border-radius:5px;border:1px solid #000;  font-size:20px" value="'.$tutor['correo'].'"></td>
					</tr>
					
					<tr>
					    <td><label>Epecialidad</label></td>
						<td><textarea type="text" id="ETutor" style="width:400px; height:100px; border-radius:5px;border:1px solid #000;  font-size:20px">'.$tutor['especialidad'].'</textarea></td>
					</tr>
					
					<tr>
					    <td align="center" colspan="2"><button class="btn_propuestas"  onClick="ActualizarTutor('.$id_tutor.')" style="margin-bottom:15px;">Actualizar</button></td>
					</tr></table>';
			echo $html;
		
		
		}break;
	
	}
?>
