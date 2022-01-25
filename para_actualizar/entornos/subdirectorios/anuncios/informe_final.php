<?php

if($modalidad_trabajo['id_modalidad']==2 || $modalidad_trabajo['id_modalidad']==5){
	echo $mensaje; 
				$integrantes=mysqli_query($link,"SELECT `tb_trabajo tb_estudiante`.id_usuario
							  FROM pegasoun_proyecto.`tb_trabajo tb_estudiante` `tb_trabajo tb_estudiante`
							 WHERE `tb_trabajo tb_estudiante`.id_trabajo = '".$id_documento."' ");
	if(mysqli_num_rows($integrantes)==0){
						echo integrantes($id_documento,$link);
						
			}

	if($modalidad_trabajo['id_modalidad']==2){
				$informes_avances=mysqli_query($link,"SELECT tb_avances.informe_avance
							  FROM pegasoun_proyecto.tb_avances tb_avances
							 WHERE tb_avances.id_trabajo ='".$id_documento."' ");
			}
	else{
		$informes_avances=mysqli_query($link,"SELECT tb_avance.informe_avance
								  FROM pegasoun_proyecto.tb_avance tb_avance
								 WHERE tb_avance.id_trabajo ='".$id_documento."' ");
		}
				 
	if($informes['cont']<3){?>
    
    		<div id="subir_acta" style="width:200px; margin-top:10px; display:inline-block;">
                <button id="btn_actas" class="btn_documento">Cargar Documento</button>
                <input type="text" id="txt_acta_individual" style="margin-top:10px; margin-bottom:10px; width:200px; height:30px">
                
              <?php if(mysqli_num_rows($integrantes)==0){?>
                        <button id="btn_documento9" class="btn_documento">Enviar</button>
              <?php }
			  
			  else{?>
              			    <button id="btn_documento7" class="btn_documento">Enviar</button>

              <?php }?>
            
            </div>
            <div id="file">
            <input type="file" id="txt_documento" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" onChange="cambiar_acta(this.value)" style="display:inline-block">
			</div>
		
		<?php 	
							 

}
		
	else{?>
		
		<h2>Has culminado con la cantidad de informes requeridos por la institución.</h2>
       
  <?php }?>
  
   <div>
        
        	<?php
				$contando=1;
				while($f=mysqli_fetch_array($informes_avances)){
					
					if($contando==1){
							$msg='Primer Informe';
						}
					if($contando==2){
							$msg='Segundo Informe';
						}
						
					if($contando==3){
							$msg='Ultimo Informe';
						}
					$contando++;
					?>
                
                	
					
					<figure style="display:inline-block">
                         <a href="<?php echo $f['informe_avance'] ?>"><img src="../img/word.jpg" width="100px" height="100px" /></a>
                         <figcaption><?php echo $msg ?></figcaption>
                    </figure>
			<?php
					}
			?>
            
        </div>
	
	<?php }

else{
?>

<div id="subir_acta" style="width:200px; margin-top:10px; display:inline-block;">
	<button id="btn_actas" class="btn_documento">Cargar Documento</button>
    <input type="text" id="txt_acta_individual" style="margin-top:10px; margin-bottom:10px; width:200px; height:30px">
    
    		<button id="btn_documento6" class="btn_documento">Enviar</button>

</div>
<div id="file">
<input type="file" id="txt_documento" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" onChange="cambiar_acta(this.value)" style="display:inline-block">
</div>
	
<?php
}
?>

 <h3 style="padding-left:10px; padding-right:10px;">La plataforma PEGASO, le mantendrá al tanto de todo lo que suceda con sus archivos , llevará un control y hará seguimiento a la información que se genere al respecto.</h3> 
 
 <input type="hidden" id="id_trabajo" value="<?php echo $id_documento ?>" />