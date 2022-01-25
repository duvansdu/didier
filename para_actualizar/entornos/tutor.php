<?php
session_start();
include '../connections/conection.php';
include "subdirectorios/ajax_cuerpo/funciones.php";

if(isset($_SESSION["user"])){
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PEGASO Tutor</title>

<script type="text/javascript" src="../script/jquery-2.1.0.js"></script>
<script type="text/javascript" src="../script/script_comite.js"></script>
<script>
$(document).ready(function(e) {
	
    var ancho=$( window ).width();
	var suma=(ancho-950)/2;
	$(".div_textarea").fadeOut(0);
	

		//var alto=$( window ).height();
		//var altura=(alto-604)/2;

   $("#container").css("margin-left",suma+"px");
})

function envio_coordinador(id_trabajo, id_tutor){//esta funcion sirve
					var data = new FormData();
					
					if($("#carta").val()!=""){
						var archivo = document.getElementById("carta");
						var file = archivo.files[0];
						data.append('archivo',file);
						}
						
				
				if($("#"+id_trabajo).val()!=""){
					var datos='<pre>'+$("#"+id_trabajo).val()+"</pre>";
					
					data.append('id_tutor',id_tutor);
					data.append('id_trabajo',id_trabajo);
					data.append('observacion',datos);
					data.append('opcion',20);
					
						
						$.ajax({
							url:"../consultas_sql/Actualizar.php",
							data:data,
							type:'POST',
							dataType:"json",
							contentType:false,
							processData:false,
							cache:false,
							success: function(msg){
								alert(msg)
								
								$.ajax({
							  			url:'subdirectorios/ajax_cuerpo/informes_tutor.php',
							 			type:'POST',
										data:'user='+1,
							  			dataType:"html",
							  			success: function(msg){
								  			$("#cuerpo").html(msg);
								  		}
									})
								}
							})
						
					
					}
					
				else{alert("el campo esta vacio llenelo"); }	
	
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
	
var codigo_trabajo_carta='';
function cargar_carta(id_trabajo){
	codigo_trabajo_carta=id_trabajo;
	$("#carta").click();
	}
	
function cargando_carta(){
	$("#carta_"+codigo_trabajo_carta).val($("#carta").val());
	
	}
	
function ModiTotoInter(id_tutor){
	
	$.ajax({
			url:'../consultas_sql/ConsulSql.php',
			type:'POST',
			dataType:"html",
			data:'id_tutor='+id_tutor+"&opcion="+9,
			success: function(msg){
					$("#cuerpo").html(msg);
				}
			})
	}
	
function ActualizarTutor(id_tutor){
	

	var nombre=$("#NTutor").val();
	var apellido=$("#ATutor").val();
	var telefono=$("#TTutor").val();
	var correo=$("#CTutor").val();
	var especialidad=$("#ETutor").val();
	
	data="id_tutor="+id_tutor+"&nombre="+nombre+"&apellido="+apellido+"&telefono="+telefono+"&correo="+correo+"&especialidad="+especialidad+"&opcion=37";
	
	$.ajax({
				url:'../consultas_sql/Actualizar.php',					
				type:'POST',
				data:data,
				dataType:"json",				
				success: function(msg){
					alert(msg);
						}
		});
	
	}
</script>


<style type="text/css">
#container{
	width:950px;
	height:auto;
	border-radius:5px;
	border:1px solid #09F;}
	
#encabezado{
	width:100%;
	height:150px;
	background:#CCC;
	border-radius:5px 5px 0px 0px;}
	
#cuerpo{
	width:100%;
	height:auto;
	background:#FFC;
	text-align:center;
	padding-bottom:15px;
	overflow:auto;}
	
#pie_pagina{
	width:100%;
	height:100px;
	background:#CCC;
	border-radius:0px 0px 5px 5px;
	}
	
#menu{
	width:100%;
	height:50px;
	background:#06F;
	text-align:center;}
	
.boton{
	width:150px;
	height:100%;
	cursor:pointer;}
	
#registro_programa, #permisos_programa, #permisos_modificar{
	width:100%;
	background:#0FC;
	text-align:center;}
.txt_programa{
	font-family:Georgia, "Times New Roman", Times, serif;
	font-size:18px;}

.tr{
	height:40px;}
/*estilo dirctor*/
#director_docente, #jurado_docente, #docente_docente, #docente_rol{
	border:1px solid #000;
	width:260px;
	margin-left:20px;
	border-radius:5px;
	margin-top:20px;
	
	}
#director_docente, #jurado_docente{padding-bottom:10px;}
.titulos_roles{
	border-bottom:1px solid #000;
	}
.btn_actualizar{ margin-top:10px;
				cursor:pointer;
				width:150px;
				height:30px;
				color:#FFF;
				border:1px solid #000;
				background:#06F;
				border-radius:5px;}



				
.div1{
	width:50%;
	float:left;}
#tablaTutor{ margin-left:9px; border:0px solid #000; width:97%;}
	
.div2{
	width:50%;
	float:right;
	}
.div_cuerpo{
	overflow:auto;
	overflow-y:hidden;
	padding-bottom:5px;
	margin-top:20px;}
	
.encabezado_proyecto{text-align:center;width:310px;}
	
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

.encabezado_proyecto, .cuerpo_proyecto{
	
	height:40px;
	border:1px solid #000;
	font-family:Arial, Helvetica, sans-serif;
	font-size:15px;
	display: table;
	}
.cuerpo_proyecto{ padding-left:15px; border-top:0px;width:296px; text-align:justify;}

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
			 
#modiTutor{
	cursor:pointer;
	font-size:24px;}

#modiTutor:hover{
	color:#521ADB;}
</style>
</head>

<body>

	<div id="container">
    	<div id="encabezado"></div>
        <div id="cuerpo"><?php include 'subdirectorios/ajax_cuerpo/informes_tutor.php' ?></div>
        <div id="pie_pagina"></div>
    </div>
    
</body>
</html>

<?php }

else{?>
<script type="text/javascript">	
window.open('../administrador.php','_top','toolbar=yes,location=yes,status=yes,menubar=yes,personalbar=yes,scrollbars=yes,resizable=yes');
</script>
<?php }?>