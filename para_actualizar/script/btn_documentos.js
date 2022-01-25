$(document).ready(function(e) {
//Documentos
	
	$("#propuestas").click(function(){
		$.ajax({
			url:"subdirectorios/ajax_cuerpo/propuestas.php",
			type:"POST",
			dataType:"html",
			success: function(msg){
				
				$("#area_documentos").html(msg);
				}
			
			});
		});
		
	$("#proyectos").click(function(){
		$.ajax({
			url:"subdirectorios/ajax_cuerpo/proyectos.php",
			type:"POST",
			dataType:"html",
			success: function(msg){
				
				$("#area_documentos").html(msg);
				}
			
			});
		});

	$("#informes").click(function(){
		$.ajax({
			url:"subdirectorios/ajax_cuerpo/informes.php",
			type:"POST",
			dataType:"html",
			success: function(msg){
				
				$("#area_documentos").html(msg);
				}
			
			});
		});
		
		
	$("#historiales").click(function(){
		$.ajax({
			url:"subdirectorios/ajax_cuerpo/historiales.php",
			type:"POST",
			dataType:"html",
			success: function(msg){
				
				$("#area_documentos").html(msg);
				}
			
			});
		});
	
		
});

