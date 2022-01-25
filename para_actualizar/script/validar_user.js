$(document).ready(function(e) {
    
	$("#btn_user").click(function(e) {
        var usuario=$("#select_user").val();
		var user=$("#user").val();
		var psw=$("#pws").val();
			
		if(usuario==1){
			$.ajax({
					url:'data/validar_informacion.php',
					data:"user="+user+"&pws="+psw+"&opcion="+1,
					type:"POST",
					dataType:"json",
					success: function(msg){
							if(msg.ingreso==1){
								window.open('entornos/estudiante.php','_self');
								}
								
							else{alert(msg.mensaje);}
						}
				
				});
				
			}
			
		if(usuario==2){
			$.ajax({
					url:'data/validar_informacion.php',
					data:"user="+user+"&pws="+psw+"&opcion="+5,
					type:"POST",
					dataType:"json",
					success: function(msg){
							if(msg.ingreso==1){
								window.open('entornos/tutor.php','_self');
								}
								
							else{alert(msg.mensaje);}
						}
				
				});
				
			}
		
		if(usuario==3){
			$.ajax({
					url:'data/validar_informacion.php',
					data:"user="+user+"&pws="+psw+"&opcion="+3,
					type:"POST",
					dataType:"json",
					success: function(msg){
							if(msg.ingreso==1){
								window.open('entornos/comite.php','_self');
								}
								
							else{alert(msg.mensaje);}
						}
				
				});
			}
			
			
		if(usuario==4){
			$.ajax({
					url:'data/validar_informacion.php',
					data:"user="+user+"&pws="+psw+"&opcion="+4,
					type:"POST",
					dataType:"json",
					success: function(msg){
							if(msg.ingreso==1){
								window.open('entornos/jurado.php','_self');
								}
								
							else{alert(msg.mensaje);}
						}
				
				});
				
			}
		
    });
});
