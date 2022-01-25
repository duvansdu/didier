<?php
session_start();


function Directores($codigo, $link){
	
	$director=mysqli_query($link,"SELECT tb_director.id_director, tb_director.estado FROM pegasoun_proyecto.tb_director tb_director WHERE tb_director.id_usuario = '".$codigo."'");
  
  	$dir_inves=mysqli_query($link,"SELECT tb_director_investi.id_director_inves, tb_director_investi.estado
  FROM pegasoun_proyecto.tb_director_investi tb_director_investi WHERE tb_director_investi.id_usuario = '".$codigo."'");	
  
   $tutor=mysqli_query($link,"SELECT tb_tutor_externo.id_tutor_externo, tb_tutor_externo.estado
  FROM pegasoun_proyecto.tb_tutor_externo tb_tutor_externo WHERE tb_tutor_externo.id_usuario = '".$codigo."'");
  
 	
  
  if(mysqli_num_rows($director)>0){
	  
	  $option='
	  	<option value="1">Director</option>
		<option value="0">Selecione Director</option>
		<option value="2">Director de Investigación</option>
		<option value="3">Tutor Externo</option>';
		$estado=mysqli_fetch_assoc($director);
		$estados=estado_director($estado['estado']);
	  
	  }

  if(mysqli_num_rows($dir_inves)>0){
	  
	  $option='
	   <option value="2">Director de Investigación</option>
	   <option value="0">Selecione Director</option>
	  	<option value="1">Director</option>
		<option value="3">Tutor Externo</option>';
		
		$estado=mysqli_fetch_assoc($dir_inves);
		$estados=estado_director($estado['estado']);
	  
	  }
	  
  if(mysqli_num_rows($tutor)>0){
	  
	  $option='
	    <option value="3">Tutor Externo</option>
	    <option value="0">Selecione Director</option>
	  	<option value="1">Director</option>
		<option value="2">Director de Investigación</option>';
		$estado=mysqli_fetch_assoc($tutor);
		$estados=estado_director($estado['estado']);
	  }
	  
	if(mysqli_num_rows($tutor)==0 && mysqli_num_rows($dir_inves)==0 && mysqli_num_rows($director)==0){
		
	  $option='
	    <option value="0">Selecione Director</option>
	  	<option value="1">Director</option>
		<option value="2">Director de Investigación</option>
		<option value="3">Tutor Externo</option>';
		$estado=mysqli_fetch_assoc($director);
		$estados=estado_director(0);		
		
		}
		return'<tr>
			<td>Usuario</td>
			<td><select id="select_directores">'.$option.'</select></td>
		</tr>
								
							
		<tr>
			<td>Estado</td>
			<td>'.$estados.'</td>
		</tr>';
	}
	
function estado_director($estado){
	if($estado==1){
		$option='
	    <option value="1">Habilitado</option>
	  	<option value="0">Selecione Estado</option>
		<option value="2">Deshabilitado</option>';
		}
	if($estado==2){
		$option='
	    <option value="2">Deshabilitado</option>
	  	<option value="0">Selecione Estado</option>
		<option value="1">Habilitado</option>';
		
		}
		
	if($estado==0){
		
		$option='
	    <option value="0">Selecione Estado</option>
	  	<option value="1">Habilitado</option>
		<option value="2">Deshabilitado</option>';
		
		}
		
	return '<select id="estado_director">'.$option.'</select>';
	}

function permisos_subirarchivos($link){
	
	$fechas=mysqli_query($link,"SELECT tb_permiso_subir_archivo.fecha_inicio,
						   tb_permiso_subir_archivo.fecha_final,
						   tb_permiso_subir_archivo.id_permiso
							  FROM pegasoun_proyecto.tb_permiso_subir_archivo tb_permiso_subir_archivo
							 WHERE tb_permiso_subir_archivo.estado = 1
							ORDER BY tb_permiso_subir_archivo.fecha_final ASC");
					 
 
 			$html='<div><h2>Fechas programadas para subir archivos</h2></div>
								<div style="width:400px; margin:0 auto;">
									
									<table align="center">
										<tr>
											<th style="width:200px">Fecha Inicio</th>
											<th style="width:200px">Fecha Límite</th>
											<th style="width:100px">Deshabilitar</th>
										</tr>';
 			
			while($f=mysqli_fetch_array($fechas)){
				
				$fecha_inicio=explode('-',$f['fecha_inicio']);
				$mes=obtenerMes($fecha_inicio[1]);
				$fecha_inicio=$fecha_inicio[2].' de '. $mes.' '.$fecha_inicio[0]; 
				
				$fecha_limite=explode('-',$f['fecha_final']);
				$mes=obtenerMes($fecha_limite[1]);
				$fecha_limite=$fecha_limite[2].' de '. $mes.' '.$fecha_limite[0];
				
				$html.='<tr>
							<td align="center">'.$fecha_inicio.'</td>
							<td align="center">'.$fecha_limite.'</td>
							<td align="center"><button onClick="terminar('.$f['id_permiso'].')">Terminar</button></td>
					  </tr>';
				}
										
					$html.='</table>       
						</div>';
						
				return $html;
	}
	

function roles_docentes($Sql_tutor, $Sql_jurado, $codigo, $link){
				$val1="";
				$val2="";
	
				$tutor=mysqli_fetch_assoc($Sql_tutor);
				$jurado=mysqli_fetch_assoc($Sql_jurado);
				
				if($tutor['estado']==1){
					$estado_activo="Habilitado";
					$estado_inactivo="Deshabilitado";
					$value1=1;
					$value2=0;
					}


				else{
					$estado_activo="Deshabilitado"; 
					$estado_inactivo="Habilitado";
					$value1=0;
					$value2=1;}
					
				// estado para el jurado	
				if($jurado['estado']==1){
					$estado_activo1="Habilitado";
					$estado_inactivo1="Deshabilitado";
					$value11=1;
					$value22=0;
					}
					
					
				else{
					$estado_activo1="Deshabilitado"; 
					$estado_inactivo1="Habilitado";
					$value11=0;
					$value22=1;}
  
				
				$html_tutor='<div id="director_docente">
									<div class="titulos_roles" id="titulo_director">Tutor</div>
				<table border="0" align="center">
								<tr>
									<td>Usuario</td>
									<td><input type="text" id="usuario_tutor" value='.$tutor['usuario'].'></td>
								</tr>
								
								<tr>
									<td>Password</td>
									<td><input type="password" id="password_tutor"></td>
								</tr>
								
								<tr>
									<td>Estado</td>
									<td>
										<select id="estado_tutor">
											<option value="'.$value1.'">'.$estado_activo.'</option>
											<option value="'.$value2.'">'.$estado_inactivo.'</option>
										</select>
									</td>
								</tr>
								
								<tr>
									<td colspan="2" align="center"><button class="btn_actualizar" onClick="crear_tutor($(\'#usuario_tutor\').val(), $(\'#password_tutor\').val(), '.$codigo.', $(\'#estado_tutor\').val())">Modificar</button></td>
									
								</tr>
							</table>
							</div>';
							
				$html_jurado='<div id="jurado_docente">
									<div class="titulos_roles" id="titulo_jurdo">Jurado</div>
						<table border="0" align="center">
								<tr>
									<td>Usuario</td>
									<td><input type="text" id="usuario_jurado" value='.$jurado['usuario'].'></td>
								</tr>
								
								<tr>
									<td>Password</td>
									<td><input type="password" id="password_jurado"></td>
								</tr>
								
								<tr>
									<td>Estado</td>
									<td>
										<select id="estado_jurado">
											<option value="'.$value11.'">'.$estado_activo1.'</option>
											<option value="'.$value22.'">'.$estado_inactivo1.'</option>
										</select>
									</td>
								</tr>
								
								<tr>
									<td colspan="2" align="center"><button class="btn_actualizar" onClick="crear_jurado($(\'#usuario_jurado\').val(), $(\'#password_jurado\').val(), '.$codigo.', $(\'#estado_jurado\').val() )">Modificar</button></td>
									
								</tr>
							</table>
							</div>';
							
					$html_director='<div id="director_docente">
									<div class="titulos_roles" id="titulo_director">Directores</div>
				<table border="0" align="center">
								'.Directores($codigo, $link).'
								
								<tr>
									<td colspan="2" align="center"><button class="btn_actualizar" onClick="crear_director($(\'#select_directores\').val(), $(\'#estado_director\').val(), '.$codigo.')">Modificar</button></td>
									
								</tr>
							</table>
							</div>';
						
					return $html_director.' '.$html_tutor.' '.$html_jurado;
	
	}
	
function modificacion_docente($codigo, $docente){
	return '<div id="cuerpo_docente" style="margin-top:10px;">
    	<table border="0" align="center">
        	<tr class="tr_docente">
            	<td><label class="txt_docente">Código</label></td>
                <td><input class="input_docente" id="mo_codig" type="text" placeholder="Código" value="'.$codigo.'" /></td>
            </tr>
        	<tr class="tr_docente">
            	<td><label class="txt_docente">Nombre</label></td>
                <td><input class="input_docente" id="mo_nombre" type="text" placeholder="Nombre" value="'.$docente['nombre'].'"/></td>
            </tr>
        	<tr class="tr_docente">
            	<td> <label class="txt_docente">Apellido</label></td>
                <td><input class="input_docente" id="mo_apellido" type="text" placeholder="Apellido" value="'.$docente['apellido'].'"/></td>
            </tr>
        	<tr class="tr_docente">
            	<td><label class="txt_docente">Télefono</label></td>
                <td><input class="input_docente" id="mo_telefono" type="text" placeholder="Télefono" value="'.$docente['telefono'].'"/></td>
            </tr>
        	<tr class="tr_docente">
            	<td><label class="txt_docente">E-mail</label></td>
                <td><input class="input_docente" id="mo_correo" type="text" placeholder="E-mail" value="'.$docente['correo'].'"/></td>
            </tr>
        	
        	<tr class="tr_docente">
            	<td colspan="2"><label class="txt_docente">Especialidades</label></td>
            </tr>
            <tr class="tr_docente">
            	<td colspan="2"><textarea class="txarea_docente" id="mo_espeli">'.$docente['especialidad'].'</textarea></td>
            </tr>
            
            <tr class="tr_docente">
            	<td colspan="2" align="center"><button class="boton_docente" onClick="modificar_docente(\''.$codigo.'\')">Actualizar</button></td>
            </tr>
            </table>

    </div>';
	
	}
	
function asignar_comite($codigo, $link){
	$datosUsuario=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_comite.estado, tb_comite.usuario, tb_comite.id_comite FROM pegasoun_proyecto.tb_comite tb_comite WHERE tb_comite.id_usuario ='".$codigo."'"));
	
	$cargos=mysqli_query($link,"SELECT tb_cargo.id_cargo, tb_cargo.iniciales
  							FROM pegasoun_proyecto.tb_cargo tb_cargo");
							
	$cargo_usuario=mysqli_query($link,"SELECT tb_cargo.id_cargo, tb_cargo.iniciales
								  FROM    pegasoun_proyecto.tb_usuario_cargo tb_usuario_cargo
									   JOIN
										  pegasoun_proyecto.tb_cargo tb_cargo
									   ON (tb_usuario_cargo.id_cargo = tb_cargo.id_cargo)
								 WHERE tb_usuario_cargo.id_usuario = '".$codigo."'");
				 
				 
				 if(mysqli_num_rows($cargo_usuario)>0){
					 $cargo=mysqli_fetch_assoc($cargo_usuario);
					 $cargo_docente=$cargo['iniciales'];
					 $id_cargo=$cargo['id_cargo'];
					 }
				else{
							$cargo_docente="Elegir Cargo";
						 $id_cargo=0; }
				
				if($datosUsuario['estado']==1){
							$estado='Habilitado'; $estado1='Estado'; $estado2='Deshabilitado';
							$value=1; $value1=0; $value2=2;
							
							}
				if($datosUsuario['estado']==2){
							$estado='Deshabilitado'; $estado1='Estado'; $estado2='Habilitado';
							$value=2; $value1=0; $value2=1;
							}
				if($datosUsuario['estado']==""){
						$estado='Estado'; $estado1='Habilitado'; $estado2='Deshabilitado';
						$value=0; $value1=1; $value2=2;
					}
							
				$html='
						<table border="0" align="center">
							<tr>
								<td><label>Estado</label></td>
								<td>
									<select id="select">
										<option value="'.$value.'">'.$estado.'</option>
										<option value="'.$value1.'">'.$estado1.'</option>
										<option value="'.$value2.'">'.$estado2.'</option>
									</select>
								</td>
							</tr>
						
							
							<tr>
								<td><label>Usuario</label></td>
								<td><input type="text" value="'.$datosUsuario['usuario'].'" id="usuario"/></td>
							</tr>
							
							<tr>
								<td><label>Password</label></td>
								<td><input type="Password" id="password" /></td>
							</tr>
							
						   <tr>
								<td><label>Cargo</label></td>
								<td>
									<select id="select_cargo">
										<option value="'.$id_cargo.'">'.$cargo_docente.'</option>';
										while($f=mysqli_fetch_array($cargos)){
											$html.='<option value="'.$f['id_cargo'].'">'.$f['iniciales'].'</option>';
											
											}
										
				$html.='					</select>
								</td>
							</tr>
						
						</table>';
						
					
					$pro=mysqli_query($link,"SELECT tb_programa.id_programa,tb_programa.nombre								   
								  FROM pegasoun_proyecto.tb_programa tb_programa");
								  
					$i=1;
					$j=0;
					$programas='<table border="0" align="center" width="95%">';
					while($f=mysqli_fetch_array($pro)){
						
						$estado=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_comite_programa.estado
									  FROM pegasoun_proyecto.tb_comite_programa tb_comite_programa
										   INNER JOIN pegasoun_proyecto.tb_comite tb_comite
											  ON (tb_comite_programa.id_comite = tb_comite.id_comite)
									 WHERE     tb_comite.id_usuario = '$codigo'
										   AND tb_comite_programa.id_programa ='".$f['id_programa']."'"));
						
						if($i==1){
								$programas.='<tr>';
							}
							
						if($estado['estado']==1){$check='checked';}
						else{$check='';}
						
						$programas.='<td  align="center"><input type="checkbox" '.$check.' value="'.$f['id_programa'].'" id="check_'.$j.'"></td><td width="300px">'.$f['nombre'].'</td>';
							
						if($i==4){
								$programas.='</tr>';
								$i=0;
							}
							
						$i++;
						$j++;
						}
						
					$programas.='
							<tr>
								<td colspan="8" align="right" height="50"><button style="margin-right:10px" onclick="mostrar()">Agregar Programa</button></td>
							</tr>
							</table>';
					$html.='<div id="programas" style="margin-top:15px;">'.$programas.'</div>';
					
					$crear_programa='<div id="mostrar_prog" style="visibility:hidden">
						<table align="center">
							<tr>
								<td>Código</td>
								<td><input type="text" id="txt_codigo" ></td>
							</tr>
							
							<tr>
								<td>Nombre del Programa</td>
								<td><input type="text" id="txt_programa"><button onclick="btn_crear()">Crear</button></td>
							</tr>
						</table>
					</div>';
						
					return $html.$crear_programa.'<button style=" margin-top:15px" onclick="crear_usuario('.$j.','.$_POST['codigo'].')">Aceptar</button>';
	
	}
	

//Documentos del administrador: Propuestas, Proyectos, Informes
function estudent_cordina($propuesta, $titulo, $codigo_trabajo, $id_trabajo, $id_programa, $documento){
	
	return '<div style="border:0px solid #000; margin-bottom:20px">
						<table>
							<tr>
								<td><a href="'.$propuesta.'" target="_blank"><img src="../img/pdf_descarga.png" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>'.$documento.'</p></div>
								<div><button class="btn_propuestas" onClick="comite('.$id_trabajo.','.$id_programa.', 1)">Enviar al Comité</button><button class="btn_propuestas" onClick="crear_obser('.$id_trabajo.')">Crear Observaciones</button><button class="btn_propuestas" onClick="verObservaciones('.$id_trabajo.')">Ver Observaciones</button></div>
					
							</td>
							</tr>
						</table>
						
						<div class="div_textarea" id="div_'.$id_trabajo.'" ><textarea class="textarea" id="'.$id_trabajo.'" placeholder="Observacion de 1000 caracteres" maxlength="1000" onKeyPress="detener(event,'.$id_trabajo.')" onKeyDown="tecla(event,'.$id_trabajo.')"></textarea>
						<button class="btn_propuestas" onClick="rechazar_propuesta('.$id_trabajo.', 3)">Rechazar</button>
						<button class="btn_propuestas" onClick="rechazar_propuesta('.$id_trabajo.', 1)">Corregir</button>
						</div>
				
			</div>';
	}
	
	
function comite_cordinador($propuesta, $codigo_trabajo, $titulo, $id_trabajo, $documento, $id_modalidad, $link){
	$html='';
	if($id_modalidad==1 || $id_modalidad==4){
		$html='<select class="selec_jurado" style="width:270px" id="selec_director_'.$id_trabajo.'">
							
					    	'.Director($id_trabajo, $link).'
					</select>';

					}
					
					
	if($id_modalidad==2){
		$html='<select class="selec_jurado" id="select_tutor1_'.$id_trabajo.'">
							<option value="0">Tutor Interno</option>
					    	'.tutor_interno($link).'
					</select>
							
					<select class="selec_jurado" id="select_tutor2_'.$id_trabajo.'">
					 		<option value="0">Tutor Externo</option>
							'.tutor_externo($link).'
					</select>';
		}
		
	if($id_modalidad==3 || $id_modalidad==5){
		$html='<select class="selec_jurado" style="width:270px" id="selec_director_'.$id_trabajo.'">
							
					    	'.Director_investi($id_trabajo, $link).'
					</select>';
		
		}
	
	return '<div style="border:0px solid #000">
						<table>
							<tr>
								<td><a href="'.$propuesta.'" target="_blank"><img src="../img/pdf_descarga.png" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>'.$documento.'</p></div>
								
								<div class="btn_botones"  id="btn_'.$id_trabajo.'"><button  class="btn_propuestas" onClick="estado_aprobado(1,'.$id_trabajo.', \''.$codigo_trabajo.'\', '.$id_modalidad.')">Aprobar</button><button class="btn_propuestas" onClick="estado_documento(2, '.$id_trabajo.', 1)">Aplazar</button><button class="btn_propuestas"  onClick="estado_documento(3, '.$id_trabajo.', 1)">Rechazar</button></div>
								
								<div class="mtm_observacio">
									<button class="btn_propuestas" id="observ_'.$id_trabajo.'"  onClick="verObservaciones('.$id_trabajo.')">Observaciones</button>
								
								<div>'.$html.'
								
									<label class="codi_rad">Código Radicación</label><input type="text" class="radicacion" id="codigo_radi_'.$id_trabajo.'" >
								</div>
					
							</td>
							</tr>
						</table>
						
						<div  id="div_'.$id_trabajo.'" >
						<button class="btn_carta" onclick="cargar_carta('.$id_trabajo.')">Conceptos</button><input type="text" class="input_carta" id="carta_'.$id_trabajo.'">
						</div>
			</div>';
	
	}
	
function tutor_interno($link){
	
	$tutores=mysqli_query($link,"SELECT tb_usuario.id_usuario, CONCAT(tb_usuario.nombre,' ',tb_usuario.apellido) AS nombres
				  FROM    pegasoun_proyecto.tb_tutor_interno tb_tutor_interno
					   JOIN
						  pegasoun_proyecto.tb_usuario tb_usuario
					   ON (tb_tutor_interno.id_usuario = tb_usuario.id_usuario)
				 WHERE tb_tutor_interno.estado = '1'");
	
	$option='';
				 
	while($f=mysqli_fetch_array($tutores)){
		
		$option.='<option value="'.$f['id_usuario'].'">'.$f['nombres'].'</option>';		
		
		}
		
	return $option;
	
	}
	
function tutor_externo($link){
	
	$tutores=mysqli_query($link,"SELECT tb_usuario.id_usuario, CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombres
						  FROM    pegasoun_proyecto.tb_tutor_externo tb_tutor_externo
							   JOIN
								  pegasoun_proyecto.tb_usuario tb_usuario
							   ON (tb_tutor_externo.id_usuario = tb_usuario.id_usuario)
						 WHERE tb_tutor_externo.estado = '1'");
	
	$option='';
				 
	while($f=mysqli_fetch_array($tutores)){
		
		$option.='<option value="'.$f['id_usuario'].'">'.$f['nombres'].'</option>';		
		
		}
		
	return $option;
	
	}
	
function Director($id_trabajo, $link){
	$existe=mysqli_query($link,"SELECT tb_usuario.id_usuario, CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombres
						  FROM pegasoun_proyecto.`tb_trabajo tb_director` `tb_trabajo tb_director`
							   CROSS JOIN pegasoun_proyecto.tb_director tb_director
							   JOIN pegasoun_proyecto.tb_usuario tb_usuario
								  ON (tb_director.id_usuario = tb_usuario.id_usuario)
						 WHERE     `tb_trabajo tb_director`.id_director = tb_director.id_director
							   AND `tb_trabajo tb_director`.id_trabajo = '".$id_trabajo."'");
	
	$director=mysqli_query($link,"SELECT tb_director.id_director, CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombres FROM pegasoun_proyecto.tb_director tb_director
	       JOIN
          		pegasoun_proyecto.tb_usuario tb_usuario
       	   ON (tb_director.id_usuario = tb_usuario.id_usuario)
 			WHERE tb_director.estado = 1");
							 
	
	
	if(mysqli_num_rows($existe)>0){
		
		$director_proy=mysqli_fetch_assoc($existe);
		$option='<option value="'.$director_proy['id_usuario'].'">'.$director_proy['nombres'].'</option>';
		
		}
		
  else{$option='<option value="0">Director</option>';}
							 
   
				 
	while($f=mysqli_fetch_array($director)){
		
		$option.='<option value="'.$f['id_director'].'">'.$f['nombres'].'</option>';		
		
		}
		
	return $option;
	
	}
	
function Director_investi($id_trabajo, $link){
	$existe=mysqli_query($link,"SELECT tb_usuario.id_usuario, CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombres
						  FROM    (   pegasoun_proyecto.tb_director_investi tb_director_investi
								   JOIN
									  pegasoun_proyecto.tb_usuario tb_usuario
								   ON (tb_director_investi.id_usuario = tb_usuario.id_usuario))
							   JOIN
								  pegasoun_proyecto.tb_dir_trabajo tb_dir_trabajo
							   ON (tb_dir_trabajo.id_director_inves =
									  tb_director_investi.id_director_inves)
						 WHERE tb_dir_trabajo.id_trabajo =  '".$id_trabajo."'");
	
	$director_inves=mysqli_query($link,"SELECT tb_usuario.id_usuario, CONCAT(tb_usuario.nombre,' ',tb_usuario.apellido) AS nombres
									  FROM    pegasoun_proyecto.tb_director_investi tb_director_investi
										   JOIN
											  pegasoun_proyecto.tb_usuario tb_usuario
										   ON (tb_director_investi.id_usuario = tb_usuario.id_usuario)
									 WHERE tb_director_investi.estado = '1'");
																 
	
	
	if(mysqli_num_rows($existe)>0){
		
		$director_proy=mysqli_fetch_assoc($existe);
		$option='<option value="'.$director_proy['id_usuario'].'">'.$director_proy['nombres'].'</option>';
		
		}
		
  else{$option='<option value="0">Director de Investigación</option>';}
							 
   
				 
	while($f=mysqli_fetch_array($director_inves)){
		
		$option.='<option value="'.$f['id_usuario'].'">'.$f['nombres'].'</option>';		
		
		}
		
	return $option;
	
	}
?>