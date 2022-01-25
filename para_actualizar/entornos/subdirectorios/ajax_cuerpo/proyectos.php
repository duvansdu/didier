<script type="text/javascript">
	$(document).ready(function(e) {
        $(".btn_botones").fadeOut(0);
		$(".div_textarea").fadeOut(0);
    });
	
function crear_obser(id_trabajo){
	$("#div_"+id_trabajo).fadeIn(0);
	
	}
	
function rechazar_propuesta(id_trabajo, opci){
	
	if($("#"+id_trabajo).val()!=""){
		$observacion='<p>'+$("#"+id_trabajo).val()+'</p>';
		
				data='id_trabajo='+id_trabajo+'&opci='+opci+'&opcion='+14+"&observacion="+$observacion;
				$.ajax({
						url:'../consultas_sql/Actualizar.php',
						data:data,
						type:'POST',
						dataType:"json",
						success: function(msg){
							alert(msg.mensaje);
								$.ajax({
									url:msg.url,
									type:"POST",
									dataType:"html",
									success: function(msg){
										$("#area_documentos").html(msg);
										}
									});
							
							}
					})
					
		}
	
	
	}
	
function corregir_proyec(recetor,id_trabajo, codigo_doc){
	
	if(confirm("Desea enviar El documento "+codigo_doc+" a CORRECIÓN")){
			var inputFileImage = document.getElementById("carta");
			var file = inputFileImage.files[0];
			var data = new FormData();
					
						if($("#carta").val()!=""){
								data.append('opcion',17);
								data.append('archivo',file);
								data.append('id_trabajo',id_trabajo);
								
								
								$.ajax({
										url:'../consultas_sql/Actualizar.php',
										data:data,
										type:'POST',
										dataType:"json",
										processData:false,
										cache:false,
										contentType:false,
										success: function(msg){
											alert(msg);
												$.ajax({
													url:"subdirectorios/ajax_cuerpo/proyectos.php",
													type:"POST",
													dataType:"html",
													success: function(msg){
														$("#area_documentos").html(msg);
														}
													});
											
											}
									})
						}
						else{alert("Debe Cargar los Conceptos Emitidos por el Comite");}
		}
		
	
	}
	
function corregir_proyec_jurado(id_trabajo, codig_docu){
	
	if(confirm("Desea enviar el Proyecto "+codig_docu+" a correción")){
			var inputFileImage = document.getElementById("carta");
			var file = inputFileImage.files[0];
			var data = new FormData();
					
						if($("#carta").val()!=""){
								data.append('opcion',18);
								data.append('archivo',file);
								data.append('id_trabajo',id_trabajo);
								
								
								$.ajax({
										url:'../consultas_sql/Actualizar.php',
										data:data,
										type:'POST',
										dataType:"json",
										processData:false,
										cache:false,
										contentType:false,
										success: function(msg){
											alert(msg);
												$.ajax({
													url:"subdirectorios/ajax_cuerpo/proyectos.php",
													type:"POST",
													dataType:"html",
													success: function(msg){
														$("#area_documentos").html(msg);
														}
													});
											
											}
									})
						}
						else{alert("Debe Cargar los Conceptos Emitidos por el Comite");}
		}
	}
	
function verObservaciones(id_trabajo){
	
	window.open('../documentos_pdf/observaciones.php?id_trabajo='+id_trabajo,'_blank');
	$("#btn_"+id_trabajo).fadeIn(0);
	$("#observ_"+id_trabajo).fadeOut(0);
	
	}
var id_trabajo_indi=0;
function cargar_carta(id_trabajo){
	
	$("#carta").click();
	id_trabajo_indi=id_trabajo;
	
	}

function cargando_carta(){
	
	$("#carta_"+id_trabajo_indi).val($("#carta").val());
	id_trabajo_indi=0;
	}
	
function enviado_jurado(id_trabajo, recetor, codi_trabajo){
	
	if(confirm("Desea enviar el documento "+codi_trabajo+" al Jurado")){
	
			var inputFileImage = document.getElementById("carta");
			var file = inputFileImage.files[0];
			var data = new FormData();
			
			if($("#jurado_1_"+id_trabajo).val()!=0 && $("#jurado_2_"+id_trabajo).val()!=0){
				
				if($("#jurado_1_"+id_trabajo).val() != $("#jurado_2_"+id_trabajo).val()){
					
						if($("#carta").val()!=""){
								data.append('opcion',11);
								data.append('archivo',file);
								data.append('id_trabajo',id_trabajo);
								data.append('jurado1',$("#jurado_1_"+id_trabajo).val());
								data.append('jurado2',$("#jurado_2_"+id_trabajo).val());
								
								
								$.ajax({
										url:'../consultas_sql/Actualizar.php',
										data:data,
										type:'POST',
										dataType:"json",
										processData:false,
										cache:false,
										contentType:false,
										success: function(msg){
											alert(msg);
												$.ajax({
													url:"subdirectorios/ajax_cuerpo/proyectos.php",
													type:"POST",
													dataType:"html",
													success: function(msg){
														$("#area_documentos").html(msg);
														}
													});
											
											}
									})
						}
						else{alert("Debe Cargar los Conceptos Emitidos por el Comite");}
					}
				else{alert("Debe selecionar Diferentes Jurados");}
				}
			else{alert("Debe Selecionar Los Jurados del Proyecto");}
		}
	}
	
