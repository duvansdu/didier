<?php 

if(!isset($_SESSION['user'])){session_start();}
include "funciones_subir_file/funciones_proyectos.php"; 

$id_documento=$_SESSION['user'];


$consul=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_comunicacion.tipo_documento, tb_comunicacion.habilita_plataforma, estado_proyecto
  FROM pegasoun_proyecto.tb_comunicacion tb_comunicacion
 WHERE tb_comunicacion.id_trabajo ='".$id_documento."'"));
 
 $modalidad_trabajo=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_modalidad.id_modalidad
  FROM    pegasoun_proyecto.tb_trabajo tb_trabajo
       JOIN
          pegasoun_proyecto.tb_modalidad tb_modalidad
       ON (tb_trabajo.id_modalidad = tb_modalidad.id_modalidad)
 WHERE tb_trabajo.id_trabajo = '".$id_documento."'"));
 
  $etapa="Aun Sin Definir";
  $informe_num='';
  $mensaje='';
  
 if($modalidad_trabajo['id_modalidad']==2 || $modalidad_trabajo['id_modalidad']==5){
		 if($modalidad_trabajo['id_modalidad']==2){
				$mensaje='<h3>Recuerda que en la Modalidad Práctica de Desempeño Profesinal tienes derecho a subir 3 Informes</h3>';
				
	 $informes=mysqli_fetch_assoc(mysqli_query($link,"SELECT COUNT(tb_avances.informe_avance) AS cont
			  FROM pegasoun_proyecto.tb_avances tb_avances
			 WHERE tb_avances.id_trabajo = '".$id_documento."' "));
			 			 
			 }
			 
		 else{
				$mensaje='<h3>Recuerda que en la Modalidad Desarrollo de una Investigación tienes derecho a subir 3 Informes</h3><h2>'.$informe_num.'</h2>';
				
	 $informes=mysqli_fetch_assoc(mysqli_query($link,"SELECT COUNT(tb_avance.informe_avance) AS cont
										  FROM pegasoun_proyecto.tb_avance tb_avance
										 WHERE tb_avance.id_trabajo = '".$id_documento."' "));
			 
			 }


	
	 if($informes['cont']==0){
		 	$informe_num='Vas a subir el Primer informe';
		 }
		 
	 if($informes['cont']==1){
		 	$informe_num='Vas a subir el Segundo informe';
		 }
	 if($informes['cont']==2){
		 	$informe_num='Vas a subir el Tercer y Último informe';
		 }
		 

	 
	 
	 }
	 

	
		if($consul['tipo_documento']==0){$etapa="Propuesta";}
		if($consul['tipo_documento']==1){$etapa="Proyecto";}
		if($consul['tipo_documento']==2){$etapa="Informe Final";}

 
 
 $integrantes=mysqli_num_rows(mysqli_query($link,"SELECT `tb_trabajo tb_estudiante`.id_usuario
  FROM pegasoun_proyecto.`tb_trabajo tb_estudiante` `tb_trabajo tb_estudiante`
 WHERE `tb_trabajo tb_estudiante`.id_trabajo ='".$id_documento."'"));
 
 $director=mysqli_num_rows(mysqli_query($link,"SELECT `tb_trabajo tb_director`.id_director
  FROM pegasoun_proyecto.`tb_trabajo tb_director` `tb_trabajo tb_director`
 WHERE `tb_trabajo tb_director`.id_trabajo ='".$id_documento."' "));
 
 $directores=mysqli_query($link,"SELECT tb_director.id_usuario, tb_usuario.nombre, tb_usuario.apellido
  FROM    pegasoun_proyecto.tb_director tb_director
       JOIN
          pegasoun_proyecto.tb_usuario tb_usuario
       ON (tb_director.id_usuario = tb_usuario.id_usuario)
 WHERE tb_director.estado = 1");
 
 $jurado=mysqli_query($link,"SELECT tb_jurado.id_usuario, tb_usuario.nombre, tb_usuario.apellido
  FROM    pegasoun_proyecto.tb_jurado tb_jurado
       JOIN
          pegasoun_proyecto.tb_usuario tb_usuario
       ON (tb_jurado.id_usuario = tb_usuario.id_usuario)
 WHERE tb_jurado.estado = 1");
 
 $jurado2=mysqli_query($link,"SELECT tb_jurado.id_usuario, tb_usuario.nombre, tb_usuario.apellido
  FROM    pegasoun_proyecto.tb_jurado tb_jurado
       JOIN
          pegasoun_proyecto.tb_usuario tb_usuario
       ON (tb_jurado.id_usuario = tb_usuario.id_usuario)
 WHERE tb_jurado.estado = 1");
 
 $programa=mysqli_query($link,"SELECT tb_programa.id_programa, tb_programa.nombre
  FROM pegasoun_proyecto.tb_programa tb_programa");
  
 $programa2=mysqli_query($link,"SELECT tb_programa.id_programa, tb_programa.nombre
  FROM pegasoun_proyecto.tb_programa tb_programa");
  
 $programa3=mysqli_query($link,"SELECT tb_programa.id_programa, tb_programa.nombre
  FROM pegasoun_proyecto.tb_programa tb_programa");
  $programa4=mysqli_query($link,"SELECT tb_programa.id_programa, tb_programa.nombre
  FROM pegasoun_proyecto.tb_programa tb_programa");
  $modaliad=mysqli_query($link,'SELECT tb_modalidad.modalidad, tb_modalidad.id_modalidad
  FROM pegasoun_proyecto.tb_modalidad tb_modalidad
 WHERE tb_modalidad.estado = 1');
?>

<script type="text/javascript">
$(document).ready(function(e) {

    $("#btn_actas").click(function() {
            $("#txt_documento").click();//$("#txt_documento txt_acta_individual").click();
        });
	
	$("#btn_documento").click(function(e) {//esta funcion sirve
		//tipo=0;
		
		if(($("#codigo1").val()!='' && $("#nombre1").val()!='' && $("#apellido1").val()!='' && $("#telefono1").val()!='' && $("#correo1").val()!='' && $("#select1").val()!=0) || ($("#codigo2").val!='' && $("#nombre2").val()!='' && $("#apellido2").val()!='' && $("#telefono2").val()!='' && $("#correo2").val()!='' && $("#select2").val()!=0) || ($("#codigo3").val!='' && $("#nombre3").val()!='' && $("#apellido3").val()!='' && $("#telefono3").val()!='' && $("#correo3").val()!='' && $("#select3").val()!=0)){
			
			
			
			if($("#txt_documento").val()!=""){//"#txt_documento txt_acta_individual"

				var archivo = document.getElementById("txt_documento");
				var file = archivo.files[0];

				var data = new FormData();
				data.append('archivo',file);
				data.append('opcion',1);
				data.append('id_trabajo',$("#id_trabajo").val());
				
				for(i=1; i<=3; i++){
						if($("#codigo"+i).val()!='' && $("#nombre"+i).val()!='' && $("#apellido"+i).val()!='' && $("#select"+i).val()!=0){
						data.append('codigo'+i,$("#codigo"+i).val());
						data.append('nombre'+i,$("#nombre"+i).val());
						data.append('apellido'+i,$("#apellido"+i).val());
						data.append('telefono'+i,$("#telefono"+i).val());
						data.append('correo'+i,$("#correo"+i).val());
						data.append('programa'+i,$("#select"+i).val());							
							}
					}
					
					
						
				$.ajax({
						url:'../consultas_sql/Actualizar_student.php',
						type:'POST',
						data:data,
						dataType:"json",
						processData:false,  
						cache:false,
						contentType:false,
						success: function(msg){
							 alert(msg);
							
								$.ajax({
								  url:'subdirectorios/cuerpo_estudiante.php',
								  type:'POST',
								  data:'user='+$("#id_trabajo").val(),
								  dataType:"html",
								  success: function(msg){
									  $("#cuerpo").html(msg);
									  }
								})
							
							}
		
					})
			}
			
			else{alert("Debe cargar un archivo PDF")}
		
			
		}
		
		else{alert ("Debes Ingresar los Integrantes del Proyecto")}
	
    });



	
$("#btn_documento2").click(function(e) {//Esta funcion sirve
        
		if($('#txt_documento').val()!=''){
			var archivo = document.getElementById("txt_documento");
			var file = archivo.files[0];
			
			var data = new FormData();
				data.append('archivo',file);
				data.append('id_trabajo',$("#id_trabajo").val());
				data.append('opcion',3);
				
			
			$.ajax({
					url:'../consultas_sql/Actualizar_student.php',					
					type:'POST',
					data:data,
					dataType:"json",
					processData:false,  
					cache:false,
					contentType:false,
					success: function(msg){
						alert(msg)
						$.ajax({
								  url:'subdirectorios/cuerpo_estudiante.php',
								  type:'POST',
								  data:'user='+$("#id_trabajo").val(),
								  dataType:"html",
								  success: function(msg){
									  $("#cuerpo").html(msg);
									  }
								})
					}
			})
		
		}
		
		
		else{alert("Debe Cargar un Archivo")}
    });
	
$("#btn_documento3").click(function(e) {//esta funcion sirve
		
		if($('#txt_documento').val()!=''){
			var archivo = document.getElementById("txt_documento");
			var file = archivo.files[0];
			
			var data = new FormData();
				data.append('archivo',file);
				data.append('id_trabajo',$("#id_trabajo").val());
				data.append('opcion',1);
				
				
				if($("#titulo").val()!=""){data.append('titulo', $("#titulo").val())}
				
			$.ajax({
					url:'../sql_eliminar.php',					
					type:'POST',
					data:data,
					dataType:"json",
					processData:false,  
					cache:false,
					contentType:false,
					success: function(msg){
						alert(msg)
						
						$.ajax({
								  url:'subdirectorios/cuerpo_estudiante.php',
								  type:'POST',
								  data:'user='+$("#id_trabajo").val(),
								  dataType:"html",
								  success: function(msg){
									  $("#cuerpo").html(msg);
									  }
								})
					}
			})
		
		}
		
		
		else{alert("Debe Cargar un Archivo")}
    });
	
	
$("#btn_documento4").click(function(e) {
	
		
		if($('#txt_documento').val()!=''){
			var archivo = document.getElementById("txt_documento");
			var file = archivo.files[0];
			
			var data = new FormData();
				data.append('archivo',file);
				data.append('id_trabajo',$("#id_trabajo").val());
				data.append('opcion',2);
				
				if($("#titulo").val()!="" && $("#modalidad").val()!=0 && $("#programa").val()!=0){
					data.append('titulo',$("#titulo").val());
					data.append('modalidad',$("#modalidad").val());
					data.append('programa',$("#programa").val());
					
					$.ajax({
							url:'../sql_eliminar.php',					
							type:'POST',
							data:data,
							dataType:"json",
							processData:false,  
							cache:false,
							contentType:false,
							success: function(msg){
								alert(msg)
								$.ajax({
								  url:'subdirectorios/cuerpo_estudiante.php',
								  type:'POST',
								  data:'user='+$("#id_trabajo").val(),
								  dataType:"html",
								  success: function(msg){
									  $("#cuerpo").html(msg);
									  }
								})
							}
					})					
							
					
					}
					
				else{alert("Debe Completar Todos los Campos")}
		}
		
		else{alert("Debe Cargar un Archivo")}
    });	


$("#btn_documento6").click(function(e) {//esta funcion sirve
	
       
		if($('#txt_documento').val()!=''){
			var archivo = document.getElementById("txt_documento");
			var file = archivo.files[0];
			
			var data = new FormData();
				data.append('archivo',file);
				data.append('id_trabajo',$("#id_trabajo").val());
				data.append('opcion',2);
				
			
			$.ajax({
					url:'../consultas_sql/Actualizar_student.php',					
					type:'POST',
					data:data,
					dataType:"json",
					processData:false,  
					cache:false,
					contentType:false,
					success: function(msg){
						alert(msg)
						
						$.ajax({
								url:'subdirectorios/cuerpo_estudiante.php',
								type:'POST',
								data:'user='+$("#id_trabajo").val(),
								dataType:"html",
								success: function(msg){
									
									$('#cuerpo').html(msg);
									}
							
							})
					}
			})
		
		}
		
		
		else{alert("Debe Cargar un Archivo")}
    });
	
$("#btn_documento5").click(function(e) {
	
       if($('#juarado1').val()!=0 && $('#juarado2').val()!=0 ){
		if($('#txt_documento').val()!=''){
			var archivo = document.getElementById("txt_documento");
			var file = archivo.files[0];
			
			var data = new FormData();
				data.append('archivo',file);
				data.append('id_trabajo',$("#id_trabajo").val());
				data.append('jurado1', $('#juarado1').val())
				data.append('jurado2', $('#juarado2').val())
				data.append('opcion',18);
				
			
			$.ajax({
					url:'../consultas_sql/Actualizar.php',					
					type:'POST',
					data:data,
					dataType:"json",
					processData:false,  
					cache:false,
					contentType:false,
					success: function(msg){
						alert(msg)
					}
			})
		
		}
		
		
		else{alert("Debe Cargar un Archivo")}
		
	   }
	   
	   else{alert('Debes Selecionar los Jurados Asignados')}
    });
	
	
$("#btn_documento7").click(function(e) {//esta funcion sirve
        
		if($('#txt_documento').val()!=''){
			var archivo = document.getElementById("txt_documento");
			var file = archivo.files[0];
			
			var data = new FormData();
				data.append('archivo',file);
				data.append('id_trabajo',$("#id_trabajo").val());
				data.append('opcion',2);
				
			
			$.ajax({
					url:'../consultas_sql/Actualizar_student.php',					
					type:'POST',
					data:data,
					dataType:"json",
					processData:false,  
					cache:false,
					contentType:false,
					success: function(msg){
						alert(msg)
						$.ajax({
								  url:'subdirectorios/cuerpo_estudiante.php',
								  type:'POST',
								  data:'user='+$("#id_trabajo").val(),
								  dataType:"html",
								  success: function(msg){
									  $("#cuerpo").html(msg);
									  }
								})
					}
			})
		
		}
		
		
		else{alert("Debe Cargar un Archivo")}
    });
	

$("#btn_documento8").click(function(e) {
        
		if($('#txt_documento').val()!=''){
			var archivo = document.getElementById("txt_documento");
			var file = archivo.files[0];
			
			var data = new FormData();
				data.append('archivo',file);
				data.append('id_trabajo',$("#id_trabajo").val());
				data.append('opcion',27);
				
			
			$.ajax({
					url:'../consultas_sql/Actualizar.php',					
					type:'POST',
					data:data,
					dataType:"json",
					processData:false,  
					cache:false,
					contentType:false,
					success: function(msg){
						alert(msg)
						$.ajax({
								  url:'subdirectorios/cuerpo_estudiante.php',
								  type:'POST',
								  data:'user='+$("#id_trabajo").val(),
								  dataType:"html",
								  success: function(msg){
									  $("#cuerpo").html(msg);
									  }
								})
					}
			})
		
		}
		
		
		else{alert("Debe Cargar un Archivo")}
    });


$("#btn_documento9").click(function(e) {//esta funcion sirve
//		tipo=0;
		if(($("#codigo1").val()!='' && $("#nombre1").val()!='' && $("#apellido1").val()!='' && $("#telefono1").val()!='' && $("#correo1").val()!='' && $("#select1").val()!=0) || ($("#codigo2").val!='' && $("#nombre2").val()!='' && $("#apellido2").val()!='' && $("#telefono2").val()!='' && $("#correo12").val()!='' && $("#select2").val()!=0) || ($("#codigo3").val!='' && $("#nombre3").val()!='' && $("#apellido3").val()!='' && $("#telefono3").val()!='' && $("#correo3").val()!='' && $("#select3").val()!=0)){
			
		var archivo = document.getElementById("txt_documento");
		var file = archivo.files[0];
		
		
			if($("#txt_documento").val()!=""){
				var data = new FormData();
				data.append('archivo',file);
				data.append('opcion',5);
				data.append('id_trabajo',$("#id_trabajo").val());
				
				for(i=1; i<=3; i++){
						if($("#codigo"+i).val()!='' && $("#nombre"+i).val()!='' && $("#apellido"+i).val()!='' && $("#select"+i).val()!=0){
						
						data.append('codigo'+i,$("#codigo"+i).val());
						data.append('nombre'+i,$("#nombre"+i).val());
						data.append('apellido'+i,$("#apellido"+i).val());
						data.append('telefono'+i,$("#telefono"+i).val());
						data.append('correo'+i,$("#correo"+i).val());
						data.append('programa'+i,$("#select"+i).val());							
							
							}
					}
					
					
				$.ajax({
						url:'../consultas_sql/Actualizar_student.php',
						type:'POST',
						data:data,
						dataType:"json",
						processData:false,  
						cache:false,
						contentType:false,
						success: function(msg){
							 alert(msg);
							
								$.ajax({
								  url:'subdirectorios/cuerpo_estudiante.php',
								  type:'POST',
								  data:'user='+$("#id_trabajo").val(),
								  dataType:"html",
								  success: function(msg){
									  $("#cuerpo").html(msg);
									  }
								})
							
							}
		
					})
			}
			
			else{alert("Debe cargar un archivo PDF")}
		
			
		}
		
		else{alert ("Debes Ingresar los Integrantes del Proyecto")}
	
    });
});


function cambiar_acta(value){
	
	$("#txt_acta_individual").val(value);
	
	}

</script>

<style type="text/css">
.btn_documento{
	width:200px;
	height:40px; 
	background:#A00000;
	border-radius:5px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	color:#FFF;
	cursor:pointer;
	}
	
#txt_documento{
	opacity:0;
	visibility:hidden;}
	
.label{
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;}

.input_estudiante{
	height:30px;
	width:300px;
	border-radius:5px;
	border:1px solid #000;
	font-family:Arial, Helvetica, sans-serif;
	font-size:20px;}
	
.selec_mul{
	width:300px;
	height:30px;
	border-radius:5px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;}
</style>
<h1>Bienvenido, ahora puede cargar el archivo.</h1>
<h3>Estás en la etapa de <?php echo $etapa?>.</h3>
<?php if($consul['tipo_documento']!=0) { echo '<h2>'.$informe_num.'</h2>';} ?>



<?php 
	if($consul['tipo_documento']==0 && $consul['habilita_plataforma']==1 && $consul['estado_proyecto']==1){include "etapa_propuesta.php";}
	if($consul['tipo_documento']==0 && $consul['habilita_plataforma']==1 && $consul['estado_proyecto']==3){include "volver_propuesta.php";}
	
	
	if($consul['tipo_documento']==1 && $consul['habilita_plataforma']==1){include "etapa_proyecto.php";}
	
	if($consul['tipo_documento']==2 && $consul['habilita_plataforma']==1){include "informe_final.php";}
	if($consul['habilita_plataforma']==3){echo "El administrador aun no ha hecho revision de tu documento, por lo cual creemos que todavia sigue en estado pendiente.<br>Recomendamos estar atentos para que revises periodicamente la plataforma y saber que novedades han ocurrido con tus documentos.<br><h2>GRACIAS</h2> ";}
?>


