<?php 
session_start();
include "../../../connections/conection.php";
$programas=mysqli_query($link,"SELECT * FROM tb_programa");
$programas2=mysqli_query($link,"SELECT * FROM tb_programa");

$fechas=mysqli_query($link,"SELECT tb_permiso_subir_archivo.fecha_inicio,
       tb_permiso_subir_archivo.fecha_final,
       tb_permiso_subir_archivo.id_permiso
  FROM pegasoun_proyecto.tb_permiso_subir_archivo tb_permiso_subir_archivo
 WHERE tb_permiso_subir_archivo.estado = 1
ORDER BY tb_permiso_subir_archivo.fecha_final ASC");
?>
<script type="text/javascript">
$(document).ready(function(e) {
	 $("#habilitarDocente").fadeOut(0);
	 $("#nuevoAdministrador2").fadeOut(0);
})

function programar(){
	
	fecha_inicio=$("#inicio").val();
	fecha_limite=$("#limite").val();
	programa=$("#programa2").val();

	if(programa!='ninguno'){
	
		data='fecha_inicio='+fecha_inicio+'&fecha_limite='+fecha_limite+"&programa="+programa+"&opcion="+1;
	
		if(fecha_limite>fecha_inicio){
				$.ajax({
						url:'../consultas_sql/InsertSql.php',
						data:data,
						type:"POST",
						dataType:"html",
						success: function(msg){
							
							$("#fechas_programadas").html(msg);
							
							}
					})
			}
			
			else{		
					alert('La fecha límite debe ser mayor a la fecha de inicio.');
				
				}
		
		
	}
	
	else{alert("Selecione Un Prgrama")}
	}
	
function terminar(id_permiso){
	$.ajax({
			url:'../consultas_sql/Actualizar.php',
			data:'id_permiso='+id_permiso+'&opcion='+1,
			dataType:"html",
			type:'POST',
			success: function(msg){
				
				$("#fechas_programadas").html(msg);
				alert("Programación Deshabilitada");
				}
		})
	}
	
	
function anunciar(){
	
	asunto=$('#asunto').val();
	descrip=$('#anuncio').val();
	programa=$('#selec_prog').val();
	fecha_public=$('#fecha_asunto').val();
	
	estado=1;
	
	if($('#asunto').val()==""){estado=0;}
	if($('#anuncio').val()==""){estado=0;}
	if($('#fecha_asunto').val()==""){estado=0;}
	
	
	if(estado!=0){
			if(programa!='ninguno'){
				data='asunto='+asunto+'&descrip='+descrip+'&programa='+programa+'&fecha_public='+fecha_public+"&opcion="+2;
				
				$.ajax({
					url:'../consultas_sql/InsertSql.php',
					data:data,
					type:"POST",
					dataType:"json",
					success: function(msg){
						
						alert(msg);
						
						}
				})
				
				}
				
			else{alert("Selecione Un programa");}
			
	}
	
	else{alert("Uno de los campos esta Vacio");}
	
	}
	
function nuevo(){
	$('#asunto').val("");
	$('#anuncio').val("");
	$("#ver_anuncio").html("");
	
	}
	
function eliminar(){
	
	$.ajax({
			url:'../consultas_sql/Actualizar.php',
			data:'&opcion='+2,
			dataType:"json",
			type:'POST',
			success: function(msg){
				alert(msg);
				}
		})
		
	}
	
function string(){
		var string='<p class="parrafo">'+$("#anuncio").val()+'</p>';
		var capt=$("#anuncio2").val();
		
		
	if(event.keyCode==13){
		$("#anuncio").val(capt+string);
		$("#ver_anuncio").html(capt+string);
		$("#anuncio").val("")
		
		}
	
	}
	
function ModificarAdmin(id_usuario){
	
	var data='id_usuario='+id_usuario+'&user='+$('#userAdmin').val()+'&pasword='+$('#passwordAdmin').val()+'&opcion='+31;
	
	$.ajax({
			url:'../consultas_sql/Actualizar.php',
			data:data,
			dataType:"json",
			type:'POST',
			success: function(msg){
				alert(msg);
				}
		})
	}

function nuevoAdmin(){
	data='codigo='+$('#codigoAdmin').val()+'&nombre='+$('#nombreAdmin').val()+'&apellido='+$('#apellidoAdmin').val()+'&usuario='+$('#usuarioAdmin').val()+'&passw='+$('#passAdmin').val()+'&opcion='+32;
	
	
	$.ajax({
			url:'../consultas_sql/Actualizar.php',
			data:data,
			dataType:"json",
			type:'POST',
			success: function(msg){
				alert(msg);
				}
		})
	
	}
	
function buscarDocente(id_docente){
		var data='id_docente='+id_docente+'&opcion='+7;
		
		$.ajax({
			url:'../consultas_sql/ConsulSql.php',
			data:data,
			dataType:"json",
			type:'POST',
			success: function(msg){
				if(msg.datos==1){
					$("#nombreAdmin").val(msg.nombre);
					$("#apellidoAdmin").val(msg.apellido);
					$("#habilitarDocente").fadeIn(0);
					$("#nuevoAdministrador").fadeOut(0);
					$("#nuevoAdministrador2").fadeOut(0);											
					}
					
				if(msg.datos==2){
					$("#nombreAdmin").val(msg.nombre);
					$("#apellidoAdmin").val(msg.apellido);
					 $("#nuevoAdministrador2").fadeIn(0);
					$("#habilitarDocente").fadeOut(0);
					$("#nuevoAdministrador").fadeOut(0);											
					}
				if(msg.datos==0){
					$("#habilitarDocente").fadeOut(0);
					$("#nuevoAdministrador2").fadeOut(0);
					$("#nuevoAdministrador").fadeIn(0);
					$("#nombreAdmin").val("");
					$("#apellidoAdmin").val("");
					
					}
					
				}
		})
		
	}
	
function habilitarAdmin(){
	
	if($("#usuarioAdmin").val()!="" && $("#passAdmin").val()!=""){
			var data='CodigoAdmin='+$("#codigoAdmin").val()+"&user="+$("#usuarioAdmin").val()+"&pass="+$("#passAdmin").val()+"&opcion="+33;
			
			$.ajax({
				url:'../consultas_sql/Actualizar.php',
				data:data,
				dataType:"json",
				type:'POST',
				success: function(msg){
					alert(msg);
					}
			})
		}
	
	else{alert("Debe asignar un Usuario y una Contraseña")}
		
	}
	
function nuevoAdmin2(){
	
	
	if($("#usuarioAdmin").val()!="" && $("#passAdmin").val()!=""){
			var data='CodigoAdmin='+$("#codigoAdmin").val()+"&user="+$("#usuarioAdmin").val()+"&pass="+$("#passAdmin").val()+"&opcion="+34;
			
			$.ajax({
				url:'../consultas_sql/Actualizar.php',
				data:data,
				dataType:"json",
				type:'POST',
				success: function(msg){
					alert(msg);
					}
			})
		}
	
	else{alert("Debe asignar un Usuario y una Contraseña")}
	
	}
</script>

<style type="text/css">
.btn_anuncio{
	width:150px;
	height:40px;
	background:#06F;
	border:1px solid #000;
	border-radius:5px;
	margin-left:10px;
	color:#FFF;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;}
	
label{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;}

#ver_anuncio{
	width:400px;
	height:auto;
	}
</style>
<div style="margin-top:15px; border:1px solid #000; width:450px; float:left; margin-left:15px">
	<div><h2>Anuncios</h2></div>
    
    <div style="width:400px; margin:0 auto;">
    	<label>Asunto</label>
        <textarea style="width:400px; height:30px; font-size:20px; font-family:arial" id="asunto"></textarea><br><br>
        
        <label>Descripcion</label>
        <!--<textarea style="width:400px; height:150px;" id="descripcion"></textarea><br><br>-->
        
        <div id="ver_anuncio" style="text-align:justify"></div>

            <textarea id="anuncio" style="text-align:justify" onKeyUp="string()" cols="50" rows="7"></textarea><br>
           <!-- <button id="btn" class="btn_anuncio" style="margin-top:5px">Enviar</button><br>-->
            <textarea id="anuncio2" style="visibility:hidden" cols="5" rows="5"></textarea>
            
        <label>Programa</label>
        <select style="width:200px; height:30px; border-radius:5px;" id="selec_prog">
        	<option value="ninguno">Selecione Programa</option>
            <option value="0">Todos los programas</option>
            <?php while($g=mysqli_fetch_array($programas2)){?>
				
					<option value="<?php echo $g['id_programa']?>"><?php echo $g['nombre']?></option>
				
				<?php } ?>
        </select>
        <br><br>
        
        <label>Fecha Límite de la Publicación</label>
        <input type="date" id="fecha_asunto">
        <br><br>
        <button class="btn_anuncio" onClick="anunciar()">Anunciar</button><button class="btn_anuncio" onclick="nuevo()" style="margin-bottom:15px;">Nuevo</button><button class="btn_anuncio" onClick="eliminar()" style="margin-bottom:15px;">Eliminar Anuncios</button>
    </div>
</div>

<div id="fechas_programadas" style="margin-top:15px; border:1px solid #000; width:450px; float:right; margin-right:15px">

<div><h2>Fechas programadas para subir archivos</h2></div>
	
    <div style="width:400px; margin:0 auto;">
		<table align="center">
			<tr>
				<th style="width:200px">Fecha Inicio</th>
				<th style="width:200px">Fecha Límite</th>
				<th style="width:100px">Deshabilitar</th>
    		</tr>
            
            <?php
				while($f=mysqli_fetch_array($fechas)){
					$fecha_inicio=explode('-',$f['fecha_inicio']);
					$mes=obtenerMes($fecha_inicio[1]);
					$fecha_inicio=$fecha_inicio[2].' de '. $mes.' '.$fecha_inicio[0]; 
					
					$fecha_limite=explode('-',$f['fecha_final']);
					$mes=obtenerMes($fecha_limite[1]);
					$fecha_limite=$fecha_limite[2].' de '. $mes.' '.$fecha_limite[0];
			?>
            <tr>
				<td align="center"><?php echo $fecha_inicio ?></td>
				<td align="center"><?php echo $fecha_limite ?></td>
				<td align="center"><button onClick="terminar(<?php echo $f['id_permiso'] ?>)">Terminar</button></td>
		   </tr>
           
          <?php 
		  		} 
		  ?>
                                 
      </table>       
	</div>
	
</div>

<div style="margin-top:15px; border:1px solid #000; width:450px; float:right; margin-right:15px">
	<div><h2>Subir Archivos</h2></div>
    
    <div style="width:400px; margin:0 auto;">
    	
        
        <label>Fecha de Inicio</label>
        <input type="date" id="inicio" style="width:200px; height:35px; border-radius:5px;border:1px solid #000"><br><br>
        
        <label>Fecha Límite</label>
        <input type="date" id="limite" style="width:200px; height:35px; border-radius:5px;border:1px solid #000"><br><br>
        
        <label>Programa</label>
        <select id="programa2" style="width:200px; height:30px; border-radius:5px;">
        	<option value="ninguno">Selecione Programa</option>
            <option value="0">Todos los programas</option>
            <?php 
				while($f=mysqli_fetch_array($programas)){?>
					 <option value="<?php echo $f['id_programa']?>"><?php echo $f['nombre']?></option>
				<?php 
					}
				?>
        </select>
 
        <br><br>
        <button class="btn_anuncio" onClick="programar()" style="margin-bottom:15px;">Programar</button>
    </div>
</div>

<div style="margin-top:15px; border:1px solid #000; width:450px; float:right; margin-right:15px">
	<div><h2>Modificar Datos</h2></div>
   		<label>Usuario</label>
        <input type="text" id="userAdmin" style="width:200px; height:35px; border-radius:5px;border:1px solid #000; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px"><br><br>
        
        <label>Password</label>
        <input type="text" id="passwordAdmin" style="width:200px; height:35px; border-radius:5px;border:1px solid #000; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px"><br><br>
        <button class="btn_anuncio" onClick="ModificarAdmin(<?php echo $_SESSION["administrador"] ?>)"  style="margin-bottom:15px;">Modificar</button>
	
</div>

<div style="margin-top:15px; border:1px solid #000; width:450px; float:right; margin-right:15px">
	<div><h2>Nuevo Administrador</h2></div>
   		<label>Código</label>
        <input type="text" id="codigoAdmin" onBlur="buscarDocente(this.value)" style="width:200px; height:35px; border-radius:5px;border:1px solid #000; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px"><br><br>
        
        <label>Nombre</label>
        <input type="text" id="nombreAdmin" style="width:200px; height:35px; border-radius:5px;border:1px solid #000; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px"><br><br>
        
        <label>Apellido</label>
        <input type="text" id="apellidoAdmin" style="width:200px; height:35px; border-radius:5px;border:1px solid #000; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px"><br><br>
        
        <label>Usuario</label>
        <input type="text" id="usuarioAdmin" style="width:200px; height:35px; border-radius:5px;border:1px solid #000; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px"><br><br>
        
        <label>Password</label>
        <input type="password" id="passAdmin" style="width:200px; height:35px; border-radius:5px;border:1px solid #000; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px"><br><br>
        <button class="btn_anuncio" id="nuevoAdministrador" onClick="nuevoAdmin()"  style="margin-bottom:15px;">Nuevo</button>
        <button class="btn_anuncio"  id="habilitarDocente" onClick="habilitarAdmin()"  style="margin-bottom:15px;">Habilitar</button>
        
        <button class="btn_anuncio"  id="nuevoAdministrador2" onClick="nuevoAdmin2()"  style="margin-bottom:15px;">Nuevo</button>
	
</div>


