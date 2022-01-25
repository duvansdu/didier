<?php
session_start();
include "../../../connections/conection.php";
include "../../../consultas_sql/formularios_comite.php";


$datosComite=mysqli_fetch_assoc(mysqli_query($link, "SELECT tb_usuario.nombre,
       tb_usuario.apellido,
       tb_usuario.correo,
       tb_usuario.especialidad,
       tb_jurado.usuario,
       tb_usuario.telefono
  FROM pegasoun_proyecto.tb_jurado tb_jurado
       INNER JOIN pegasoun_proyecto.tb_usuario tb_usuario
          ON (tb_jurado.id_usuario = tb_usuario.id_usuario)
 WHERE tb_usuario.id_usuario ='".$_SESSION["user"]."'"));
?>
<script type="text/javascript">
function ConfigurarComite(NComite, AComite, TComite, CComite, EComite, UComite, PComite, RPComite, id_usaurio){
	
	if(PComite==RPComite){	

				data='NComite='+NComite+'&AComite='+AComite+'&TComite='+TComite+'&CComite='+CComite+'&EComite='+EComite+'&UComite='+UComite+'&PComite='+PComite+'&id_usaurio='+id_usaurio+'&opcion=35';
				$.ajax({
						url:"../consultas_sql/Actualizar.php",
						data:data,
						type:'POST',
						dataType:"json",
						success: function(msg){
							alert(msg);
									}		
					});
					
		}
		
	else{alert("Las Contraseñas No Coinciden, Vuelva a Escribirlas")}

	
	}
	
function ConfigurarJurado(NComite, AComite, TComite, CComite, EComite, UComite, PComite, RPComite, id_usaurio){
	
	if(PComite==RPComite){	

				data='NComite='+NComite+'&AComite='+AComite+'&TComite='+TComite+'&CComite='+CComite+'&EComite='+EComite+'&UComite='+UComite+'&PComite='+PComite+'&id_usaurio='+id_usaurio+'&opcion=36';
				$.ajax({
						url:"../consultas_sql/Actualizar.php",
						data:data,
						type:'POST',
						dataType:"json",
						success: function(msg){
							alert(msg);
									}		
					});
					
		}
		
	else{alert("Las Contraseñas No Coinciden, Vuelva a Escribirlas")}

	
	}

</script>
<style type="text/css">
.inputConf{
	width:200px;
	height:30px;
	border:1px #000000 solid;
	border-radius:5px;
	font-family:Arial;
	font-size:18px;}

.txtConf{
	width:250px;
	height:100px;
	border:1px #000000 solid;
	border-radius:5px;
	font-family:Arial;
	font-size:18px;}
	
.labelConf{
	font-family:Arial;
	font-size:18px;
	}
	
.botonConfi{
	width:120px;
	height:40px;
	background:#06F;
	border:1px #000000 solid;
	color:#FFFFFF;
	border-radius:5px;
	font-family:Arial;
	font-size:16px;
	cursor:pointer;}
</style>
<table align="center">
	<tr height="50px">
    	<td><label class="labelConf">Nombre</label></td>
        <td><input type="text" class="inputConf" id="NComite" value="<?php echo $datosComite['nombre']?>"></td>
    </tr>
    <tr height="50px">
    	<td><label class="labelConf">Apellido</label></td>
        <td><input type="text" class="inputConf" id="AComite" value="<?php echo $datosComite['apellido']?>"></td>
    </tr>
    <tr height="50px">
    	<td><label class="labelConf">Teléfono</label></td>
        <td><input type="text" class="inputConf" id="TComite" value="<?php echo $datosComite['telefono']?>"></td>
    </tr>
    <tr height="50px">
    	<td><label class="labelConf">Correo</label></td>
        <td><input type="text" class="inputConf" id="CComite" value="<?php echo $datosComite['correo']?>"></td>
    </tr>
    <tr height="50px">
    	<td><label class="labelConf">Especialidad</label></td>
        <td><textarea class="txtConf" id="EComite"><?php echo $datosComite['especialidad']?></textarea></td>
    </tr>
    <tr height="50px">
    	<td><label class="labelConf">Usuario</label></td>
        <td><input type="text" class="inputConf" id="UComite" value="<?php echo $datosComite['usuario']?>"></td>
    </tr>
    <tr height="50px">
    	<td><label class="labelConf">Contraseña</label></td>
        <td><input type="password" class="inputConf" id="PComite"></td>
    </tr>
    <tr height="50px">
    	<td><label class="labelConf">Repita la Contraseña</label></td>
        <td><input type="password" class="inputConf" id="RPComite"></td>
    </tr>
    
    <tr height="50px">
    	<td colspan="2" align="center"><button class="botonConfi" onClick="ConfigurarJurado($('#NComite').val(), $('#AComite').val(), $('#TComite').val(), $('#CComite').val(), $('#EComite').val(), $('#UComite').val(), $('#PComite').val(), $('#RPComite').val(),'<?php echo $_SESSION["user"]?>')">Modificar</button></td>
       
    </tr>
</table>

