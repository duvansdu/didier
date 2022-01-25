<script type="text/javascript">
$(document).ready(function(e) {
    $("#btn_actas").click(function() {
            $("#txt_acta").click();
        });
		
	$("#btn_acta").click(function(e) {
		tipo=0;
		
		var archivo = document.getElementById("txt_acta");
		var file = archivo.files[0];
		
		if($("#checkpropuesta").is(":checked")){tipo=1;}
		if($("#checkproyectos").is(":checked")){tipo=2;}
		if($("#checkfinales").is(":checked")){tipo=3;}
		
		
		if(tipo!=0){
			if($("#txt_acta").val()!=""){
				var data = new FormData();
				data.append('archivo',file);				
				data.append('tipo',tipo);
				data.append('opcion',10);
				
				
				$.ajax({
						url:'../consultas_sql/Actualizar.php',
						type:'POST',
						data:data,
						dataType:"json",
						processData:false,  
						cache:false,
						contentType:false,
						success: function(msg){
							 alert(msg);
							 
						$.ajax({
						  url:'subdirectorios/ajax_cuerpo/actas.php',
						  type:'POST',
						  dataType:"html",
						  success: function(msg){
							  $("#buscar_modalidad").html(msg);
							 
								
							  }
						})
							
							}
		
					})
			}
			
			else{alert("Debe cargar un archivo PDF")}
		}
		
		else{alert("Seleccione un tipo de Documento")}
    });
});
function cambiar_acta(value){
	
	$("#txt_acta_individual").val(value);
	
	}

</script>

<style type="text/css">
.btn_actas{
	width:200px;
	height:40px; 
	background:#A00000;
	border-radius:5px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	color:#FFF;
	cursor:pointer;
	}
	
#txt_acta{
	opacity:0;
	visibility:hidden;}
	
.label_acta{
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
	}

</style>
<div id="check" style="margin-top:15px;">
    <input type="radio" id="checkpropuesta" name="txt_acta"><label class="label_acta">Propuestas</label>
    <input type="radio" id="checkproyectos" name="txt_acta" style="margin-left:40px;"><label class="label_acta">Proyectos</label>
    <input type="radio" id="checkfinales" name="txt_acta" style="margin-left:40px;"><label class="label_acta">Informes Finales</label>
</div>
<div id="subir_acta" style="width:200px; margin-top:10px; display:inline-block;">
	<button id="btn_actas" class="btn_actas">Cargar Acta</button>
    <input type="text" id="txt_acta_individual" style="margin-top:10px; margin-bottom:10px; width:200px; height:30px">
    <button id="btn_acta" class="btn_actas">Enviar</button>
</div>
<div id="file">
<input type="file" id="txt_acta" accept="application/pdf" onChange="cambiar_acta(this.value)" style="display:inline-block">
</div>




