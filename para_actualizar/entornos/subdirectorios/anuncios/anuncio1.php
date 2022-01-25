<style type="text/css">
#derecho{
	width:560px;
	height:auto;
	float:left;
	border:1px solid #000;
	margin-left:16px;
	margin-top:15px;
	}
	
#izquierdo{
	width:340px;
	height:auto;
	float:right;
	margin-right:16px;
	margin-top:15px;
	border:1px solid #000;
	padding-bottom:5px;	
	}
	
.parrafo{
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	text-align:justify;
	margin:35px;}

	
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

</style>
<div id="titulo"><h1><?php echo $estado_habilitado['titulo']?></h1></div>
<div id="derecho">

<?php 
	while($f=mysqli_fetch_array($anuncios)){?>

		<h1><?php echo $f['asunto']?></h1>
        
		<?php 
		$fecha=explode('-',$f['fecha_publicacion']);
		$mes=obtenerMes($fecha[1]);
		echo $f['descripcion'].'<br><br>Publicado: '.$fecha[2].' de '.$mes;
		
	} 
		?>
    	
</div>
<div id="izquierdo">
	<div id="modifUsers" style="margin-top:10px;">
        	<h2>Modificar Usuario</h2>
        	<label>Usuario</label>
        	<input type="text" id="userStudent" style="width:200px; height:35px; border-radius:5px;border:1px solid #000; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px"><br><br>
        
       		 <label>Password</label>
        	<input type="password" id="passStudent" style="width:200px; height:35px; border-radius:5px;border:1px solid #000; font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:20px"><br><br>
            <button class="btn_anuncio" onClick="ModificarUser(<?php echo $id_documento ?>)"  style="margin-bottom:15px;">Modificar usuario</button>
            <button class="btn_anuncio" onClick="ActualizarDatos('<?php echo $id_documento ?>')"  style="margin-bottom:15px;">Actualizar datos</button>
        </div>
        <hr style="width:90%; background:#000" />
	<?php 
	
	$obser_coor=mysqli_query($link,"SELECT tb_observacion.observacion, tb_observacion.fecha_publicacion
  FROM pegasoun_proyecto.tb_observacion tb_observacion
 WHERE tb_observacion.id_trabajo = '".$id_documento."'  ORDER BY  `tb_observacion`.`fecha_publicacion` DESC, `tb_observacion`.`id_observacion` DESC");

	$concepto=mysqli_query($link,"SELECT tb_concepto.id_concepto,
						   tb_concepto.id_trabajo,
						   tb_concepto.ruta,
						   tb_concepto.fecha_subida,
						   tb_concepto.revisado
					  FROM pegasoun_proyecto.tb_concepto tb_concepto
					 WHERE tb_concepto.id_trabajo = '".$id_documento."'
					ORDER BY tb_concepto.fecha_subida DESC, tb_concepto.id_concepto DESC");
 
 	$cartas=mysqli_query($link,"SELECT tb_carta.ruta, tb_carta.id_carta, tb_carta.id_trabajo,  tb_carta.fecha_subida, tb_carta.revisado
					  FROM pegasoun_proyecto.tb_carta tb_carta
					 WHERE tb_carta.id_trabajo = '".$id_documento."' ORDER BY tb_carta.fecha_subida DESC, tb_carta.id_carta DESC");
					 
	$corregir=mysqli_query($link,"SELECT tb_corregir_docu.id_correccion,
							   tb_corregir_docu.ruta_doc,
							   tb_corregir_docu.revisado,
							   tb_corregir_docu.id_trabajo
						  FROM pegasoun_proyecto.tb_corregir_docu tb_corregir_docu
						 WHERE tb_corregir_docu.id_trabajo = '".$id_documento."'
						ORDER BY tb_corregir_docu.id_correccion ASC");
 

 if(mysqli_num_rows($obser_coor)>0){
			 while($g=mysqli_fetch_array($obser_coor)){?>
             <h3>Recomendación Coordinador</h3> 
             
             <?php echo $g['observacion'];
			 
			 $fecha=explode('-',$g['fecha_publicacion']);
			 $mes=obtenerMes($fecha[1]); ?>
			 
            <p>Publicado:<?php echo ' '.$fecha['2'].' de '.$mes ?></p>
            <hr style="width:90%; background:#000" />
				 
				<?php }
			
			}
			
  if(mysqli_num_rows($corregir)>0){?>
  			<h3>Correciones</h3> 
  <?php 	while($f=mysqli_fetch_array($corregir)){
	  			if($f['revisado']==1){$style='style="background:#099; height:120px; margin:auto; padding-top:10px; border-radius:20px; width:50%; cursor:pointer"';}
				else{$style='';}
		?>
    <figure <?php echo $style ?>>
    <a href="<?php echo $f['ruta_doc'] ?>" onclick="cambiar_color('<?php echo $f['id_correccion']?> ', '<?php echo $f['id_trabajo']?>', '3')"><img src="../img/word.jpg" width="95" height="95" /></a>
    </figure>

	  
 <?php	  }
  
   echo '<hr style="width:90%; background:#000" />';
  }		


			
  if(mysqli_num_rows($cartas)>0){?>
	 
     <h3>Cartas</h3> 
<?php
	 while($f=mysqli_fetch_array($cartas)){
	 $fecha=explode('-',$f['fecha_subida']);
	 
	 if($f['revisado']==1){$style='style="background:#099; height:120px; margin:auto; padding-top:10px; border-radius:20px; width:50%; cursor:pointer"';}
	else{$style='';}
	 
	 //if($f['revisado']==1){$style="";}
	 
	 $mes=obtenerMesCorto($fecha[1]);
	 
	 ?>
 

    <figure <?php echo $style ?>>
    <a href="<?php echo $f['ruta'] ?>" onclick="cambiar_color('<?php echo $f['id_carta']?> ', '<?php echo $f['id_trabajo']?>', '1')" target="_blank"><img src="../img/pdf_descarga.png" width="95" height="95" /></a>
    <figcaption>Publicado:<?php echo ' '.$fecha['2'].' de '.$mes ?></figcaption>
    </figure>
	
 <?php } 
    echo '<hr style="width:90%; background:#000" />';
  }?>
 
 <h3>Conceptos</h3>
 
<?php
 if(mysqli_num_rows($concepto)>0){
	 
	 while($f=mysqli_fetch_array($concepto)){
	 $fecha=explode('-',$f['fecha_subida']);
	 
	  if($f['revisado']==1){$style='style="background:#099; height:120px; margin:auto; padding-top:10px; border-radius:20px; width:50%; cursor:pointer"';}
	else{$style='';}
	 
	 $mes=obtenerMesCorto($fecha[1]);
	 
	 ?>
 
 
    <figure <?php echo $style ?>>
    <a href="<?php echo $f['ruta'] ?>" onclick="cambiar_color('<?php echo $f['id_concepto']?> ', '<?php echo $f['id_trabajo']?>', '2')"  target="_blank"><img src="../img/pdf_descarga.png" width="95" height="95" /></a>
    <figcaption>Publicado:<?php echo ' '.$fecha['2'].' de '.$mes ?></figcaption>
    </figure>
	
 <?php }
 
 } 
 
 else{
	 

	 
	 ?>
 
 
 	<h1>Historial</h1>
    <p>Aquí se contienen las  actas, observaciones y archivos, emitidos por los docentes, que le ayudarán a corregir los documentos presentados.</p>
 <?php 
 	}
 ?>
 </div>

