<?php
session_start();


if(isset($_SESSION["user"])){?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PEGASO Estudiante</title>


<script type="text/javascript" src="../script/jquery-2.1.0.js"></script>

<script>
$(document).ready(function(e) {
	
    var ancho=$( window ).width();
	var suma=(ancho-950)/2;
	

		//var alto=$( window ).height();
		//var altura=(alto-604)/2;

   $("#container").css("margin-left",suma+"px");
})

function cambiar_color(id_concepto, id_trabajo, tipo_doc){//funcion sirve despues de revisar un acta el color desaparece
	
			$.ajax({
					url:'../consultas_sql/Actualizar_student.php',					
					type:'POST',
					data:'id_concepto='+id_concepto+'&opcion='+4+'&tipo_doc='+tipo_doc,
					dataType:"json",				
					success: function(msg){
						if(msg==1){
						$.ajax({
								  url:'subdirectorios/cuerpo_estudiante.php',
								  type:'POST',
								  data:'user='+id_trabajo,
								  dataType:"html",
								  success: function(msg){
									  $("#cuerpo").html(msg);
									  }
								})
						}
					}
			})
	}
	
function ModificarUser(id_documento){
	
	
	$.ajax({
				url:'../consultas_sql/Actualizar_student.php',					
				type:'POST',
				data:'id_documento='+id_documento+'&user='+$("#userStudent").val()+'&pass='+$('#passStudent').val()+'&opcion='+6,
				dataType:"json",				
				success: function(msg){
					alert(msg);
						}
		});
	
	}
	
function ActualizarDatos(id_documento){
	
	$.ajax({
				url:'../consultas_sql/ConsulSql.php',					
				type:'POST',
				data:'id_documento='+id_documento+'&opcion='+8,
				dataType:"html",				
				success: function(msg){
					$("#derecho").html(msg);
						}
		});
	}
	
function ActualizarEstuden(i){
	var id_estudiante=$("#CODEstu_"+i).val();
	var nombre=$("#NEs_"+i).val();
	var apellido=$("#AEs_"+i).val();
	var telefono=$("#TEs_"+i).val();
	var correo=$("#CEs_"+i).val();
	
	data="id_estudiante="+id_estudiante+"&nombre="+nombre+"&apellido="+apellido+"&telefono="+telefono+"&correo="+correo+"&opcion=7";
	
	$.ajax({
				url:'../consultas_sql/Actualizar_student.php',					
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
</style>
</head>

<body>

	<div id="container">
    	<div id="encabezado"></div>
        <div id="cuerpo"><?php include "subdirectorios/cuerpo_estudiante.php" ?></div>
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