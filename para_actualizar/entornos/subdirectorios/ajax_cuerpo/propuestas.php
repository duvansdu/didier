<?php
include "../../../connections/conection.php";
include "../../../consultas_sql/formularios.php";
?>
<script type="text/javascript">
	$(document).ready(function(e) {
        $(".btn_botones").fadeOut(0);
		$(".div_textarea").fadeOut(0);
    });
	
function verObservaciones(id_trabajo){
	
	window.open('../documentos_pdf/observaciones.php?id_trabajo='+id_trabajo,'_blank');
	$("#btn_"+id_trabajo).fadeIn(0);
	$("#observ_"+id_trabajo).fadeOut(0);
	
	}
auxi_id_trabajo="";	
function crear_obser(id_trabajo){
	$("#div_"+id_trabajo).fadeIn(0);
	$("#div_"+auxi_id_trabajo).fadeOut(0);
	auxi_id_trabajo=id_trabajo;
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
	

	
	
var id_trabajo_indi=0;
function cargar_carta(id_trabajo){
	
	$("#carta").click();
	id_trabajo_indi=id_trabajo;
	
	}

function cargando_carta(){
	
	$("#carta_"+id_trabajo_indi).val($("#carta").val());
	id_trabajo_indi=0;
	}
	
function estado_aprobado(opci, id_trabajo, x, id_modalidad){
	
	if(confirm("Desea Aprobar la Propuesta "+x)){
			var inputFileImage = document.getElementById("carta");
			var file = inputFileImage.files[0];
			var data = new FormData();
			
			if($("#codigo_radi_"+id_trabajo).val()!=""){
				
				if(id_modalidad==1 || id_modalidad==4){
						if($("#selec_director_"+id_trabajo).val()!=0){
								data.append('id_director', $("#selec_director_"+id_trabajo).val());
								resp=true;
							}
							
						else{
								resp=false;
								mensaje="Selecione el Director para El proyecto";
							}
					}
					
				if(id_modalidad==2){
					
						if($("#select_tutor1_"+id_trabajo).val()!=0 || $("#select_tutor2_"+id_trabajo).val()!=0){
							
							data.append('id_tutor1', $("#select_tutor1_"+id_trabajo).val());
							data.append('id_tutor2', $("#select_tutor2_"+id_trabajo).val());	
							resp=true;				
							}
						else{
								resp=false;
								mensaje="Selecione los Tutores para la práctica";
							}
		
						}
						
				if(id_modalidad==3 || id_modalidad==5){
					if($("#selec_director_"+id_trabajo).val()!=0){
						data.append('id_director_inves', $("#selec_director_"+id_trabajo).val());
						resp=true;
						}
						else{
								resp=false;
								mensaje="Selecione el Director de investigación";
							}			
					}
				if($("#carta").val()!=""){resp=true;}
				else{			
						resp=false;
						mensaje="Debe cargar un archivo PDF"; }
				
				if(resp){
						data.append('opcion',9);
						data.append('opci',opci);
						data.append('archivo',file);
						data.append('id_trabajo',id_trabajo);
						data.append('id_modalidad',id_modalidad);
						data.append('codigo_radi', $("#codigo_radi_"+id_trabajo).val());
						
						
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
											url:"subdirectorios/ajax_cuerpo/propuestas.php",
											type:"POST",
											dataType:"html",
											success: function(msg){
												$("#area_documentos").html(msg);
												}
											});
									
									}
							})	
					}
				else{alert(mensaje);}
				}
			else{alert("Ingrese el código de Radicación");}
		}
	}



function estado_documento(opci, id_trabajo, x){
	var inputFileImage = document.getElementById("carta");
	var file = inputFileImage.files[0];
	var data = new FormData();
			
			if($("#carta").val()!=""){
				data.append('opcion',9);
				data.append('opci',opci);
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
									url:"subdirectorios/ajax_cuerpo/propuestas.php",
									type:"POST",
									dataType:"html",
									success: function(msg){
										$("#area_documentos").html(msg);
										}
									});
							
							}
					})	
			}
			else{alert("Debe Cargar Los conceptos emitidos por el comite")}
	}
	
	
