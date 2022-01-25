<?php 
include "../../../connections/conection.php";
$Sql_programa=mysqli_query($link,"SELECT tb_programa.id_programa FROM pegasoun_proyecto.tb_programa tb_programa");
?>

<script>
function mostrar(){
		$("#mostrar_prog").css("visibility","visible");
	}
function buscar_docente_programa(string){
	
	$.ajax({
			url:'../consultas_sql/ConsulSql.php',
			data:'string='+string+'&opcion='+4,
			type:'POST',
			dataType:"html",
			success: function(msg){
				$("#docentes").html(msg)
				}
		})
	
	}
	
var color_i=1;
function coloreando1(i, codigo){
		$("#td_1_"+color_i).removeAttr("bgcolor");
		color_i=i;
		$("#td_1_"+color_i).attr("bgcolor","#CCC");
		
			$.ajax({
					url:"../consultas_sql/ConsulSql.php",
					data:'codigo='+codigo+'&opcion='+5,
					dataType:"html",
					type:'POST',
					success: function(msg){
							$("#rol_docentes1").html(msg);
								
								}
						})

	}
	
function  crear_usuario(j, codigo){
	if($("#select").val()!=0){
	data='codigo='+codigo+'&j='+j;
	for(i=0; i<j; i++){
			
			if($("#check_"+i).is(":checked")){
				data=data+'&check_'+i+'='+$("#check_"+i).val()+'&estado_'+i+'='+1;
				}
				
			else{data=data+'&check_'+i+'='+$("#check_"+i).val()+'&estado_'+i+'='+0;}
		}
		
		data=data+'&select='+$("#select").val()+'&user='+$("#usuario").val()+'&psw='+$("#password").val()+'&select_cargo='+$("#select_cargo").val();
		data=data+'&opcion='+6;
		
		
		if($("#select_cargo").val()!=""){
				$.ajax({
						url:'../consultas_sql/Actualizar.php',
						data:data,
						type:'POST',
						dataType:"json",
						success: function(msg){
							alert(msg);
							}				
					})
	  		}
			
		else{alert("Debes Elegir su cargo");}	
	 
	 }
	 
	else{alert("Debe Selecionar El estado del Usuario")}
	}
	
function btn_crear(){
		var codigo=$("#txt_codigo").val();
		var programa=$("#txt_programa").val();
		//var usuario=$("#usuario").val();
		//var pws=$("#password").val();
		
		$.ajax({
			url:'../consultas_sql/InsertSql.php',
			type:'POST',
			dataType:"json",
			data:'codigo='+codigo+'&programa='+programa+"&opcion="+4,
			success: function(msg){
					alert(msg);
				}
					
			})
	}
	
//function que sirve


	

</script>
<h2>Usuarios Comité</h2>


<label>Docente</label><input type="text"  id="nombre" onkeyup="buscar_docente_programa(this.value)"/>


<div id="docentes" style="width:100%;margin-top:15px"></div>
<div id="rol_docentes1" style="margin-top:15px; "></div>

<br>

<a href="../../../pegaso/listados/observaciones_faltantes_comite.html" target="_black">LISTADO INTEGRANTES DEL COMITE FALTANTES POR REALIZAR OBSERVACIONES</a>

<br>
<!-- <a href="../../../pegaso/listados/proyectos_sistemas.php" target="_black">proyectos_sistemas</a> -->


