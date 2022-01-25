<?php
session_start();
include "../../../connections/conection.php";
include "../../../consultas_sql/formularios_comite.php";
?>
<script>
$(document).ready(function(e) {
    $(".file").fadeOut(0);
	$(".div_textarea").fadeOut(0);
	
	$(".boton_input").click(function(e) {
		
		id=$(this).attr("id");
        $("#file_"+id).click();
    });
});

function cambiar(id){
	$("#namefile_"+id).val($("#file_"+id).val());
	}
	

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
	
		
		
			if(string>=(65*i)){$("#"+id).css("height", sum+"px");sum+=13; i++;}
			
	}
	
function envio_coordinador(id_trabajo, doc, id_comite){//esta funcion sirve
				
				if($("#"+id_trabajo).val()!=""){
					var datos='<pre>'+$("#"+id_trabajo).val()+"</pre>";
						
						data='id_comite='+id_comite+'&id_trabajo='+id_trabajo+'&observacion='+datos+"&opcion="+8+'&doc='+doc;
						
						$.ajax({
							url:"../consultas_sql/Actualizar.php",
							data:data,
							type:'POST',
							dataType:"json",
							success: function(msg){
								alert(msg)
								
								$.ajax({
							  			url:'subdirectorios/ajax_cuerpo/informes_comite.php',
							 			type:'POST',
							  			dataType:"html",
							  			success: function(msg){
								  			$("#arear_trabjo").html(msg);
								  			//$(".div_textarea").fadeOut(0);
								  		}
									})
								}
							})
						
					
					}
					
				else{alert("el campo esta vacio llenelo"); }	
	
	}
	
	
on_off=1;
aux="";
function crear_obser(id_trabajo){
	$(".textarea").val("");
	$(".textarea").css("height", 50+"px");
	
	if(aux==id_trabajo){
			if(on_off==1){$("#div_"+id_trabajo).fadeIn(); on_off=0;}
			else{$("#div_"+id_trabajo).fadeOut(0); on_off=1;}
		
		}
		
	else{
			on_off=1
			$("#div_"+aux).fadeOut(0);
			$("#div_"+id_trabajo).fadeIn(); on_off=0;
		
		}
	aux=id_trabajo;
	}
	
function verObservaciones(id_trabajo){
	window.open("../documentos_pdf/observaciones.php?id_trabajo="+id_trabajo,"_blank");
	}
</script>

<style type="text/css">
.div1{
	width:50%;
	float:left;
	margin-top:20px;
	}
table{ margin-left:9px; border:0px solid #000; width:97%;}
	
.div2{
	width:50%;
	float:right;
	margin-top:20px;}
	
.cuerpo_mdalidad{
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




#boton{
	cursor:pointer;
	margin-bottom:15px;
	margin-top:10px;
}
	
#file{
	height:50px;
	width:120px;
	opacity:0;
	cursor:pointer;
	border:1px solid #000;
	
	
	}
	
.boton_input{
	width:297px;
	height:49px;
	border-radius:5px;
	background:#A00000;
	color:#FFF;
	border:1px solid #A00000;
	cursor:pointer;
	font-size:18px;
	font-family:Arial, Helvetica, sans-serif;
	font-weight:bold;
	margin-bottom:5px;
	
		}
		
.input{
	width:297px;
	height:49px;
	margin-bottom:10px;
	border-radius:5px;
	border:1px solid #CCC;
	padding-left:15px;
	font-size:16px;
	font-family:Verdana, Geneva, sans-serif;
	}
	
#pie_pagina1{
		width:auto;		
		height:auto;
		border-bottom-right-radius:5px;
		border-bottom-left-radius:5px;
		text-align:center;
		margin-top:5px;
		}
		
.textarea{ resize:none;
overflow:hidden;
height:50px;
width:450px;
font-family:Arial, Helvetica, sans-serif;
font-size:12;
text-align:justify;
margin-bottom:15PX;
}

