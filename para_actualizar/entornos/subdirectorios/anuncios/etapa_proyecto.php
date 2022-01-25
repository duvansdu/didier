<?php

if($modalidad_trabajo['id_modalidad']==1 || $modalidad_trabajo['id_modalidad']==4){

		echo Desarrollo_gestion($integrantes, $director, $programa, $programa2, $programa3, $directores);
	}
	
	
if($modalidad_trabajo['id_modalidad']==3){
	
	echo formulacion_investigacion($integrantes, $director, $programa, $programa2, $programa3, $directores, $link);
}
?>
 
 <h3 style="padding-left:10px; padding-right:10px;">La plataforma PEGASO, le mantendrá al tanto de todo lo que suceda con sus archivos , llevará un control y hará seguimiento a la información que se genere al respecto.</h3> 
 
 <input type="hidden" id="id_trabajo" value="<?php echo $id_documento ?>" />