//funciones de escritura

sum=0;	
function detener(event, id){
	if(event.keyCode==13){
	
			sum+=13; 
			$("#"+id).css("height", sum+"px");
		}
	}
	
function tecla(event, id){
	string=$("#"+id).val().length;
		
	if($("#"+id).val()==""){
		sum=70;
		i=1;
		$("#"+id).css("height", 50+"px");
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

.selec_jurado{
	width:150px;
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
			 border:1px solid #000;
			 margin-bottom:40px;}

.radicacion{
	width:150px;
	height:25px;
	margin-top:5px;
	margin-bottom:5px;
	margin-left:5px;
	border-radius:5px;
	border:1px solid #000;
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
	text-align:center;}
	
.codi_rad{
	font-family:Verdana, Geneva, sans-serif;
	font-size:14px;}

</style>


<?php
$programas=mysqli_query($link,"SELECT tb_programa.id_programa, tb_programa.nombre FROM pegasoun_proyecto.tb_programa tb_programa");

$sum=0;
$j=1;
$y=1;

while($f=mysqli_fetch_array($programas)){
	echo '<h2>'.$f['nombre'].'</h2>';
	
include "../../../consultas_sql/consultas_documentos.php";	

	$mod=$sum%2;
	$division=($sum+$mod)/2;
	
	$div1='<div id="div1_'.$j.'" class="div1">';
	$div2='<div id="div2_'.$j.'" class="div2">';
	$i=1;
	$sum=0;
	$html='';
 	while($g=mysqli_fetch_array($desa_tecno)){
		
		if($g['emisor']==4 && $g['recetor']==3){
		
		$html=estudent_cordina($g['propuesta'],$g['titulo'], $g['codigo_trabajo'], $g['id_trabajo'], $g['id_programa'], 'Propuesta');
		}
		
		if($g['emisor']==1 && $g['recetor']==3){
			
			$html=comite_cordinador($g['propuesta'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], 'Propuesta', $g['id_modalidad'], $link);}
		
		
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
		
		$html=estudent_cordina($g['propuesta'],$g['titulo'], $g['codigo_trabajo'], $g['id_trabajo'], $g['id_programa'], 'Propuesta');
		}
		
		if($g['emisor']==1 && $g['recetor']==3){
			
			$html=comite_cordinador($g['propuesta'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], 'Propuesta', $g['id_modalidad'], $link);}
		
		
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
		
		$html=estudent_cordina($g['propuesta'],$g['titulo'], $g['codigo_trabajo'], $g['id_trabajo'], $g['id_programa'], 'Propuesta');
		}
		
		if($g['emisor']==1 && $g['recetor']==3){
			
			$html=comite_cordinador($g['propuesta'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], 'Propuesta', $g['id_modalidad'], $link);}
		
		
		if($i<=$division){
			$div1.=$html;
			
			}
		else{
			$div2.=$html;
			}
			$i++;		
		}
		
		
while($g=mysqli_fetch_array($Practica_profesional)){
		if($g['emisor']==4 && $g['recetor']==3){
		
		$html=estudent_cordina($g['plan_trabajo'],$g['titulo'], $g['codigo_trabajo'], $g['id_trabajo'], $g['id_programa'],'Plan de Trabajo');
		}
		
		if($g['emisor']==1 && $g['recetor']==3){
			
			$html=comite_cordinador($g['plan_trabajo'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], 'Plan de Trabajo', $g['id_modalidad'], $link);}
		
		
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
		
		$html=estudent_cordina($g['solicitud_inclusion'],$g['titulo'], $g['codigo_trabajo'], $g['id_trabajo'], $g['id_programa'], 'Solicitud de Inclusión');
		}
		
		if($g['emisor']==1 && $g['recetor']==3){
			
			$html=comite_cordinador($g['solicitud_inclusion'], $g['codigo_trabajo'], $g['titulo'], $g['id_trabajo'], 'Solicitud de Inclusión', $g['id_modalidad'], $link);}
		
		
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
