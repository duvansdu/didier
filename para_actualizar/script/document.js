// JavaScript Document
$(document).ready(function(e) {
    	$("#documentos").click(function(){
			$.ajax({
				url:"subdirectorios/ajax_cuerpo/documento.php",
				type:"POST",
				dataType:"html",
				success: function(msg){
					
					$("#arear_trabjo").html(msg);
					}
				
				});
		});

	$("#docente").click(function(){
		$.ajax({
			url:"subdirectorios/ajax_cuerpo/docente.php",
			type:"POST",
			dataType:"html",
			success: function(msg){
				
				$("#arear_trabjo").html(msg);
				}
			
			});
		});

	$("#comite").click(function(){
		$.ajax({
			url:"subdirectorios/ajax_cuerpo/comite.php",
			type:"POST",
			dataType:"html",
			success: function(msg){
				
				$("#arear_trabjo").html(msg);
				}
			
			});
		});
		
	$("#consultas").click(function(){
		$.ajax({
			url:"subdirectorios/ajax_cuerpo/consultas.php",
			type:"POST",
			dataType:"html",
			success: function(msg){
				
				$("#arear_trabjo").html(msg);
				}
			
			});
		});	

	$("#anuncio_permiso").click(function(){
		$.ajax({
			url:"subdirectorios/ajax_cuerpo/anuncios_permisos.php",
			type:"POST",
			dataType:"html",
			success: function(msg){
				
				$("#arear_trabjo").html(msg);
				}
			
			});
		});
		
	$("#salir").click(function(){
		window.location.href="../administrador.php";
		
		});


});


function comite(id_trabajo, id_programa, doc){	
	
			if(doc==2){url='../entornos/subdirectorios/ajax_cuerpo/proyectos.php'; mensaje='Desea enviar el Proyecto al comite';}
			if(doc==1){url='../entornos/subdirectorios/ajax_cuerpo/propuestas.php'; mensaje='Desea enviar la propuesta al comite';}
			
			if(confirm(mensaje)){
			 $.ajax({
					url:'../consultas_sql/Actualizar.php',
					type:'POST',
					dataType:"json",
					data:"id_trabajo="+id_trabajo+"&id_programa="+id_programa+"&doc="+doc+"&opcion="+7,
					success: function(msg){
							alert(msg);
							
							$.ajax({
									url:url,
									type:'POST',
									dataType:'html',
									success: function(msg){
										$("#area_documentos").html(msg);
										}
								});
							
						}
							
					});
		}

}