.table{ margin-bottom:10px;}
.p{color:#06F;}
</style>


<?php


function consulta_programa_docente($id_usuario, $link){
	
	return mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       tb_trabajo.id_trabajo,
       tb_trabajo.id_programa,
       tb_programa.nombre,
       `tb_trabajo tb_desarrollo tecnologico`.propuesta
  FROM    (   (   pegasoun_proyecto.tb_comite_trabajo tb_comite_trabajo
               JOIN
                  pegasoun_proyecto.tb_trabajo tb_trabajo
               ON (tb_comite_trabajo.id_trabajo = tb_trabajo.id_trabajo))
           JOIN
              pegasoun_proyecto.tb_programa tb_programa
           ON (tb_trabajo.id_programa = tb_programa.id_programa))
       JOIN
          pegasoun_proyecto.`tb_trabajo tb_desarrollo tecnologico` `tb_trabajo tb_desarrollo tecnologico`
       ON (`tb_trabajo tb_desarrollo tecnologico`.id_trabajo =
              tb_trabajo.id_trabajo)
 WHERE tb_comite_trabajo.id_comite = 2  AND tb_comite_trabajo.estado = 1");
						
	}
	
	
function obtener_total_sql($opcion, $id_comite, $link){
	
	switch($opcion){
			case 5:{
					
					$consul=desarrollo_investigacion($id_comite, $link);
				
				}break;
		
		}
	
 	return mysqli_num_rows($consul);
	}
	
	
function desarrollo_investigacion($id_comite, $link){
	
		$consul=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
       tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       tb_programa.id_programa,
       tb_programa.nombre,
       `tb_trabajo tb_desarrollo_investigcion`.informe_final
  FROM    (   (   (   (   pegasoun_proyecto.tb_trabajo tb_trabajo
                       JOIN
                          pegasoun_proyecto.tb_programa tb_programa
                       ON (tb_trabajo.id_programa = tb_programa.id_programa))
                   JOIN
                      pegasoun_proyecto.`tb_trabajo tb_desarrollo_investigcion` `tb_trabajo tb_desarrollo_investigcion`
                   ON (`tb_trabajo tb_desarrollo_investigcion`.id_trabajo =
                          tb_trabajo.id_trabajo))
               JOIN
                  pegasoun_proyecto.tb_comite_trabajo tb_comite_trabajo
               ON (tb_comite_trabajo.id_trabajo = tb_trabajo.id_trabajo))
           JOIN
              pegasoun_proyecto.tb_comite tb_comite
           ON (tb_comite_trabajo.id_comite = tb_comite.id_comite))
       JOIN
          pegasoun_proyecto.tb_comunicacion tb_comunicacion
       ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE     tb_comite.estado = '1'
       AND tb_comite.id_comite = '".$id_comite."'
       AND tb_comite_trabajo.estado = '1'
       AND tb_comunicacion.emisor = '3'
       AND tb_comunicacion.recetor = '1'
       AND tb_comunicacion.tipo_documento = '2'
ORDER BY tb_programa.id_programa ASC");
				 
				return $consul;
	}     


$sql=consulta_programa_docente($_SESSION["user"], $link);
$sql2=consulta_programa_docente($_SESSION["user"], $link);
$sum=0;

$comite=mysqli_fetch_assoc(mysqli_query($link,"SELECT id_comite FROM  `tb_comite` WHERE  `id_usuario` LIKE  '".$_SESSION["user"]."'"));

//Desarrollo Tecnologico
$sum=obtener_total_sql(5, $comite['id_comite'], $link);			
$mod=$sum%2;
$division1=($sum+$mod)/2;
$i=1;		
$div1='<div id="div1_1" class="div1">';
$div2='<div id="div2_2" class="div2">';	
$html='';
	
			
		
			$a=desarrollo_investigacion($comite['id_comite'], $link);
			while($g=mysqli_fetch_array($a)){
				if($i==1){echo '<h2>Desarrollo Investigación</h2>';}
				$html=desarrollo_de_investigacion($g['informe_final'], $g['codigo_trabajo'], $g['titulo'], $g['nombre'], $g['id_trabajo'], $comite['id_comite']);


				
			 if($i<=$division1){
					$div1.=$html;
			 		}
					
				else{
					
					$div2.=$html;
					
					}
					
					
				$i++;
				}

$div1.='</div>';
$div2.='</div>';
if($i>1){echo '<div class="cuerpo_mdalidad">'.$div1.$div2.'</div>';}

?>