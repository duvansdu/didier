<script type="text/javascript">
var id_trabajo_indi=0;
function cargar_carta(id_trabajo){
	
	$("#carta").click();
	id_trabajo_indi=id_trabajo;
	
	}
	
function cargando_carta(){
	
	$("#carta_"+id_trabajo_indi).val($("#carta").val());
	id_trabajo_indi=0;
	}


function jurado(id_trabajo){
	
	$.ajax({
		url:'../consultas_sql/Actualizar.php',
		type:'POST',
		data:'id_trabajo='+id_trabajo+'&opcion='+13,
		dataType:"json",
		success: function(msg){
			alert(msg);
			$.ajax({
				url:"subdirectorios/ajax_cuerpo/informes.php",
				type:'POST',
				dataType:"html",
				success: function(msg){
					$("#area_documentos").html(msg);
					}
				})
			}
		});
	
	}
	
function devolver_info_pract(id_trabajo, tipo){
	string=$("#"+id_trabajo).val();
	
	if(string!=""){
		$.ajax({
			url:'../consultas_sql/Actualizar.php',
			type:'POST',
			data:'id_trabajo='+id_trabajo+'&obervacion='+string+'&opcion='+16+'&tipo='+tipo,
			dataType:"json",
			success: function(msg){
				alert(msg);
				$.ajax({
					url:"subdirectorios/ajax_cuerpo/informes.php",
					type:'POST',
					dataType:"html",
					success: function(msg){
						$("#area_documentos").html(msg);
						}
					})
				}
			});
		}
		
	else{alert("Especifique por que se devuelve el Informe")};
	
	}
	
function devolver_info(id_trabajo){//de las modalidades tecno-gestion
	string=$("#"+id_trabajo).val();
	
	if(string!=""){
		$.ajax({
			url:'../consultas_sql/Actualizar.php',
			type:'POST',
			data:'id_documento='+id_trabajo+'&string='+string+'&opcion='+15,
			dataType:"json",
			success: function(msg){
				alert(msg);
				$.ajax({
					url:"subdirectorios/ajax_cuerpo/informes.php",
					type:'POST',
					dataType:"html",
					success: function(msg){
						$("#area_documentos").html(msg);
						}
					})
				}
			});
		}
		
	else{alert("Especifique por que se devuelve el Informe")};
	
	}

	
function verObservaciones_jura2(id_trabajo){
	window.open('../documentos_pdf/observaciones_jurado.php?id_trabajo='+id_trabajo,'_blank');
	}
function verObservaciones_comite(id_trabajo){
	window.open('../documentos_pdf/observaciones.php?id_trabajo='+id_trabajo,'_blank');
	}
	