function verObservaciones_jura(id_trabajo){
	window.open('../documentos_pdf/observaciones_jurado.php?id_trabajo='+id_trabajo,'_blank');
	$("#btn_"+id_trabajo).fadeIn(0);
	$("#obser2_"+id_trabajo).fadeOut(0);

	}
	
function aprobado_jurado(id_trabajo, codig_doc){
	
	if(confirm("Desea APROBAR el Proyecto "+codig_doc)){
			var inputFileImage = document.getElementById("carta");
			var file = inputFileImage.files[0];
			var data = new FormData();
			
						if($("#carta").val()!=""){
								data.append('opcion',5);
								data.append('archivo',file);
								data.append('id_trabajo',id_trabajo);
								
								$.ajax({
										url:'../consultas_sql/InsertSql.php',
										data:data,
										type:'POST',
										dataType:"json",
										processData:false,
										cache:false,
										contentType:false,
										success: function(msg){
											alert(msg);
												$.ajax({
													url:"subdirectorios/ajax_cuerpo/proyectos.php",
													type:"POST",
													dataType:"html",
													success: function(msg){
														$("#area_documentos").html(msg);
														}
													});
											
											}
									})
						}
						else{alert("Debe Cargar los Conceptos Emitidos por el Jurado");}
		}
	}
	
function enviado_estudent(id_trabajo){
	var inputFileImage = document.getElementById("carta");
	var file = inputFileImage.files[0];
	var data = new FormData();
	
				if($("#carta").val()!=""){
						data.append('opcion',22);
						data.append('archivo',file);
						data.append('id_trabajo',id_trabajo);
						
						$.ajax({
								url:'../consultas_sql/Actualizar.php',
								data:data,
								type:'POST',
								dataType:"json",
								processData:false,
								cache:false,
								contentType:false,
								success: function(msg){
									alert(msg);
										$.ajax({
											url:"subdirectorios/ajax_cuerpo/proyectos.php",
											type:"POST",
											dataType:"html",
											success: function(msg){
												$("#area_documentos").html(msg);
												}
											});
									
									}
							})
				}
				else{alert("Debe Cargar los Conceptos Emitidos por el Jurado");}
	
	}
	
function enviar_jurado(id_trabajo, $recetor){
	var inputFileImage = document.getElementById("carta");
	var file = inputFileImage.files[0];
	var data = new FormData();
	
	if($("#jurado_1_"+id_trabajo).val()!=0 && $("#jurado_2_"+id_trabajo).val()!=0){
		
		if($("#jurado_1_"+id_trabajo).val() != $("#jurado_2_"+id_trabajo).val()){
			
						data.append('opcion',11);
						data.append('archivo',file);
						data.append('id_trabajo',id_trabajo);
						data.append('jurado1',$("#jurado_1_"+id_trabajo).val());
						data.append('jurado2',$("#jurado_2_"+id_trabajo).val());
						
						
						$.ajax({
								url:'../consultas_sql/Actualizar.php',
								data:data,
								type:'POST',
								dataType:"json",
								processData:false,
								cache:false,
								contentType:false,
								success: function(msg){
									alert(msg);
										$.ajax({
											url:"subdirectorios/ajax_cuerpo/proyectos.php",
											type:"POST",
											dataType:"html",
											success: function(msg){
												$("#area_documentos").html(msg);
												}
											});
									
									}
							})
				
			}
		else{alert("Debe selecionar Diferentes Jurados");}
		}
	else{alert("Debe Selecionar Los Jurados del Proyecto");}

	}

</script>
<style type="text/css">
.div1{
	width:50%;
	float:left;}
