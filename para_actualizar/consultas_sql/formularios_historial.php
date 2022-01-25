<?php
session_start();
include "../connections/conection.php";

if(isset($_POST['id_trabajo'])){
	$id_trabajo=$_POST['id_trabajo'];
	
	$integrantes=mysqli_query($link,"SELECT CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombre
				  FROM pegasoun_proyecto.`tb_trabajo tb_estudiante` `tb_trabajo tb_estudiante`,
					   pegasoun_proyecto.tb_usuario tb_usuario,
					   pegasoun_proyecto.tb_trabajo tb_trabajo
				 WHERE     tb_trabajo.id_trabajo = `tb_trabajo tb_estudiante`.id_trabajo
					   AND `tb_trabajo tb_estudiante`.id_usuario = tb_usuario.id_usuario
					   AND `tb_trabajo tb_estudiante`.id_trabajo ='".$_POST['id_trabajo']."' AND `tb_trabajo tb_estudiante`.estado=1");
					   
	$datos1=mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       tb_trabajo.fecha_aprobacion,
       tb_usuario.nombre,
       tb_usuario.apellido,
       tb_trabajo.id_modalidad,
       tb_comunicacion.tipo_documento
  FROM pegasoun_proyecto.`tb_trabajo tb_estudiante` `tb_trabajo tb_estudiante`
       CROSS JOIN pegasoun_proyecto.tb_usuario tb_usuario
       CROSS JOIN pegasoun_proyecto.tb_comunicacion tb_comunicacion
       JOIN pegasoun_proyecto.tb_trabajo tb_trabajo
          ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE     tb_trabajo.id_trabajo = `tb_trabajo tb_estudiante`.id_trabajo
       AND `tb_trabajo tb_estudiante`.id_usuario = tb_usuario.id_usuario
       AND tb_trabajo.id_trabajo = ".$_POST['id_trabajo']."
ORDER BY tb_trabajo.fecha_aprobacion ASC");
					   
	$datos=mysqli_fetch_assoc($datos1);

if(mysqli_num_rows($datos1)==0){
	$datos=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       tb_trabajo.fecha_aprobacion,
       tb_trabajo.id_modalidad,
       tb_comunicacion.tipo_documento
  FROM    pegasoun_proyecto.tb_comunicacion tb_comunicacion
       JOIN
          pegasoun_proyecto.tb_trabajo tb_trabajo
       ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE tb_trabajo.id_trabajo = ".$_POST['id_trabajo']."
ORDER BY tb_trabajo.fecha_aprobacion ASC"));
	
	}


if($datos['fecha_aprobacion']!=0){
	$fecha=explode('-',$datos['fecha_aprobacion']);
	$mes=obtenerMesCorto($fecha[1]);

	$fecha=$fecha[2].' de '.$mes.' '.$fecha[0];
}

else{$fecha='En espera';}



switch($datos['id_modalidad']){
	
	case 1:{//Desarrollo tecnologico
			switch($datos['tipo_documento']){
				case 0:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_desarrollo tecnologico`.propuesta FROM pegasoun_proyecto.`tb_trabajo tb_desarrollo tecnologico` `tb_trabajo tb_desarrollo tecnologico` WHERE `tb_trabajo tb_desarrollo tecnologico`.id_trabajo = '".$_POST['id_trabajo']."'"));
							$ruta=$documento['propuesta'];
					}break;
					
				case 1:{								
								$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_desarrollo tecnologico`.anteproyecto FROM pegasoun_proyecto.`tb_trabajo tb_desarrollo tecnologico` `tb_trabajo tb_desarrollo tecnologico` WHERE `tb_trabajo tb_desarrollo tecnologico`.id_trabajo = '".$_POST['id_trabajo']."'"));
							if($documento['anteproyecto']!=''){
								$ruta=$documento['anteproyecto'];
								}
								
							else{
									$ruta='../documentos_pdf/notificacion.pdf';
								
								}
					}break;
					
				case 2:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_desarrollo tecnologico`.informe_final  FROM pegasoun_proyecto.`tb_trabajo tb_desarrollo tecnologico` `tb_trabajo tb_desarrollo tecnologico` WHERE `tb_trabajo tb_desarrollo tecnologico`.id_trabajo = '".$_POST['id_trabajo']."'"));
							$ruta=$documento['informe_final'];
					}break;
				}
		}break;//Desarrollo tecnologico
	
	
	case 2:{//Practica de desempe
			switch($datos['tipo_documento']){
				case 0:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_pofesional`.plan_trabajo
  FROM pegasoun_proyecto.`tb_trabajo tb_pofesional` `tb_trabajo tb_pofesional`
 WHERE `tb_trabajo tb_pofesional`.id_trabajo =  '".$_POST['id_trabajo']."'"));
							$ruta=$documento['plan_trabajo'];
					}break;
					
				case 2:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_pofesional`.informe_final
  FROM pegasoun_proyecto.`tb_trabajo tb_pofesional` `tb_trabajo tb_pofesional`
 WHERE `tb_trabajo tb_pofesional`.id_trabajo = '".$_POST['id_trabajo']."'"));
							$ruta=$documento['informe_final'];
					}break;
				}

		}break;//Practica de desempe
		
		
	case 3:{//Formulacion investigacion
			switch($datos['tipo_documento']){
				case 0:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_formulacion_investigacion`.propuesta FROM pegasoun_proyecto.`tb_trabajo tb_formulacion_investigacion` `tb_trabajo tb_formulacion_investigacion` WHERE `tb_trabajo tb_formulacion_investigacion`.id_trabajo = '".$_POST['id_trabajo']."'"));
							$ruta=$documento['propuesta'];
					}break;
					
				case 1:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_formulacion_investigacion`.anteproyecto FROM pegasoun_proyecto.`tb_trabajo tb_formulacion_investigacion` `tb_trabajo tb_formulacion_investigacion` WHERE `tb_trabajo tb_formulacion_investigacion`.id_trabajo = '".$_POST['id_trabajo']."'"));
							$ruta=$documento['anteproyecto'];
					}break;
					
				case 2:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_formulacion_investigacion`.informe_final FROM pegasoun_proyecto.`tb_trabajo tb_formulacion_investigacion` `tb_trabajo tb_formulacion_investigacion` WHERE `tb_trabajo tb_formulacion_investigacion`.id_trabajo = '".$_POST['id_trabajo']."'"));
							$ruta=$documento['informe_final'];
					}break;
				}

		}break;//Formulacion investigacion
		
	case 4:{//Trabajo de Auto Gestion Empresarial
			switch($datos['tipo_documento']){
				case 0:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SSELECT `tb_trabajo tb_gestion_empresarial`.propuesta FROM pegasoun_proyecto.`tb_trabajo tb_gestion_empresarial` `tb_trabajo tb_gestion_empresarial` WHERE `tb_trabajo tb_gestion_empresarial`.id_trabajo = '".$_POST['id_trabajo']."'"));
							$ruta=$documento['propuesta'];
					}break;
					
				case 1:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_gestion_empresarial`.anteproyecto FROM pegasoun_proyecto.`tb_trabajo tb_gestion_empresarial` `tb_trabajo tb_gestion_empresarial` WHERE `tb_trabajo tb_gestion_empresarial`.id_trabajo = '".$_POST['id_trabajo']."'"));
							$ruta=$documento['anteproyecto'];
					}break;
					
				case 2:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_gestion_empresarial`.informe_final FROM pegasoun_proyecto.`tb_trabajo tb_gestion_empresarial` `tb_trabajo tb_gestion_empresarial` WHERE `tb_trabajo tb_gestion_empresarial`.id_trabajo =  '".$_POST['id_trabajo']."'"));
							$ruta=$documento['informe_final'];
					}break;
				}
		
		}break;//Trabajo de Auto Gestion Empresarial
		
	case 5:{//Desarrollo De una Investigacion
			switch($datos['tipo_documento']){
				case 0:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_desarrollo_investigcion`.solicitud_inclusion FROM pegasoun_proyecto.`tb_trabajo tb_desarrollo_investigcion` `tb_trabajo tb_desarrollo_investigcion` WHERE `tb_trabajo tb_desarrollo_investigcion`.id_trabajo = '".$_POST['id_trabajo']."'"));
							$ruta=$documento['solicitud_inclusion'];
					}break;
					
					
				case 2:{
							$documento=mysqli_fetch_assoc(mysqli_query($link,"SELECT `tb_trabajo tb_desarrollo_investigcion`.informe_final FROM pegasoun_proyecto.`tb_trabajo tb_desarrollo_investigcion` `tb_trabajo tb_desarrollo_investigcion` WHERE `tb_trabajo tb_desarrollo_investigcion`.id_trabajo = '".$_POST['id_trabajo']."'"));
							$ruta=$documento['informe_final'];
					}break;
				}
				
		}break;//Desarrollo De una Investigacion
	
	}
	
	
	}



$doc=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_comunicacion.tipo_documento
		  FROM pegasoun_proyecto.tb_comunicacion tb_comunicacion
		 WHERE tb_comunicacion.id_trabajo = '".$id_trabajo."' "));

$target='';

if($doc['tipo_documento']==0 || $doc['tipo_documento']==1){$img='../img/pdf_descarga.png'; $target='_blank';}

if($doc['tipo_documento']==2){$img='../img/word.jpg'; }


$student='';
while($f=mysqli_fetch_array($integrantes)){
	$student.='<br>'.$f['nombre'];
	
	}

echo '<div style="border:0px solid #000; margin-bottom:20px; width:460px; margin:0px auto;">
	<table  class="tabla" align="center">
		<tr>
			<td><a href="'.$ruta.'" target="'.$target.'"><img src="'.$img.'" width="140" height="150"></a></td>
		<td>
			<div class="encabezado_proyecto"><div class="hijo">'.$datos['codigo_trabajo'].'</div></div>
			<div class="cuerpo_proyecto">'.$datos['titulo'].'<br>'.$student.'<br><br>Fecha Aprobación: '.$fecha.'</div>
			<div><button class="btn_propuestas" onClick="historial_proyec('.$id_trabajo.')">Historial</button><button id="BTNmodifacarActualizar" class="btn_propuestas" onClick="modificar('.$id_trabajo.')"> Modificar</button><button class="btn_propuestas" onClick="cancelar_proyecto('.$id_trabajo.', \''.$datos['codigo_trabajo'].'\')">Cancelar</button></div>
		</td>
		</tr>
	</table>
</div>
			
			
	<div id="datos_modificar"></div>
			';

?>
