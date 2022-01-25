$(document).ready(function(e) {
	
	$("#propuestas").click(function(e) {
        $.ajax({
				url:"subdirectorios/ajax_cuerpo/propuestas_comite.php",
				dataType:"html",
				type:'POST',
				success: function(msg){
					$("#arear_trabjo").html(msg);
					}
			
			});
    });	
	
	$("#proyectos").click(function(e) {
        $.ajax({
				url:"subdirectorios/ajax_cuerpo/proyectos_comite.php",
				dataType:"html",
				type:'POST',
				success: function(msg){
					$("#arear_trabjo").html(msg);
					}
			
			});
    });	
	
	$("#informes").click(function(e) {
        $.ajax({
				url:"subdirectorios/ajax_cuerpo/informes_comite.php",
				dataType:"html",
				type:'POST',
				success: function(msg){
					$("#arear_trabjo").html(msg);
					}
			
			});
	
    });
	
	$("#configurar").click(function(e) {
        $.ajax({
				url:"subdirectorios/ajax_cuerpo/ConfigurarComite.php",
				dataType:"html",
				type:'POST',
				success: function(msg){
					$("#arear_trabjo").html(msg);
					}
			
			});
	
    });
	
	$("#configurarJurado").click(function(e) {
        $.ajax({
				url:"subdirectorios/ajax_cuerpo/ConfigurarJurado.php",
				dataType:"html",
				type:'POST',
				success: function(msg){
					$("#filtro_proyectos").fadeOut(0);
					$("#filtro_informes").fadeOut(0);
					$("#arear_trabjo").html(msg);
					}
			
			});
	
    });
	
	$("#salir").click(function(){
		window.location.href="../users.php";
		
		});

});

