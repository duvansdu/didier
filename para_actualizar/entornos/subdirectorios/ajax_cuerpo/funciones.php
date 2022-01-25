<?php
//consultas aparte


function SqlJurados($link){
	return mysqli_query($link,"SELECT CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombres, tb_jurado.id_jurado
  FROM    pegasoun_proyecto.tb_jurado tb_jurado
       JOIN
          pegasoun_proyecto.tb_usuario tb_usuario
       ON (tb_jurado.id_usuario = tb_usuario.id_usuario)
 WHERE tb_jurado.estado = '1'");
	
	}


function jurados($id_trabajo, $i, $link){
	$SQL_Jurados=SqlJurados($link);
	
	$jurados='<select class="selec_jurado" id="jurado_'.$i.'_'.$id_trabajo.'">
		<option value="0">Jurado</option>';
		
	while($f=mysqli_fetch_array($SQL_Jurados)){
		$jurados.='<option value="'.$f['id_jurado'].'">'.$f['nombres'].'</option>';
		
		}
		
		$jurados.='</select>';
		
	return $jurados;
	}
	

	

	
function jurados2($id_trabajo, $i, $j){
	
	$SQL_Jurados=SqlJurados($link);
	$sql_jurados=mysqli_query($link,"SELECT tb_jurado.id_jurado, CONCAT(tb_usuario.nombre,' ', 				tb_usuario.apellido) AS nombres
					  FROM pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
						   CROSS JOIN pegasoun_proyecto.tb_jurado tb_jurado
						   JOIN pegasoun_proyecto.tb_usuario tb_usuario
							  ON (tb_jurado.id_usuario = tb_usuario.id_usuario)
					 WHERE     tb_jurado.id_jurado = `tb_trabajo tb_jurado`.id_jurado
						   AND tb_jurado.estado = '1'
						   AND `tb_trabajo tb_jurado`.id_trabajo =  '".$id_trabajo."'");
	
	if($j==1){
				
				if(mysqli_num_rows($sql_jurados)>0){
					$jurado=mysqli_fetch_assoc($sql_jurados);
						   
					$nombre=$jurado['nombres'];
					$id_jurado=$jurado['id_jurado'];
					}
				else{
						$nombre='Jurado';
						$id_jurado=0;
					
					}
		
		
		}
		
	else{
			if(mysqli_num_rows($sql_jurados)>0){
				
				while($g=mysqli_fetch_array($sql_jurados)){
					$nombre=$g['nombres'];
					$id_jurado=$g['id_jurado'];
				
				 }
					
					}
			else{
						$nombre='Jurado';
						$id_jurado=0;
					
					}
		}
	
	$jurados='<select class="selec_jurado" id="jurado_'.$i.'_'.$id_trabajo.'">
		<option value="'.$id_jurado.'">'.$nombre.'</option>';
		
	while($f=mysqli_fetch_array($SQL_Jurados)){
		$jurados.='<option value="'.$f['id_jurado'].'">'.$f['nombres'].'</option>';
		
		}
		
		$jurados.='</select>';
		
	return $jurados;
	
	}
	
function existe_jurado($id_documento, $link){
		
		$jurados_documento=mysqli_query($link,"SELECT `tb_trabajo tb_jurado`.id_jurado
					  FROM pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
					 WHERE `tb_trabajo tb_jurado`.id_trabajo = '".$id_documento."' ");
	
		if(mysqli_num_rows($jurados_documento)>0){return true;}
		else{return false;}
	
	
	}
	

//funciones con los documentos

function student_cordinador($anteproyecto, $codigo_trabajo, $titulo, $id_trabajo, $id_programa){
	
	return '<div style="border:0px solid #000">
						<table>
							<tr>
								<td><a href="'.$anteproyecto.'" target="_blank"><img src="../img/pdf_descarga.png" width="140" height="150"></a></td>
							
							<td>
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Proyecto</p></div>
								<div><button class="btn_propuestas" onClick="comite('.$id_trabajo.','.$id_programa.', 2)">Enviar al Comité</button><button class="btn_propuestas" onClick="crear_obser('.$id_trabajo.')">Crear Observaciones</button><button class="btn_propuestas" onClick="verObservaciones('.$id_trabajo.')">Ver Observaciones</button></div>
					
							</td>
							</tr>
						</table>
						
						<div class="div_textarea" id="div_'.$id_trabajo.'" ><textarea class="textarea" id="'.$id_trabajo.'" placeholder="Observacion de 1000 caracteres" maxlength="1000" onKeyPress="detener(event,'.$id_trabajo.')" onKeyDown="tecla(event,'.$id_trabajo.')"></textarea>

						<button class="btn_propuestas" onClick="rechazar_propuesta('.$id_trabajo.', 2)">Corregir</button>
						</div>
				
			</div>';
	}
	
	
function jurado_cordinador($anteproyecto, $codigo_trabajo, $titulo, $id_trabajo, $id_programa){
	
	return '<div style="border:0px solid #000; margin-bottom:25px;">
						<table>
							<tr>
								<td><a href="'.$anteproyecto.'" target="_blank"><img src="../img/pdf_descarga.png" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Proyecto</p></div>
								
								<div class="btn_botones" id="btn_'.$id_trabajo.'">
								<button class="btn_propuestas" onClick="corregir_proyec_jurado('.$id_trabajo.', \''.$codigo_trabajo.'\')">Revisado por Jurado</button>
								
								
								<button class="btn_propuestas" onClick="aprobado_jurado('.$id_trabajo.', \''.$codigo_trabajo.'\')">Aprobado por Jurado</button>			
								</div>
								<div class="mtm_observacio" id="obser2_'.$id_trabajo.'">
								<button class="btn_propuestas" onClick="verObservaciones_jura('.$id_trabajo.')">Observaciones Jurado</button>
								</div>
							</div>
							</td>
							</tr>
						</table>
						
						<div  id="div_'.$id_trabajo.'" >
						<button class="btn_carta" onclick="cargar_carta('.$id_trabajo.')">Cargar Carta</button><input type="text" class="input_carta" id="carta_'.$id_trabajo.'">
							
						</div>
			</div>';
	}
	
function student_jurado($anteproyecto, $codigo_trabajo, $titulo, $id_trabajo, $recetor){
	
	$button='';
	$cargar_doc='';
	
	if($recetor==3){
		$button='<button  class="btn_propuestas" onClick="corregir_proyec(4,'.$id_trabajo.')">Revisado</button>';
		$cargar_doc='<div  id="div_'.$id_trabajo.'" style="margin-bottom:20px;" >
						<button class="btn_carta" onclick="cargar_carta('.$id_trabajo.')">Conceptos</button><input type="text" class="input_carta" id="carta_'.$id_trabajo.'">
						</div>';}
	
	$html='<div style="border:0px solid #000">
						<table>
							<tr>
								<td><a href="'.$anteproyecto.'" target="_blank"><img src="../img/pdf_descarga.png" width="140" height="150"></a></td>
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Proyecto</p></div>
								
								<div  id="btn_'.$id_trabajo.'">'.$button.'<button  class="btn_propuestas" onClick="enviar_jurado('.$id_trabajo.', '.$recetor.')">Enviar a Jurado</button></div>
								
								<div id="div_jurado">';
								if(existe_jurado($id_trabajo, $link)){$html.=jurados2($id_trabajo, 1, 1); $html.=jurados2($id_trabajo, 2, 2);}
								else{$html.=jurados($id_trabajo, 1, $link); $html.=jurados($id_trabajo, 2, $link);}
									
									
							 $html.='</div>
				  
						  </td>
						  </tr>
					  </table>';
					  
					 $html.=$cargar_doc.'</div>';
		  
	return $html;
	
	
	}


function informes_student_cordina($informe_final, $codigo_trabajo, $titulo, $id_trabajo){
		
		return '<div style="border:0px solid #000; margin-bottom:20px;">
						<table>
							<tr>
								<td><a href="'.$informe_final.'"><img src="../img/word.jpg" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Informe Final</p></div>
								<div><button class="btn_propuestas" onClick="jurado('.$id_trabajo.')">Enviar al &nbsp; Jurado</button> <button class="btn_propuestas" onClick="devolver_info('.$id_trabajo.')">Devolver Informe</button> </div>
								
							</td>
							</tr>
						</table>
						
						<div  id="div_'.$id_trabajo.'" ><textarea class="textarea" id="'.$id_trabajo.'" placeholder="Observacion de 1000 caracteres" maxlength="1000" onKeyPress="detener(event,'.$id_trabajo.')" onKeyDown="tecla(event,'.$id_trabajo.')"></textarea>
						</div>
			</div>';
	
	
	
	}
	
function informes_student_cordina3($informe_final, $codigo_trabajo, $titulo, $id_trabajo){
		
		return '<div style="border:0px solid #000; margin-bottom:20px;">
						<table>
							<tr>
								<td><a href="'.$informe_final.'"><img src="../img/word.jpg" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Informe Final</p></div>
								<div><button class="btn_propuestas" onClick="enviar_comite('.$id_trabajo.')">Enviar al Comité</button> <button class="btn_propuestas" onClick="devolver_info_pract('.$id_trabajo.', 2)">Devolver Informe</button> </div>
								
							</td>
							</tr>
						</table>
						
						<div  id="div_'.$id_trabajo.'" ><textarea class="textarea" id="'.$id_trabajo.'" placeholder="Observacion de 1000 caracteres" maxlength="1000" onKeyPress="detener(event,'.$id_trabajo.')" onKeyDown="tecla(event,'.$id_trabajo.')"></textarea>
						</div>
			</div>';
	
	
	
	}
	
function informes_student_cordina2($informe_final, $codigo_trabajo, $titulo, $id_trabajo){
		
		return '<div style="border:0px solid #000; margin-bottom:20px;">
						<table>
							<tr>
								<td><a href="'.$informe_final.'"><img src="../img/word.jpg" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Informe Final</p></div>
								<div><button class="btn_propuestas" onClick="Aprobar_info('.$id_trabajo.')">Aprobar Informe</button> <button class="btn_propuestas" onClick="devolver_info('.$id_trabajo.')">Devolver Informe</button> </div>
								
							</td>
							</tr>
						</table>
						
						<div  id="div_'.$id_trabajo.'" ><textarea class="textarea" id="'.$id_trabajo.'" placeholder="Observacion de 1000 caracteres" maxlength="1000" onKeyPress="detener(event,'.$id_trabajo.')" onKeyDown="tecla(event,'.$id_trabajo.')"></textarea>
						</div>
			</div>';
	
	
	
	}
	
function informes_Avance_student_cordina($informe_final, $codigo_trabajo, $titulo, $id_trabajo){
	
	return '<div style="border:0px solid #000;  margin-bottom:20px;">
						<table>
							<tr>
								<td><a href="'.$informe_final.'"><img src="../img/word.jpg" width="140" height="150"></a></td>
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Informe Final</p></div>
								<div><button class="btn_propuestas" onClick="enviar_tutor('.$id_trabajo.')">Enviar Tutor</button> <button class="btn_propuestas" onClick="devolver_info_pract('.$id_trabajo.', 2)">Devolver</button> </div>
								
							</td>
							</tr>
						</table>
						
						<div  id="div_'.$id_trabajo.'" ><textarea class="textarea" id="'.$id_trabajo.'" placeholder="Observacion de 1000 caracteres" maxlength="1000" onKeyPress="detener(event,'.$id_trabajo.')" onKeyDown="tecla(event,'.$id_trabajo.')"></textarea>
						</div>
			</div>';
	
	
	}
	
function informes_jurado_cordina($informe_final, $codigo_trabajo, $titulo, $id_trabajo){
	
	return '<div style="border:0px solid #000; margin-bottom:20px;">
						<table>
							<tr>
								<td><a href="'.$informe_final.'" target="_blank"><img src="../img/word.jpg" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Informe Final</p></div>
								<div><button class="btn_propuestas" onClick="info_aprobado('.$id_trabajo.', \''.$codigo_trabajo.'\')">Aprobado</button><button class="btn_propuestas" onClick="corregir_info('.$id_trabajo.', \''.$codigo_trabajo.'\')">Corregir</button><button class="btn_propuestas" id="observ_'.$id_trabajo.'"  onClick="verObservaciones_jura2('.$id_trabajo.')">Observaciones</button></div>
								
								
							</td>
							</tr>
						</table>
						
						<div  id="div_'.$id_trabajo.'" >
						<button class="btn_carta" onclick="cargar_carta('.$id_trabajo.')">Cargar Carta</button><input type="text" class="input_carta" id="carta_'.$id_trabajo.'">
							
						</div>
			</div>';
	
	}
	
function informes_comite_cordina($informe_final, $codigo_trabajo, $titulo, $id_trabajo){
	
	return '<div style="border:0px solid #000; margin-bottom:20px;">
						<table>
							<tr>
								<td><a href="'.$informe_final.'" ><img src="../img/word.jpg" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Informe Final</p></div>
								<div><button class="btn_propuestas" onClick="enviar_carta('.$id_trabajo.', \''.$codigo_trabajo.'\')">Aprobado</button><button class="btn_propuestas" onClick="corregir_info_desa('.$id_trabajo.')">Corregir</button><button class="btn_propuestas" id="observ_'.$id_trabajo.'"  onClick="verObservaciones_comite('.$id_trabajo.')">Observaciones</button></div>
								
								
							</td>
							</tr>
						</table>
						
						<div  id="div_'.$id_trabajo.'" >
						<button class="btn_carta" onclick="cargar_carta('.$id_trabajo.')">Cargar Carta</button><input type="text" class="input_carta" id="carta_'.$id_trabajo.'">
							
						</div>
			</div>';
	
	}
	
function informes_tutor_cordina($informe_final, $codigo_trabajo, $titulo, $id_trabajo){

return '<div style="border:0px solid #000; margin-bottom:20px;">
						<table class="tablaTutor">
							<tr>
								<td><a href="'.$informe_final.'"><img src="../img/word.jpg" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Informe Final</p></div>
								<div><button class="btn_propuestas" onClick="enviar_carta_info_avance('.$id_trabajo.')">Revisado</button><button class="btn_propuestas" onClick="corregir_info_tutor('.$id_trabajo.')">Corregir</button><button class="btn_propuestas" id="observ_'.$id_trabajo.'"  onClick="observa_tutor('.$id_trabajo.')">Observaciones</button></div>
								
								
							</td>
							</tr>
						</table>
						
						<div  id="div_'.$id_trabajo.'" >
						<button class="btn_carta" onclick="cargar_carta('.$id_trabajo.')">Conceptos</button><input type="text" class="input_carta" id="carta_'.$id_trabajo.'">
							
						</div>
			</div>';
	
	}
	
function informes_cordi_tutor($id_trabajo, $ruta, $codigo_trabajo, $titulo, $documento, $id_tutor){
return '<div style="border:0px solid #000">
						<table class="table">
											<tr>
												<td><a href="'.$ruta.'"><img src="../img/word.jpg" width="140" height="150"></a></td>
											
											
											<td>
											
												<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
												<div class="cuerpo_proyecto">'.$titulo.'<p class="p">'.$documento.'</p></div>
												<div><button class="btn_propuestas" onClick="crear_obser('.$id_trabajo.')" >Crear Observación</button><button class="btn_propuestas" onClick="envio_coordinador('.$id_trabajo.', '.$id_tutor.')">Enviar Observación</button><button class="btn_propuestas" onClick="verObservaciones('.$id_trabajo.')">Ver Observación</button></div>							
											</td>
											</tr>
										</table>
									<div class="div_textarea" id="div_'.$id_trabajo.'" >
									
									<textarea class="textarea" id="'.$id_trabajo.'" placeholder="Observacion de 1000 caracteres" maxlength="1000" onKeyPress="detener(event, '.$id_trabajo.')" onKeyDown="tecla(event,'.$id_trabajo.')"></textarea>
									
									<button class="btn_carta" onclick="cargar_carta('.$id_trabajo.')">Documento</button><input type="text" class="input_carta" id="carta_'.$id_trabajo.'">
									</div>
									
										
								</div>';	
	
	}


//funciones aparte

function comite_cordinador($anteproyecto, $codigo_trabajo, $titulo, $id_trabajo, $recetor, $link){
	$button='';
	$cargar_doc='';
	
	if($recetor==3){
		$button='<button  class="btn_propuestas" onClick="corregir_proyec(4,'.$id_trabajo.',\''.$codigo_trabajo.'\' )">Corregir</button>';
		$cargar_doc='<div  id="div_'.$id_trabajo.'" style="margin-bottom:20px;" >
						<button class="btn_carta" onclick="cargar_carta('.$id_trabajo.')">Conceptos</button><input type="text" class="input_carta" id="carta_'.$id_trabajo.'">
						</div>';}
	
	$html='<div style="border:0px solid #000">
						<table>
							<tr>
								<td><a href="'.$anteproyecto.'" target="_blank"><img src="../img/pdf_descarga.png" width="140" height="150"></a></td>
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Proyecto</p></div>
								
								<div class="btn_botones" id="btn_'.$id_trabajo.'">'.$button.'<button  class="btn_propuestas" onClick="enviado_jurado('.$id_trabajo.', '.$recetor.', \''.$codigo_trabajo.'\')">Enviar a Jurado</button></div>
								<div class="mtm_observacio">
									<button class="btn_propuestas" id="observ_'.$id_trabajo.'"  onClick="verObservaciones('.$id_trabajo.')">Observaciones</button>
									
									
									
								</div>
								
								<div id="div_jurado">';
								if(existe_jurado($id_trabajo, $link)){$html.=jurados2($id_trabajo, 1, 1); $html.=jurados2($id_trabajo, 2, 2);}
								else{$html.=jurados($id_trabajo, 1, $link); $html.=jurados($id_trabajo, 2, $link);}
									
									
							 $html.='</div>
				  
						  </td>
						  </tr>
					  </table>';
					  
					 $html.=$cargar_doc.'</div>';
		  
	return $html;
	
	}

function comite_cordinador2($anteproyecto, $codigo_trabajo, $titulo, $id_trabajo){
		$button='<button  class="btn_propuestas" onClick="corregir_proyec(4,'.$id_trabajo.')">Corregir</button>';
		$cargar_doc='<div  id="div_'.$id_trabajo.'" style="margin-bottom:20px" >
						<button class="btn_carta" onclick="cargar_carta('.$id_trabajo.')">Conceptos</button><input type="text" class="input_carta" id="carta_'.$id_trabajo.'">
						</div>';
	
		$html='<div style="border:0px solid #000">
						<table>
							<tr>
								<td><a href="'.$anteproyecto.'" target="_blank"><img src="../img/pdf_descarga.png" width="140" height="150"></a></td>
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p>Proyecto</p></div>
								
								<div class="btn_botones" id="btn_'.$id_trabajo.'">'.$button.'<button  class="btn_propuestas" onClick="enviado_estudent('.$id_trabajo.')">Informe Final</button></div>
								<div class="mtm_observacio">
									<button class="btn_propuestas" id="observ_'.$id_trabajo.'"  onClick="verObservaciones('.$id_trabajo.')">Observaciones</button>
									
								</div>';
								
							 $html.='</div>
				  
						  </td>
						  </tr>
					  </table>';
					  $html.=$cargar_doc.'</div>';
	return $html;	
	}

?>