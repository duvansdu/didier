<?php
session_start();
include '../connections/conection.php';

if(isset($_SESSION["user"])){

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PEGASO Jurado</title>

<script type="text/javascript" src="../script/jquery-2.1.0.js"></script>
<script type="text/javascript" src="../script/script_comite.js"></script>
<script>
$(document).ready(function(e) {
	
    var ancho=$( window ).width();
	var suma=(ancho-950)/2;
	$("#filtro_proyectos").fadeOut(0);
	$("#filtro_informes").fadeOut(0);
	

		//var alto=$( window ).height();
		//var altura=(alto-604)/2;

   $("#container").css("margin-left",suma+"px");
})

function envio_coordinador(id_trabajo, codigo_user){//esta funcion sirve
				
				if($("#anuncio2_"+id_trabajo).val()!=""){
					var data = new FormData();
					if($("#carta").val()!=""){
						var archivo = document.getElementById("carta");
						var file = archivo.files[0];
						data.append('archivo',file);
						}
						
					
					var datos=$("#anuncio2_"+id_trabajo).val();
				    data.append('codigo_user',codigo_user);
					data.append('id_trabajo',id_trabajo);
					data.append('observacion',datos);
					data.append('opcion',12);
					data.append('doc',2);
					
						
						$.ajax({
							url:"../consultas_sql/Actualizar.php",
							data:data,
							contentType:false,
							processData:false,
							cache:false,
							type:'POST',
							dataType:"json",
							success: function(msg){
								alert(msg)
								
								$.ajax({
							  			url:'../entornos/subdirectorios/documentos.php',
							 			type:'POST',
							  			dataType:"html",
							  			success: function(msg){
								  			$("#arear_trabjo").html(msg);
								  			
								  		}
									})
								}
							})
						
					
					}
					
				else{alert("El campo esta vacio, llenelo"); }	
	
	}
	
function envio_coordinador2(id_trabajo, codigo_user){//esta funcion sirve
	
	if($("#anuncio_2"+id_trabajo).val()!=""){
					var datos=$("#anuncio_2"+id_trabajo).val();
						
						data='codigo_user='+codigo_user+'&id_trabajo='+id_trabajo+'&observacion='+datos+"&opcion="+12;
						
						$.ajax({
							url:"../consultas_sql/Actualizar.php",
							data:data,
							type:'POST',
							dataType:"json",
							success: function(msg){
								alert(msg)
								
								$.ajax({
							  			url:'../entornos/subdirectorios/proyectos_jurados.php',
							 			type:'POST',
							  			dataType:"html",
							  			success: function(msg){
								  			$("#arear_trabjo").html(msg);
								  			
								  		}
									})
								}
							})
						
					
					}
					
				else{alert("El campo esta vacio, llenelo"); }
	}
	
function envio_coordinador3(id_trabajo, codigo_user, id_programa){//esta funcion sirve
	
	if($("#anuncio2_"+id_trabajo).val()!=""){
					var datos=$("#anuncio2_"+id_trabajo).val();
						
						data='codigo_user='+codigo_user+'&id_trabajo='+id_trabajo+'&observacion='+datos+"&opcion="+12;
						
						$.ajax({
							url:"../consultas_sql/Actualizar.php",
							data:data,
							type:'POST',
							dataType:"json",
							success: function(msg){
								alert(msg)
								
								$.ajax({
										url:'../consultas_sql/formularios_jurado.php',
										data:'id_programa='+id_programa+'&opcion='+1,
							 			type:'POST',										
							  			dataType:"html",
							  			success: function(msg){
								  			$("#arear_trabjo").html(msg);
								  			
								  		}
									})
								}
							})
					
					}
					
				else{alert("el campo esta vacio llenelo"); }
	}
	
function envio_coordinador4(id_trabajo, codigo_user, id_programa){//esta funcion sirve
				
				if($("#anuncio2_"+id_trabajo).val()!=""){
					var data = new FormData();
					if($("#carta").val()!=""){
						var archivo = document.getElementById("carta");
						var file = archivo.files[0];
						data.append('archivo',file);
						}
						
					
					var datos=$("#anuncio2_"+id_trabajo).val();
				    data.append('codigo_user',codigo_user);
					data.append('id_trabajo',id_trabajo);
					data.append('observacion',datos);
					data.append('opcion',12);
					data.append('doc',2);
					
						
						$.ajax({
							url:"../consultas_sql/Actualizar.php",
							data:data,
							contentType:false,
							processData:false,
							cache:false,
							type:'POST',
							dataType:"json",
							success: function(msg){
								alert(msg)
								
								$.ajax({
										url:'../consultas_sql/formularios_jurado.php',
										data:'id_programa='+id_programa+'&opcion='+2,
							 			type:'POST',
							  			dataType:"html",
							  			success: function(msg){
								  			$("#arear_trabjo").html(msg);
								  			
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
	
function verObservaciones(id_trabajo){
	window.open("../documentos_pdf/observaciones_jurado.php?id_trabajo="+id_trabajo,"_blank");
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
			 
.filtros{
	
	width:200px;
	height:30px;
	font-family:arial;
	font-size:16px;
	margin-left:5px;}
</style>
</head>

<body>
	<div id="container">
    	<div id="encabezado"></div>
        <div id="cuerpo"><?php include '../entornos/subdirectorios/cuerpo_jurado.php' ?></div>
        <div id="pie_pagina"></div>
    </div>


</body>
</html>


<?php }

else{?>
<script type="text/javascript">	
window.open('../users.php','_top','toolbar=yes,location=yes,status=yes,menubar=yes,personalbar=yes,scrollbars=yes,resizable=yes');
</script>
<?php }?>