table{ margin-left:9px; border:0px solid #000; width:97%;}
	
.div2{
	width:50%;
	float:right;
	
	}
	
.div_cuerpo{
	overflow:auto;
	overflow-y:hidden;
	padding-bottom:5px;}
.encabezado_proyecto{text-align:center;width:310px;}

.encabezado_proyecto, .cuerpo_proyecto{
	
	height:40px;
	border:1px solid #000;
	font-family:Arial, Helvetica, sans-serif;
	font-size:15px;
	display: table;
	}

.cuerpo_proyecto{ padding-left:15px; border-top:0px;width:296px; text-align:justify;}
	
.hijo{display: table-cell;
	vertical-align: middle;}
.btn_propuestas{
	width:100px;
	height:50px;
	margin-right:5px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12;
	color:#FFF;
	border-radius:5px;
	background:#06F;
	margin-top:2px;
	cursor:pointer;}

p{color:#06F;}
.textarea{ resize:none;
overflow:hidden;
height:50px;
width:450px;
font-family:Arial, Helvetica, sans-serif;
font-size:12;
text-align:justify}

.a{ cursor:pointer;}

.selec_jurado{
	width:155px;
	height:30px;
	border-radius:5px;
	margin-top:10px;
	margin-bottom:5px;
	margin-left:2.5px;}
	
.btn_carta{
	width:100px;
	height:40px;
	background:#900;
	border:0px;
	font-family:Arial, Helvetica, sans-serif;
	font-family:16px;
	color:#FFF;
	border-radius:5px;
	cursor:pointer;}
.input_carta{ 
			 height:40px;
			 width:300px; 
			 margin-left:5px; 
			 border-radius:5px;
			 border:1px solid #000}

</style>


<?php
include "../../../connections/conection.php";
include "funciones.php";

	
$programas=mysqli_query($link,"SELECT tb_programa.id_programa, tb_programa.nombre FROM pegasoun_proyecto.tb_programa tb_programa");

$sum=0;
$j=1;




while($f=mysqli_fetch_array($programas)){
	
	echo '<h2>'.$f['nombre'].'</h2>';
	
		$desa_tecno=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
				   tb_trabajo.codigo_trabajo,
				   tb_trabajo.titulo,
				   tb_programa.id_programa,
				   tb_programa.nombre,
				   `tb_trabajo tb_desarrollo tecnologico`.anteproyecto,
				   tb_comunicacion.emisor,
				   tb_comunicacion.recetor
			  FROM    (   (   pegasoun_proyecto.tb_trabajo tb_trabajo
						   JOIN
							  pegasoun_proyecto.tb_programa tb_programa
						   ON (tb_trabajo.id_programa = tb_programa.id_programa))
					   JOIN
						  pegasoun_proyecto.tb_comunicacion tb_comunicacion
					   ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo))
				   JOIN
					  pegasoun_proyecto.`tb_trabajo tb_desarrollo tecnologico` `tb_trabajo tb_desarrollo tecnologico`
				   ON (`tb_trabajo tb_desarrollo tecnologico`.id_trabajo =
						  tb_trabajo.id_trabajo)
			 WHERE     tb_comunicacion.tipo_documento = '1'
				   AND (tb_comunicacion.emisor = '1' OR tb_comunicacion.emisor = '2' OR tb_comunicacion.emisor = '4')
				   AND (tb_comunicacion.recetor = '3' OR tb_comunicacion.recetor = '2')
				   AND tb_programa.id_programa = '".$f["id_programa"]."'");
			 
 	$rows=mysqli_num_rows($desa_tecno);
	$sum+=$rows;
	
 	$gest_empre=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
				   tb_trabajo.codigo_trabajo,
				   tb_trabajo.titulo,
				   tb_programa.id_programa,
				   tb_programa.nombre,
				   `tb_trabajo tb_gestion_empresarial`.anteproyecto,
				   tb_comunicacion.emisor,
				   tb_comunicacion.recetor
			  FROM    (   (   pegasoun_proyecto.tb_comunicacion tb_comunicacion
						   JOIN
							  pegasoun_proyecto.tb_trabajo tb_trabajo
						   ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo))
					   JOIN
						  pegasoun_proyecto.tb_programa tb_programa
					   ON (tb_trabajo.id_programa = tb_programa.id_programa))
				   JOIN
					  pegasoun_proyecto.`tb_trabajo tb_gestion_empresarial` `tb_trabajo tb_gestion_empresarial`
				   ON (`tb_trabajo tb_gestion_empresarial`.id_trabajo =
						  tb_trabajo.id_trabajo)
			 WHERE     tb_comunicacion.tipo_documento = '1'
				   AND (tb_comunicacion.emisor = '1' OR tb_comunicacion.emisor = '2' OR tb_comunicacion.emisor = '4')
				   AND (tb_comunicacion.recetor = '3' OR tb_comunicacion.recetor = '2')
				   AND tb_programa.id_programa = '".$f["id_programa"]."'");
	 $rows=mysqli_num_rows($gest_empre);
	 $sum+=$rows;

	$formu_inves=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
				   tb_trabajo.codigo_trabajo,
				   tb_trabajo.titulo,
				   tb_programa.id_programa,
				   tb_programa.nombre,
				   `tb_trabajo tb_formulacion_investigacion`.anteproyecto,
				   tb_comunicacion.emisor,
				   tb_comunicacion.recetor
			  FROM    (   (   pegasoun_proyecto.tb_trabajo tb_trabajo
						   JOIN
							  pegasoun_proyecto.tb_programa tb_programa
						   ON (tb_trabajo.id_programa = tb_programa.id_programa))
					   JOIN
						  pegasoun_proyecto.`tb_trabajo tb_formulacion_investigacion` `tb_trabajo tb_formulacion_investigacion`
					   ON (`tb_trabajo tb_formulacion_investigacion`.id_trabajo =
							  tb_trabajo.id_trabajo))
				   JOIN
					  pegasoun_proyecto.tb_comunicacion tb_comunicacion
				   ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
			 WHERE     tb_comunicacion.tipo_documento = '1'
				   AND (tb_comunicacion.emisor = '1' OR tb_comunicacion.emisor = '4')
				   AND tb_comunicacion.recetor = '3'
				   AND tb_programa.id_programa = '".$f["id_programa"]."' "); 
		$rows=mysqli_num_rows($formu_inves);
		$sum+=$rows;
	
	$mod=$sum%2;
	$division=($sum+$mod)/2;
	$i=1;
	$sum=0;
	$div1='<div id="div1_'.$j.'" class="div1">';
	$div2='<div id="div2_'.$j.'" class="div2">';
	
 	while($g=mysqli_fetch_array($desa_tecno)){
		
		if($g['emisor']==4 && $g['recetor']==3){//Estudiante->Coordinador
		//documento funciones.php
		$html=student_cordinador($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $g['id_programa']);
		
		}
		
		if($g['emisor']==1 && $g['recetor']==3){//Comite->Coordinador
			
			$html=comite_cordinador($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], 3, $link);
			}
		  
		
		if($g['emisor']==2 && $g['recetor']==3){//Jurado->coordinador
			$html=jurado_cordinador($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'],$g['id_programa']);
			
			}
		
		if($g['emisor']==4 && $g['recetor']==2){//Estudiante->Jurado
			$html=student_jurado($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], 2);
			
			
			}
	  
	  if($i<=$division){
		  $div1.=$html;
		  
		  }
	  else{
		  $div2.=$html;
		  }
		  $i++;
	  }
	  

 	while($g=mysqli_fetch_array($gest_empre)){
		
		if($g['emisor']==4 && $g['recetor']==3){//Estudiante->Coordinador
		//documento funciones.php
		$html=student_cordinador($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $g['id_programa']);
		
		}
		
		if($g['emisor']==1 && $g['recetor']==3){//Comite->Coordinador
			
			$html=comite_cordinador($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], 3, $link);
			}
		  
		
		if($g['emisor']==2 && $g['recetor']==3){//Jurado->coordinador
			$html=jurado_cordinador($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'],$g['id_programa']);
			
			}
		
		if($g['emisor']==4 && $g['recetor']==2){//Estudiante->Jurado
			$html=student_jurado($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], 2);
			
			
			}

	  if($i<=$division){
		  $div1.=$html;
		  
		  }
	  else{
		  $div2.=$html;
		  }
		  $i++;
	  }
	  
 	while($g=mysqli_fetch_array($formu_inves)){
		
		if($g['emisor']==4 && $g['recetor']==3){//Estudiante->Coordinador
		//documento funciones.php
		$html=student_cordinador($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], $g['id_programa']);
		
		}
		
		if($g['emisor']==1 && $g['recetor']==3){//Comite->Coordinador
			
			$html=comite_cordinador2($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo']);
			}
		  
		
		if($g['emisor']==2 && $g['recetor']==3){//Jurado->coordinador
			$html=jurado_cordinador($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'],$g['id_programa']);
			
			}
		
		if($g['emisor']==4 && $g['recetor']==2){//Estudiante->Jurado
			$html=comite_cordinador($g['anteproyecto'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], 2, $link);
			
			
			}

	  if($i<=$division){
		  $div1.=$html;
		  
		  }
	  else{
		  $div2.=$html;
		  }
		  $i++;
	  }



		
		$div1.='</div>';
		$div2.='</div>';
		$div_cuerpo='<div id="div_cuerpo" class="div_cuerpo">'.$div1.$div2.'</div>';
		$j++;
		echo $div_cuerpo;
	}
	
	echo '<input type="file" id="carta" style="visibility:hidden" accept="application/pdf" onchange="cargando_carta()">';
?>
