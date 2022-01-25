<?php
session_start();
include "../connections/conection.php";
$opcion=$_POST['opcion'];

switch($opcion){
	
	case 1:{
		
		$desa_tecno=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
				   tb_trabajo.codigo_trabajo,
				   tb_trabajo.titulo,
				   `tb_trabajo tb_desarrollo tecnologico`.anteproyecto
			  FROM pegasoun_proyecto.tb_jurado tb_jurado
				   CROSS JOIN pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
				   CROSS JOIN (   pegasoun_proyecto.tb_comunicacion tb_comunicacion
							   JOIN
								  pegasoun_proyecto.tb_trabajo tb_trabajo
							   ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo))
				   JOIN pegasoun_proyecto.`tb_trabajo tb_desarrollo tecnologico` `tb_trabajo tb_desarrollo tecnologico`
					  ON (`tb_trabajo tb_desarrollo tecnologico`.id_trabajo =
							 tb_trabajo.id_trabajo)
			 WHERE     tb_jurado.estado = '1'
				   AND tb_jurado.id_usuario = '".$_SESSION['user']."'
				   AND tb_jurado.id_jurado = `tb_trabajo tb_jurado`.id_jurado
				   AND tb_trabajo.id_trabajo = `tb_trabajo tb_jurado`.id_trabajo
				   AND tb_comunicacion.emisor = '3'
				   AND tb_comunicacion.recetor = '2'
				   AND tb_comunicacion.tipo_documento = '1'
				   AND tb_trabajo.id_programa = '".$_POST['id_programa']."'
				   AND `tb_trabajo tb_jurado`.estado = '1' ");
	   
	   
	    $gestion_empre=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
				   tb_trabajo.codigo_trabajo,
				   tb_trabajo.titulo,
				   `tb_trabajo tb_gestion_empresarial`.anteproyecto
			  FROM pegasoun_proyecto.tb_jurado tb_jurado
				   CROSS JOIN pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
				   CROSS JOIN (   pegasoun_proyecto.tb_comunicacion tb_comunicacion
							   JOIN
								  pegasoun_proyecto.tb_trabajo tb_trabajo
							   ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo))
				   JOIN pegasoun_proyecto.`tb_trabajo tb_gestion_empresarial` `tb_trabajo tb_gestion_empresarial`
					  ON (`tb_trabajo tb_gestion_empresarial`.id_trabajo =
							 tb_trabajo.id_trabajo)
			 WHERE     tb_jurado.estado = '1'
				   AND tb_jurado.id_usuario = '".$_SESSION['user']."'
				   AND tb_jurado.id_jurado = `tb_trabajo tb_jurado`.id_jurado
				   AND tb_trabajo.id_trabajo = `tb_trabajo tb_jurado`.id_trabajo
				   AND tb_comunicacion.emisor = '3'
				   AND tb_comunicacion.recetor = '2'
				   AND tb_comunicacion.tipo_documento = '1'
				   AND tb_trabajo.id_programa = '".$_POST['id_programa']."'
				   AND `tb_trabajo tb_jurado`.estado = '1' ");
				   
			$div1='<div class="div1">';
			$div2='<div class="div2">';
			$cont=1;	   
				   
			while($g=mysqli_fetch_array($desa_tecno)){
		
					if($cont==1){
							$div1.=proyectos_jurado($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $_SESSION['user'], $_POST['id_programa']);
						$cont=2;
					}
		
					else{
				
							$div2.=proyectos_jurado($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $_SESSION['user'], $_POST['id_programa']);
							$cont=1;
						
						}

				}
			
			while($g=mysqli_fetch_array($gestion_empre)){
		
				if($cont==1){

						$div1.=proyectos_jurado($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $_SESSION['user'], $_POST['id_programa']);
						$cont=2;
					}
		
				 else{

						$div2.=proyectos_jurado($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $_SESSION['user'], $_POST['id_programa']);
						$cont=1;
				     }

} 


				
		 	$div1.='</div>';
			$div2.='</div>';

		 $div_cuerpo='<div id="div_cuerpo" class="div_cuerpo">'.$div1.$div2.'</div>';
		
		echo $div_cuerpo;
		}break;
	case 2:{
		
				$desa_tecno=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
						   tb_trabajo.codigo_trabajo,
						   tb_trabajo.titulo,
						   `tb_trabajo tb_desarrollo tecnologico`.informe_final
					  FROM pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
						   CROSS JOIN pegasoun_proyecto.tb_jurado tb_jurado
						   CROSS JOIN pegasoun_proyecto.`tb_trabajo tb_desarrollo tecnologico` `tb_trabajo tb_desarrollo tecnologico`
						   JOIN pegasoun_proyecto.tb_trabajo tb_trabajo
							  ON (`tb_trabajo tb_desarrollo tecnologico`.id_trabajo =
									 tb_trabajo.id_trabajo)
					 WHERE     tb_trabajo.id_trabajo = `tb_trabajo tb_jurado`.id_trabajo
						   AND tb_jurado.id_jurado = `tb_trabajo tb_jurado`.id_jurado
						   AND tb_jurado.id_usuario = '".$_SESSION['user']."'
						   AND `tb_trabajo tb_jurado`.estado = 1
						   AND tb_trabajo.id_programa = '".$_POST['id_programa']."' ");
		
 

 

				$gestion_empre=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
						   tb_trabajo.codigo_trabajo,
						   tb_trabajo.titulo,
						   `tb_trabajo tb_gestion_empresarial`.informe_final
					  FROM pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
						   CROSS JOIN pegasoun_proyecto.tb_jurado tb_jurado
						   CROSS JOIN pegasoun_proyecto.`tb_trabajo tb_gestion_empresarial` `tb_trabajo tb_gestion_empresarial`
						   JOIN pegasoun_proyecto.tb_trabajo tb_trabajo
							  ON (`tb_trabajo tb_gestion_empresarial`.id_trabajo =
									 tb_trabajo.id_trabajo)
					 WHERE     tb_trabajo.id_trabajo = `tb_trabajo tb_jurado`.id_trabajo
						   AND tb_jurado.id_jurado = `tb_trabajo tb_jurado`.id_jurado
						   AND tb_jurado.id_usuario = '".$_SESSION['user']."'
						   AND `tb_trabajo tb_jurado`.estado = 1
						   AND tb_trabajo.id_programa = '".$_POST['id_programa']."' ");
						   
			$div1='<div class="div1">';
			$div2='<div class="div2">';
			$cont=1;
			while($g=mysqli_fetch_array($desa_tecno)){
		
					if($cont==1){
			
						$div1.=informes_desa_gesti($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $_SESSION['user'], $_POST['id_programa']);
						$cont=2;
					}
					
				else{
			
						$div2.=informes_desa_gesti($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $_SESSION['user'], $_POST['id_programa']);
						$cont=1;
			
					
					}
} 

			while($g=mysqli_fetch_array($gestion_empre)){
		
					if($cont==1){
			
						$div1.=informes_desa_gesti($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $_SESSION['user'], $_POST['id_programa']);
													$cont=2;
					}
					
				else{
			
						$div2.=informes_desa_gesti($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $_SESSION['user'], $_POST['id_programa']);
						$cont=1;
			
					}
			} 


			$div1.='</div>';
			$div2.='</div>';
			$div_cuerpo='<div id="div_cuerpo" class="div_cuerpo">'.$div1.$div2.'</div>';
	
			echo $div_cuerpo;
			echo '<input type="file" id="carta" style="visibility:hidden" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" onchange="cargando_carta()">';


		}break;
	
	}
	







