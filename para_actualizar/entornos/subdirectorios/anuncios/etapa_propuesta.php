<div id="subir_acta" style="width:200px; margin-top:10px; display:inline-block;">
	<button id="btn_actas" class="btn_documento">Cargar Documento</button>
    <input type="text" id="txt_acta_individual" style="margin-top:10px; margin-bottom:10px; width:200px; height:30px">
    
    		<button id="btn_documento3" class="btn_documento">Enviar</button>


</div>
<div id="file">
<input type="file" id="txt_documento" accept="application/pdf" onChange="cambiar_acta(this.value)" style="display:inline-block">
</div>
<p class="label">Desea modificar el titulo de su documento</p>

<div id="titulo_provisional">
	<textarea id="titulo" style="width:400px; height:100px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:16px; resize:none;" placeholder="Titulo del Documento"></textarea>
	
</div>


 
 <h3 style="padding-left:10px; padding-right:10px;">La plataforma PEGASO, le mantendrá al tanto de todo lo que suceda con sus archivos , llevará un control y hará seguimiento a la información que se genere al respecto.</h3> 
 
 <input type="hidden" id="id_trabajo" value="<?php echo $id_documento ?>" />