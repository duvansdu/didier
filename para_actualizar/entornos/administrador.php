<?php
session_start();
include '../connections/conection.php';

if(isset($_SESSION["administrador"])){

?>
<html>
<head>
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><br>
<title>PEGASO Administrador</title>
<script type="text/javascript" src="../script/jquery-2.1.0.js"></script>

<script type="text/javascript" src="../script/document.js"></script>

<script type="text/javascript">

function crear(){
		$("#permisos_programa").fadeIn(0);
		$("#permisos_modificar").fadeOut(0);
	}
	
function modificar(){
		$("#permisos_modificar").fadeIn(0);
		$("#permisos_programa").fadeOut(0);
	}
	

	
function btn_modificar(){
		var codigo=$("#codi_programa").val();
		var nuevo_usuario=$("#nuevo_usuario").val();
		var nuevo_pws=$("#nuevo_password").val();

		if(codigo!=0){
		$.ajax({
			url:'../consultas_sql/Actualizar.php',
			type:'POST',
			dataType:"json",
			data:'codigo='+codigo+'&nuevo_usuario='+nuevo_usuario+'&nuevo_pws='+nuevo_pws+"&opcion="+1,
			success: function(msg){
					alert(msg);
				}
					
			})
		}
		
		else{alert ("Favor selecione el Codigo del Programa")}
	}
	
function buscar_codigo(codigo){
			
			$.ajax({
					url:"../consultas_sql/ConsulSql.php",
					data:'codigo='+codigo+'&opcion='+1,
					dataType:"json",
					type:'POST',
					success: function(msg){
								
								if(msg!=null){$("#nombre_programa").val(msg);}
								else{alert("Codigo Incorrecto"); $("#nombre_programa").val("");}
								
								}
						})
	}
	
function nuevo(){
	$("#txt_codigo").val("");
	$("#txt_programa").val("");
	$("#usuario").val("");
	$("#password").val("");
	$("#codi_programa option[value=0]").attr("selected",true);
	$("#nombre_programa").val("");
	$("#nuevo_usuario").val("");
	$("#nuevo_password").val("");
	}


//CODIGO SCRIPT PARA LOS DOCENTES
function registrando_docente(){
	if($("#codigo_docente").val()!='' && $("#nombre_docente").val()!="" && $("#apellido_docente").val()!="" && $("#telefono_docente").val()!="" && $("#email_docente").val()!="" && $("#select_prog").val()!=0){
		
			data="id_usuario="+$("#codigo_docente").val()+"&nombre="+$("#nombre_docente").val()+"&apellido="+$("#apellido_docente").val()+"&telefono="+$("#telefono_docente").val()+"&email="+$("#email_docente").val()+"&id_programa="+$("#select_prog").val()+"&especialidad="+$("#txt_especilidad").val()+"&opcion="+3;
			$.ajax({
					url:"../consultas_sql/InsertSql.php",
					data:data,
					type:'POST',
					dataType:"json",
					success: function(msg){
						alert(msg)
						}
				})
		}
		
	else{
			alert("Algun campo esta vacio revise los campos");
		}
	}
	
function modificar_docente(id_codigo){
	codigo=$("#mo_codig").val();
	nombre=$("#mo_nombre").val();
	apellido=$("#mo_apellido").val();
	telefono=$("#mo_telefono").val();
	correo=$("#mo_correo").val();
	especialidad=$("#mo_espeli").val();
	
	data='codigo='+codigo+'&nombre='+nombre+'&apellido='+apellido+'&telefono='+telefono+'&correo='+correo+'&especialidad='+especialidad+'&opcion='+5;
	
	$.ajax({
					url:"../consultas_sql/Actualizar.php",
					data:data,
					dataType:"json",
					type:'POST',
					success: function(msg){
							alert(msg);
								
								}
						})
	}
	
function buscar_docentes(docente, i){
			$.ajax({
					url:"../consultas_sql/ConsulSql.php",
					data:'docente='+docente+'&opcion='+1+'&color='+i,
					dataType:"html",
					type:'POST',
					success: function(msg){
							$("#list_docentes"+i).html(msg);
								
								}
						})
	}
	
	
	
var color_i=1;
var color_j=1;
var color_k=1;
function colorear1(i, codigo){
		$("#td_1_"+color_i).removeAttr("bgcolor");
		color_i=i;
		$("#td_1_"+color_i).attr("bgcolor","#CCC");
		
			$.ajax({
					url:"../consultas_sql/ConsulSql.php",
					data:'codigo='+codigo+'&opcion='+2,
					dataType:"html",
					type:'POST',
					success: function(msg){
							$("#rol_docentes1").html(msg);
								
								}
						})

	}
	
function colorear2(i, codigo){
		$("#td_2_"+color_j).removeAttr("bgcolor");
		color_j=i;
		$("#td_2_"+color_j).attr("bgcolor","#CCC");
		
		
			$.ajax({
					url:"../consultas_sql/ConsulSql.php",
					data:'codigo='+codigo+'&opcion='+3,
					dataType:"html",
					type:'POST',
					success: function(msg){
							$("#rol_docentes2").html(msg);
								
								}
						})

	}
	
function crear_director(selec_dir, estado_dir, codigo){//pendiente se remplazo por crear_tuto() inline 130
	
		data='selec_dir='+selec_dir+'&estado_dir='+estado_dir+'&codigo='+codigo+'&opcion='+3;
		$.ajax({
				
				url:"../consultas_sql/Actualizar.php",
				data:data,
				dataType:"json",
				type:'POST',
				success: function(msg){
					alert(msg);
					}
			})
			
}

function crear_tutor(usuario, pws, codigo, estado){
	
		data='usuario='+usuario+'&pws='+pws+'&codigo='+codigo+'&estado='+estado+'&opcion='+25;
		
		
		$.ajax({
				
				url:"../consultas_sql/Actualizar.php",
				data:data,
				dataType:"json",
				type:'POST',
				success: function(msg){
					alert(msg);
					}
			})
	}
	

function crear_jurado(usuario, pws, codigo, estado){
		
		data='usuario='+usuario+'&pws='+pws+'&codigo='+codigo+'&estado='+estado+'&opcion='+4;
		
		$.ajax({
				
				url:"../consultas_sql/Actualizar.php",
				data:data,
				dataType:"json",
				type:'POST',
				success: function(msg){
					alert(msg);
					}
			})
	}
	
	


//funciones que sirven dentro de los docentes

	
function colorear3(i, codigo){
		$("#td_"+color_k).removeAttr("bgcolor");
		color_k=i;
		$("#td_"+color_k).attr("bgcolor","#CCC");
		
			$.ajax({
					url:"../consultas_sql/ConsulSql.php",
					data:'codigo='+codigo+'&opcion='+5,
					dataType:"html",
					type:'POST',
					success: function(msg){
							$("#formatos_modalidades").html(msg);
								}
						})

	}
	

	

</script>
<style type="text/css">
#container{
	width:950px;
	height:auto;
	border-radius:5px;
	border:1px solid #09F;
	margin:0px auto}
	
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
	border-radius:0px 0px 5px 5px;}
	
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
        <div id="cuerpo"><?php include 'subdirectorios/cuerpo_administrador.php' ?></div>
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