function proyectos_jurado($anteproyecto, $codigo_trabajo, $titulo, $id_trabajo, $user, $id_programa){
	return '<div style="border:0px solid #000;">
						<table class="tbl_tabe">
							<tr>
								<td><a href="'.$anteproyecto.'" target="_blank"><img src="../img/pdf_descarga.png" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p class="p">Proyecto</p></div>
								<div><button class="btn_propuestas" onClick="envio_coordinador3('.$id_trabajo.', '.$user.', '.$id_programa.')">Enviar Observaciones</button><button class="btn_propuestas" onClick="verObservaciones('.$id_trabajo.')">Ver Observaciones</button></div>
					
							</td>
							</tr>
						</table>
						
						<div class="div_textarea" style="margin-bottom:15px" id="div_'.$id_trabajo.'" >
						
						<div id="carta_'.$id_trabajo.'" style=" text-align:justify; margin-left:12px; color:#000"></div>
						
						<textarea class="textarea" id="'.$id_trabajo.'" placeholder="Escriba sus observaciones" maxlength="1000" onKeyUp="string('.$id_trabajo.')"></textarea>
						
						<textarea id="anuncio2_'.$id_trabajo.'" style="visibility:hidden" cols="50" rows="2"></textarea>
						
						</div>
				
			</div>';
	
	}
	
	

function informes_desa_gesti($informe_final, $codigo_trabajo, $titulo, $id_trabajo, $user, $id_programa){
	
	return '<div style="border:0px solid #000;">
						<table class="tbl_tabe">
							<tr>
								<td><a href="'.$informe_final.'"><img src="../img/word.jpg" width="140" height="150"></a></td>
							
							
							<td>
							
								<div class="encabezado_proyecto"><div class="hijo">'.$codigo_trabajo.'</div></div>
								<div class="cuerpo_proyecto">'.$titulo.'<p class="p">Informe Final</p></div>
								<div><button class="btn_propuestas" onClick="envio_coordinador4('.$id_trabajo.', '.$user.', '.$id_programa.')">Enviar Observaciones</button><button class="btn_propuestas" onClick="verObservaciones('.$id_trabajo.')">Ver Observaciones</button></div>
					
							</td>
							</tr>
						</table>
						
						<div class="div_textarea" style="margin-bottom:15px" id="div_'.$id_trabajo.'" >
						
						<div id="carta2_'.$id_trabajo.'" style=" text-align:justify; margin-left:12px; color:#000; margin-top:10px;">									                           
						   <button class="btn_carta" onclick="cargar_carta('.$id_trabajo.')">Correciones</button>
						   <input type="text" class="input_carta" id="cartas_'.$id_trabajo.'">
						</div>
						
						<div id="carta_'.$id_trabajo.'" style=" text-align:justify; margin-left:12px; color:#000; margin-top:10px;">									                           
						</div>
						
						<textarea class="textarea" id="'.$id_trabajo.'" placeholder="Escriba sus observaciones" maxlength="1000" onKeyUp="string('.$id_trabajo.')"></textarea>
						
						<textarea id="anuncio2_'.$id_trabajo.'" style="visibility:hidden" cols="50" rows="2"></textarea>
						
						</div>
				
			</div>';
	}
?>