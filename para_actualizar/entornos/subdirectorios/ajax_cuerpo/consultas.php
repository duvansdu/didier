<?php 
include '../../../connections/conection.php';

$progra=mysqli_query($link,"SELECT * 
  FROM pegasoun_proyecto.tb_programa");

$modali=mysqli_query($link,"SELECT * 
  FROM pegasoun_proyecto.tb_modalidad");

$jura=mysqli_query($link,"SELECT * 
FROM tb_jurado
INNER JOIN tb_usuario
ON tb_usuario.id_usuario = tb_jurado.id_usuario
WHERE tb_usuario.id_perfil = 1");
?>

<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>PEGASO Comit&#233</title>
<script type="text/javascript" src="../script/jquery-2.1.0.js"></script>
<script type="text/javascript" src="../script/script_comite.js"></script>
<script>
$(document).ready(function(e) {
	
    var ancho=$( window ).width();
	var suma=(ancho-950)/2;
	

		//var alto=$( window ).height();
		//var altura=(alto-604)/2;

   $("#container").css("margin-left",suma+"px");
})
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
		<h1> CONSULTAS </h1>
		<h3>Proyectos por programa</h3>

		<form id="form_consulta2" action="subdirectorios/ajax_cuerpo/consulta_programa.php" method="POST">
		<label>Seleccione el programa</label>
		<select id="id_programa" name="id_programa">
			<option value="">Seleccione</option>
			<?php while ($programa = mysqli_fetch_assoc($progra)) {
			?>
			<option value="<?php echo $programa['id_programa']?>"><?php echo $programa['nombre'] ?></option>

			<?php


			} ?>
			
		</select>
		<button type="submit">Consultar</button>
		</form>
		<h3>Proyectos por modalidad</h3>
		<form id="form_consulta3" action="subdirectorios/ajax_cuerpo/consulta_modalidad.php" method="POST">
		<label>Seleccione la modalidad</label>
		<select id="id_modalidad" name="id_modalidad">
			<option value="">Seleccione</option>
			<?php while ($modalidad = mysqli_fetch_assoc($modali)) {
			?>
			<option value="<?php echo $modalidad['id_modalidad']?>"><?php echo $modalidad['modalidad'] ?></option>

			<?php


			} ?>
			
			</select>
		<button type="submit">Consultar</button>
		</form>
		<h3>Proyectos por jurado</h3>
		<form id="form_consulta4" action="subdirectorios/ajax_cuerpo/consulta_jurado.php" method="POST">
		<label>Seleccione el jurado</label>
		<select id="id_usuario" name="id_jurado">
			<option value="">Seleccione</option>
			<?php while ($jurado = mysqli_fetch_assoc($jura)) {
			
			?>
			<option value="<?php echo $jurado['id_jurado']?>"><?php echo $jurado['nombre'] ?> <?php echo $jurado['apellido'] ?> </option>

			<?php

			
			} ?>
		
		</select>
		<button type="submit">BUSCAR</button>
		</form>
		
    	<!--<div id="encabezado"></div>
        <div id="cuerpo"></div>
        <div id="pie_pagina"></div>-->
    </div>
		<table class="table">
			<thead>
				<tr>
				<th scope="col">Item</th>
				<th scope="col">Codigo</th>
				<th scope="col">Título</th>
				<th scope="col">Usuario</th>
				</tr>
			</thead>
			<tbody id="respuesta"></tbody>
		</table>
	<script src="./consultas.js"></script>
</body>
</html>

<?php /* } 
/*
else{?> 

<script language="JavaScript">
alert("No se ha realizado el logueo del usuario, por favor inicie sesión.");
window.open('../users.php','_top','toolbar=yes,location=yes,status=yes,menubar=yes,personalbar=yes,scrollbars=yes,resizable=yes');
</script>

<?php }*/?>