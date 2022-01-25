<?php 
include '../../../connections/conection.php';

$progra=mysqli_query($link,"SELECT tb_programa.id_programa, tb_programa.nombre
  FROM pegasoun_proyecto.tb_programa tb_programa");
?>

<style type="text/css">
.regisrar_docene{
	
	width:300px;
	height:610px;
	border:1px solid #000;
	border-radius:5px 5px 0px 0px;
	float:left;
	position:relative;
	margin-left:10px;
	padding-bottom:10px;
	}
.txt_docente{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
}
.input_docente{
	height:25px;
	border-radius:5px;
	border:1px solid #000;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	padding-left:5px;}
.tr_docente{
	height:30px;}
.txarea_docente{
	width:100%;
	height:100px;
	}
	
.titulo_docente{
	font-family:Arial, Helvetica, sans-serif;
	font-size:24px;
	width:100%;
	background:#FF3;
	border-bottom:1px solid #000;
	border-radius:5px 5px 0px 0px;}

.boton_docente{
	width:150px;
	height:30px;
	background:#06F;
	border-radius:5px;
	border:1px solid #000;
	color:#FFF;
	font-family:Arial, Helvetica, sans-serif;
	cursor:pointer;
	margin-top:10px;}
</style>
<h2>Administrar Docente</h2>

<div class="regisrar_docene">

	<div class="titulo_docente">Registrar</div>
    <div id="cuerpo_docente" style="margin-top:10px;">
    	<table border="0" align="center">
        	<tr class="tr_docente">
            	<td><label class="txt_docente">Código</label></td>
                <td><input class="input_docente" type="text" placeholder="Código" id="codigo_docente" /></td>
            </tr>
        	<tr class="tr_docente">
            	<td><label class="txt_docente">Nombre</label></td>
                <td><input class="input_docente" type="text" placeholder="Nombre" id="nombre_docente"/></td>
            </tr>
        	<tr class="tr_docente">
            	<td> <label class="txt_docente">Apellido</label></td>
                <td><input class="input_docente" type="text" placeholder="Apellido" id="apellido_docente"/></td>
            </tr>
        	<tr class="tr_docente">
            	<td><label class="txt_docente">Télefono</label></td>
                <td><input class="input_docente" type="text" placeholder="Télefono" id="telefono_docente"/></td>
            </tr>
        	<tr class="tr_docente">
            	<td><label class="txt_docente">E-mail</label></td>
                <td><input class="input_docente" type="text" placeholder="E-mail" id="email_docente"/></td>
            </tr>
        	<!--<tr class="tr_docente">
            	<td><label class="txt_docente">Programa</label></td>
                <td><select id="select_prog">
                		<option value="0">Seleccione Progrma</option>
                        <?php
							//while($f=mysqli_fetch_array($progra)){ ?>
								<option value="<?php// echo $f['id_programa'] ?>"><?php//echo $f['nombre'] ?></option>
								
						<?php 
							//}
						?>
                		
                	</select>
                </td>
            </tr> -->
            
        	<tr class="tr_docente">
            	<td colspan="2"><label class="txt_docente">Especialidades</label></td>
            </tr>
            <tr class="tr_docente">
            	<td colspan="2"><textarea class="txarea_docente" id="txt_especilidad"></textarea></td>
            </tr>
            
            <tr class="tr_docente">
            	<td colspan="2" align="center"><button class="boton_docente" onclick="registrando_docente()">Registrar</button></td>
            </tr>
            </table>

    </div>


</div>


<div class="regisrar_docene">

	<div class="titulo_docente">Asignar Rol</div>
    <div id="contenido_docente1" style="margin-top:10px;">
    	<label>Docente</label><input type="text" id="nombre_docente1" onkeyup="buscar_docentes($('#nombre_docente1').val(),1)"/>
        
        <div id="list_docentes1"></div>
        <div id="rol_docentes1"></div>
    </div>


</div>


<div class="regisrar_docene">

	<div class="titulo_docente">Modificar</div>
    <div id="contenido_docente2" style="margin-top:10px;">
    	<label>Docente</label><input type="text" id="nombre_docente2" onkeyup="buscar_docentes($('#nombre_docente2').val(),2)"/>
        
        <div id="list_docentes2"></div>
        <div id="rol_docentes2"></div>
</div>