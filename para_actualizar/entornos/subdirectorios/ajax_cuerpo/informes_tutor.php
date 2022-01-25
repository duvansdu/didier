<?php

if(!isset($_SESSION["user"])){

	session_start();
	include '../../../connections/conection.php';
	include "funciones.php";	
	}


	
	$id_tutor=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_tutor_interno.id_tutor_interno
						  FROM pegasoun_proyecto.tb_tutor_interno tb_tutor_interno
						 WHERE tb_tutor_interno.id_usuario = '".$_SESSION["user"]."'"));
							
	$informes_tutor=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
								   tb_trabajo.codigo_trabajo,
								   tb_trabajo.titulo,
								   `tb_trabajo tb_pofesional`.informe_final
							  FROM    (   (   pegasoun_proyecto.tb_comunicacion tb_comunicacion
										   JOIN
											  pegasoun_proyecto.tb_trabajo tb_trabajo
										   ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo))
									   JOIN
										  pegasoun_proyecto.`tb_trabajo tb_pofesional` `tb_trabajo tb_pofesional`
									   ON (`tb_trabajo tb_pofesional`.id_trabajo = tb_trabajo.id_trabajo))
								   JOIN
									  pegasoun_proyecto.tb_trabajo_tutores tb_trabajo_tutores
								   ON (tb_trabajo_tutores.id_trabajo = tb_trabajo.id_trabajo)
							 WHERE     tb_comunicacion.emisor = '3'
								   AND tb_comunicacion.recetor = '5'
								   AND tb_comunicacion.habilita_plataforma = '0'
								   AND tb_trabajo_tutores.id_tutor_interno ='".$id_tutor['id_tutor_interno']."'");

	$informes_tutor=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
								       tb_trabajo.codigo_trabajo,
								       tb_trabajo.titulo,
								       `tb_trabajo tb_pofesional`.informe_final
								  FROM    (   (   pegasoun_proyecto.`tb_trabajo tb_pofesional` `tb_trabajo tb_pofesional`
								               JOIN
								                  pegasoun_proyecto.tb_trabajo tb_trabajo
								               ON (`tb_trabajo tb_pofesional`.id_trabajo =
								                      tb_trabajo.id_trabajo))
								           JOIN
								              pegasoun_proyecto.tb_comunicacion tb_comunicacion
								           ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo))
								       JOIN
								          pegasoun_proyecto.tb_histo_tuto_inter tb_histo_tuto_inter
								       ON (tb_histo_tuto_inter.id_trabajo = tb_trabajo.id_trabajo)
								 WHERE     tb_comunicacion.emisor = '3'
								       AND tb_comunicacion.recetor = '5'
								       AND tb_comunicacion.habilita_plataforma = '0'
								       AND tb_histo_tuto_inter.id_tutor_interno = '".$id_tutor['id_tutor_interno']."'
								       AND tb_histo_tuto_inter.estado = '1'");

	$mod=mysqli_num_rows($informes_tutor)%2;
	$division=(mysqli_num_rows($informes_tutor)+$mod)/2;
	$i=1;									   
	$div1='<div id="div1_1" class="div1">';
	$div2='<div id="div2_1" class="div2">';
	
        	
				if(mysqli_num_rows($informes_tutor)>0){
					
					while($f=mysqli_fetch_array($informes_tutor)){
						$html=informes_cordi_tutor($f['id_trabajo'], $f['informe_final'], $f['codigo_trabajo'], $f['titulo'], 'Informe', $id_tutor['id_tutor_interno'] );
						
						if($i<=$division){
							  $div1.=$html;
							  }
							  
						  else{
							  $div2.=$html;
							  }
							  $i++;
						}//while

				$div1.='</div>';
				$div2.='</div>';
				$div_cuerpo='<div id="div_cuerpo" class="div_cuerpo">'.$div1.$div2.'</div>';
				echo $div_cuerpo;
				echo '<input type="file" id="carta" style="visibility:hidden" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" onchange="cargando_carta()">';	
					}
				
				
				else{?>
                
                		<h2>En el momento no se han encontrado informes para revisión.</h2>
                        <a id="modiTutor" onClick="ModiTotoInter(<?php echo $_SESSION["user"] ?>)">Modificar Datos</a>
					
					<?php }
			?>


