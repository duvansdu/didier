<?php

function propuesta_desa_gestion($propuesta, $codigo_trabajo, $titulo, $id_trabajo, $id_comite , $nombre, $documento){
	
	return '<div style="border:0px solid #000">
						<table class="table">
											<tr>
												<td><a href="'.$propuesta.'" target="_blank"><img src="../img/pdf_descarga.png" width="140" height="150"></a></td>
											
											
											<td>
											
												<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
												<div class="cuerpo_proyecto">'.$titulo.'<p class="p">'.$documento.'</p><p>'.$nombre.'</p></div>
												<div><button class="btn_propuestas" onClick="crear_obser('.$id_trabajo.')" >Crear Observación</button><button class="btn_propuestas" onClick="envio_coordinador('.$id_trabajo.', 0, '.$id_comite.')">Enviar Observación</button><button class="btn_propuestas" onClick="verObservaciones('.$id_trabajo.')">Ver Observación</button></div>							
											</td>
											</tr>
										</table>
									<div class="div_textarea" id="div_'.$id_trabajo.'" ><textarea class="textarea" id="'.$id_trabajo.'" placeholder="Observacion de 1000 caracteres" maxlength="1000" onKeyPress="detener(event, '.$id_trabajo.')" onKeyDown="tecla(event,'.$id_trabajo.')"></textarea></div>
									
										
								</div>';
	
	}
	
function proyectos_desa_gestion($anteproyecto, $codigo_trabajo, $titulo, $nombre, $id_trabajo, $id_comite){
	
		return '<div style="border:0px solid #000">
						<table class="table">
											<tr>
												<td><a href="'.$anteproyecto.'" target="_blank"><img src="../img/pdf_descarga.png" width="140" height="150"></a></td>
											
											
											<td>
											
												<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
												<div class="cuerpo_proyecto">'.$titulo.'<p class="p">Proyecto</p><p>'.$nombre.'</p></div>
												<div><button class="btn_propuestas" onClick="crear_obser('.$id_trabajo.')" >Crear Observación</button><button class="btn_propuestas" onClick="envio_coordinador('.$id_trabajo.', 1, '.$id_comite.')">Enviar Observación</button><button class="btn_propuestas" onClick="verObservaciones('.$id_trabajo.')">Ver Observación</button></div>							
											</td>
											</tr>
										</table>
									<div class="div_textarea" id="div_'.$id_trabajo.'" ><textarea class="textarea" id="'.$id_trabajo.'" placeholder="Observacion de 1000 caracteres" maxlength="1000" onKeyPress="detener(event, '.$id_trabajo.')" onKeyDown="tecla(event,'.$id_trabajo.')"></textarea></div>
									
										
								</div>';
	
	}

function desarrollo_de_investigacion($anteproyecto, $codigo_trabajo, $titulo, $nombre, $id_trabajo, $id_comite){
	
		return '<div style="border:0px solid #000">
						<table class="table">
											<tr>
												<td><a href="'.$anteproyecto.'" ><img src="../img/word.jpg" width="140" height="150"></a></td>
											
											
											<td>
											
												<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
												<div class="cuerpo_proyecto">'.$titulo.'<p class="p">Informe</p><p>'.$nombre.'</p></div>
												<div><button class="btn_propuestas" onClick="crear_obser('.$id_trabajo.')" >Crear Observación</button><button class="btn_propuestas" onClick="envio_coordinador('.$id_trabajo.', 2, '.$id_comite.')">Enviar Observación</button><button class="btn_propuestas" onClick="verObservaciones('.$id_trabajo.')">Ver Observación</button></div>							
											</td>
											</tr>
										</table>
									<div class="div_textarea" id="div_'.$id_trabajo.'" ><textarea class="textarea" id="'.$id_trabajo.'" placeholder="Observacion de 1000 caracteres" maxlength="1000" onKeyPress="detener(event, '.$id_trabajo.')" onKeyDown="tecla(event,'.$id_trabajo.')"></textarea></div>
									
										
								</div>';
	
	}
?>