function enviar_carta(id_trabajo, codi_docu){
	
	if(confirm("Desea Aprobar el Informe "+codi_docu)){
	
				var inputFileImage = document.getElementById("carta");
				var file = inputFileImage.files[0];
				var data = new FormData();
	
				if($("#carta").val()!=""){
						data.append('opcion',11);
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
											url:"subdirectorios/ajax_cuerpo/informes.php",
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
	
function info_aprobado(id_trabajo, cod_docu){
	
	if(confirm("Desea Aprobar el informe "+cod_docu)){
			var inputFileImage = document.getElementById("carta");
			var file = inputFileImage.files[0];
			var data = new FormData();
			
						if($("#carta").val()!=""){
								data.append('opcion',6);
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
													url:"subdirectorios/ajax_cuerpo/informes.php",
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
	
function corregir_info_desa(id_trabajo){
	
	
	var inputFileImage = document.getElementById("carta");
	var file = inputFileImage.files[0];
	var data = new FormData();
	
				if($("#carta").val()!=""){
						data.append('opcion',12);
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
											url:"subdirectorios/ajax_cuerpo/informes.php",
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
	
function corregir_info(id_trabajo, cod_docu){
	
	if(confirm("Desea enviar el Informe "+cod_docu+" a Correción")){
			var inputFileImage = document.getElementById("carta");
			var file = inputFileImage.files[0];
			var data = new FormData();
			
						if($("#carta").val()!=""){
								data.append('opcion',8);
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
													url:"subdirectorios/ajax_cuerpo/informes.php",
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
	
function enviar_tutor(id_trabajo){
	
	$.ajax({
			url:'../consultas_sql/Actualizar.php',
			data:'id_trabajo='+id_trabajo+'&opcion='+19,
			type:'POST',
			dataType:"json",
			success: function(msg){
				alert(msg)
				
				$.ajax({
						url:"subdirectorios/ajax_cuerpo/informes.php",
						type:"POST",
						dataType:"html",
						success: function(msg){
						     $("#area_documentos").html(msg);
							}
						});
				}
		})
	
	}
function enviar_comite(id_trabajo){
	
	data='id_trabajo='+id_trabajo+'&opcion='+24;
	
	$.ajax({
			url:'../consultas_sql/Actualizar.php',
			data:data,
			type:'POST',
			dataType:"json",
			success: function(msg){
					alert(msg)
					$.ajax({
						url:"subdirectorios/ajax_cuerpo/informes.php",
						type:"POST",
						dataType:"html",
						success: function(msg){
						     $("#area_documentos").html(msg);
							}
						});
				}
		})
	
	}
	
function observa_tutor(id_trabajo){
	window.open('../documentos_pdf/observaciones_tutor.php?id_trabajo='+id_trabajo,'_blank');

	}
	
function enviar_carta_info_avance(id_trabajo){
	var inputFileImage = document.getElementById("carta");
	var file = inputFileImage.files[0];
	var data = new FormData();
	
				if($("#carta").val()!=""){
						data.append('opcion',9);
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
											url:"subdirectorios/ajax_cuerpo/informes.php",
											type:"POST",
											dataType:"html",
											success: function(msg){
												$("#area_documentos").html(msg);
												}
											});
									
									}
							})
				}
				else{alert("Debe Cargar los Conceptos Emitidos por el Tutor");}
	}
	

function corregir_info_tutor(id_trabajo){
	var inputFileImage = document.getElementById("carta");
	var file = inputFileImage.files[0];
	var data = new FormData();
	
	data.append('opcion',10);
	data.append('archivo',file);
	data.append('id_trabajo',id_trabajo);

	$.ajax({
			url:'../consultas_sql/InsertSql.php',
			type:'POST',
			data:data,
			dataType:"html",
			processData:false,
			cache:false,
			contentType:false,

			success: function(msg){
					alert(msg)
								
					$.ajax({
							 url:"subdirectorios/ajax_cuerpo/informes.php",
							 type:'POST',
							 data:'user='+1,
							 dataType:"html",
							  success: function(msg){
								  			$("#area_documentos").html(msg);
								  		}
									})
			  		}
		})
	}
	
function Aprobar_info(id_trabajo){
		string=$("#"+id_trabajo).val();
		
		if(string!=""){
			
			data='id_documento='+id_trabajo+'&string='+string+'&opcion='+23;
	
			$.ajax({
					url:'../consultas_sql/Actualizar.php',
					data:data,
					type:'POST',
					dataType:"json",
					success: function(msg){
							alert(msg);
							$.ajax({
									url:"subdirectorios/ajax_cuerpo/informes.php",
									type:"POST",
									dataType:"html",
									success: function(msg){
													$("#area_documentos").html(msg);
													}
											});
										
										}
								})
		}
		else{alert("Escribir una observación")}
	}
	
function tecla(event, id){
		string=$("#"+id).val().length;
		
	if($("#"+id).val()==""){
		sum=70;
		i=1;
		$("#"+id).css("height", 50+"px");
	    }
		
	if(string>=(65*i)){$("#"+id).css("height", sum+"px");sum+=13; i++;}
			
	}
	
function detener(event, id){
	if(event.keyCode==13){
	
			sum+=13; 
			$("#"+id).css("height", sum+"px");
		}
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
			 border:1px solid #000;}

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
       `tb_trabajo tb_desarrollo tecnologico`.informe_final,
       tb_comunicacion.emisor,
       tb_comunicacion.recetor
  FROM    (   pegasoun_proyecto.`tb_trabajo tb_desarrollo tecnologico` `tb_trabajo tb_desarrollo tecnologico`
           JOIN
              pegasoun_proyecto.tb_trabajo tb_trabajo
           ON (`tb_trabajo tb_desarrollo tecnologico`.id_trabajo =
                  tb_trabajo.id_trabajo))
       JOIN
          pegasoun_proyecto.tb_comunicacion tb_comunicacion
       ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE     tb_trabajo.id_programa = '".$f["id_programa"]."' 
       AND (tb_comunicacion.emisor = '4' OR tb_comunicacion.emisor = '2')
       AND tb_comunicacion.recetor = '3'
       AND tb_comunicacion.tipo_documento = '2'");
 
 	$rows=mysqli_num_rows($desa_tecno);
	$sum+=$rows;
	
 $gest_empre=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
       tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       `tb_trabajo tb_gestion_empresarial`.informe_final,
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
 WHERE     tb_programa.id_programa = '".$f["id_programa"]."'
       AND (tb_comunicacion.emisor = '4' OR tb_comunicacion.emisor = '2')
       AND tb_comunicacion.recetor = '3'
       AND tb_comunicacion.tipo_documento = '2'");
	 $rows=mysqli_num_rows($gest_empre);
	$sum+=$rows;
	

$pract_profes=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
       tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       `tb_trabajo tb_pofesional`.informe_final,
       tb_comunicacion.emisor,
       tb_comunicacion.recetor
  FROM    (   (   pegasoun_proyecto.tb_trabajo tb_trabajo
               JOIN
                  pegasoun_proyecto.tb_programa tb_programa
               ON (tb_trabajo.id_programa = tb_programa.id_programa))
           JOIN
              pegasoun_proyecto.`tb_trabajo tb_pofesional` `tb_trabajo tb_pofesional`
           ON (`tb_trabajo tb_pofesional`.id_trabajo = tb_trabajo.id_trabajo))
       JOIN
          pegasoun_proyecto.tb_comunicacion tb_comunicacion
       ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE     tb_programa.id_programa = '".$f["id_programa"]."'
       AND (tb_comunicacion.emisor = '4' OR tb_comunicacion.emisor = '2' OR tb_comunicacion.emisor = '5')
       AND tb_comunicacion.recetor = '3'
       AND tb_comunicacion.tipo_documento = '2'");
	 $rows=mysqli_num_rows($pract_profes);
	$sum+=$rows;
	
$formu_inves=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
       tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       `tb_trabajo tb_formulacion_investigacion`.informe_final,
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
 WHERE     tb_programa.id_programa = '".$f["id_programa"]."'
       AND tb_comunicacion.emisor = '4'
       AND tb_comunicacion.recetor = '3'
       AND tb_comunicacion.tipo_documento = '2'"); 
	 $rows=mysqli_num_rows($formu_inves);
	$sum+=$rows; 

$desa_inves=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
       tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       `tb_trabajo tb_desarrollo_investigcion`.informe_final,
       tb_comunicacion.emisor,
       tb_comunicacion.recetor
  FROM    (   (   pegasoun_proyecto.tb_trabajo tb_trabajo
               JOIN
                  pegasoun_proyecto.tb_programa tb_programa
               ON (tb_trabajo.id_programa = tb_programa.id_programa))
           JOIN
              pegasoun_proyecto.`tb_trabajo tb_desarrollo_investigcion` `tb_trabajo tb_desarrollo_investigcion`
           ON (`tb_trabajo tb_desarrollo_investigcion`.id_trabajo =
                  tb_trabajo.id_trabajo))
       JOIN
          pegasoun_proyecto.tb_comunicacion tb_comunicacion
       ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE     tb_programa.id_programa = '".$f["id_programa"]."'
       AND (tb_comunicacion.emisor = '4' OR tb_comunicacion.emisor = '1')
       AND tb_comunicacion.recetor = '3'
       AND tb_comunicacion.tipo_documento = '2'"); 
	 $rows=mysqli_num_rows($desa_inves);
	$sum+=$rows;
	$mod=$sum%2;
	$division=($sum+$mod)/2;
	
	$div1='<div id="div1_'.$j.'" class="div1">';
	$div2='<div id="div2_'.$j.'" class="div2">';
	$i=1;
	$sum=0;
	$html='';
 	while($g=mysqli_fetch_array($desa_tecno)){
		
		if($g['emisor']==4 && $g['recetor']==3){
		
		$html=informes_student_cordina($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo']);
		}
		
		if($g['emisor']==2 && $g['recetor']==3){
			
			$html=informes_jurado_cordina($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo']);
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
		
		if($g['emisor']==4 && $g['recetor']==3){
		
		$html=informes_student_cordina($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo']);
		}
		
		if($g['emisor']==2 && $g['recetor']==3){
			
			$html=informes_jurado_cordina($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo']);
			}
		
		
		if($i<=$division){
			$div1.=$html;
			
			}
		else{
			$div2.=$html;
			}
			$i++;
		}
		
	
	 	while($g=mysqli_fetch_array($pract_profes)){
		
		if($g['emisor']==4 && $g['recetor']==3){
		
		$html=informes_Avance_student_cordina($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo']);
		}
		
		if($g['emisor']==5 && $g['recetor']==3){
			
			$html=informes_tutor_cordina($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo']);
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
		
		if($g['emisor']==4 && $g['recetor']==3){
		
		$html=informes_student_cordina2($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo']);
		}
		
		if($i<=$division){
			$div1.=$html;
			
			}
		else{
			$div2.=$html;
			}
			$i++;
		}
		

 	while($g=mysqli_fetch_array($desa_inves)){
		
		if($g['emisor']==4 && $g['recetor']==3){
		
		$html=informes_student_cordina3($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo']);
		}
		
		if($g['emisor']==1 && $g['recetor']==3){
			
			$html=informes_comite_cordina($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo']);
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
