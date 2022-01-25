<?php
include "../../../connections/conection.php";
$fecha_final=new DateTime(date('Y-m-d'));
$etapa='';

$datos=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
       tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       tb_trabajo.fecha_aprobacion,
       tb_comunicacion.tipo_documento
  FROM    pegasoun_proyecto.tb_comunicacion tb_comunicacion
       JOIN
          pegasoun_proyecto.tb_trabajo tb_trabajo
       ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE tb_comunicacion.estado_proyecto = 1
ORDER BY tb_trabajo.fecha_aprobacion ASC");
	   

	 
?>

<script type="text/javascript">

function cargando(){
	$("#txt_documento").click();
}


function cambiar_acta(documento){

	$("#txt_acta_individual").val(documento);
}


function desvincular(){
	var inputFileImage = document.getElementById("txt_documento");
	var file = inputFileImage.files[0];
	var data = new FormData();

	data.append('id_usuario', $("#integrante").val());
	data.append('desercion', $("#motivo_dersercion").val());
	data.append('archivo',file);
	data.append('opcion',29);

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
				
				}
		
		});
	
}

function cancelar_proyecto(id_trabajo, codigo_trabajo){

	data='id_trabajo='+id_trabajo+'&opcion='+30;

	 if (confirm('¿Estas seguro de Cancelar El proyecto '+codigo_trabajo+'?')){
			$.ajax({
					url:'../consultas_sql/Actualizar.php',
					type:'POST',
					data:data,
					dataType:"json",
					success: function(msg){
						alert(msg);
						
						}
			});
		}
}

function cambios(id_trabajo){
	director=$("#selec_director").val();
	jurado1=$("#jurado1").val();
	jurado2=$("#jurado2").val();
	
	
	data='id_trabajo='+id_trabajo+'&opcion='+26+'&director='+director+'&jurado1='+jurado1+'&jurado2='+jurado2;
	
		$.ajax({
			url:'../consultas_sql/Actualizar.php',
			type:'POST',
			data:data,
			dataType:"json",
			success: function(msg){
				alert(msg);
				
				}
		
		});

	}


function cambios_tuto(id_trabajo){
	Tutor_interno=$("#selec_interno").val();
	Tutor_externo=$("#selec_externo").val();
	
	
	data='id_trabajo='+id_trabajo+'&opcion='+27+'&tuto_inter='+Tutor_interno+'&tuto_exter='+Tutor_externo;
	
		$.ajax({
			url:'../consultas_sql/Actualizar.php',
			type:'POST',
			data:data,
			dataType:"json",
			success: function(msg){
				alert(msg);
				
				}
		
		});

	}

function cambios_investi(id_trabajo){
	dir_investi=$("#selec_director_invest").val();
	
	
	data='id_trabajo='+id_trabajo+'&opcion='+28+'&dir_investi='+dir_investi;
	
		$.ajax({
			url:'../consultas_sql/Actualizar.php',
			type:'POST',
			data:data,
			dataType:"json",
			success: function(msg){
				alert(msg);
				
				}
		
		});


}


function historial_proyec(id_trabajo){
	window.open("../documentos_pdf/historial.php?id_trabajo="+id_trabajo, "_blank");

}

function historial(id_trabajo){

	$.ajax({
			url:'../consultas_sql/formularios_historial.php',
			type:'POST',
			data:'id_trabajo='+id_trabajo,
			dataType:"html",
			success: function(msg){
				$("#historiales2").html(msg);
				$("#historiales2").fadeIn(0);
				$("#historial").fadeOut(0);
				
				}
		
		});
	}
	
function modificar(id_trabajo){
	$.ajax({
			url:'../consultas_sql/datos_modificar.php',
			type:'POST',
			data:'id_trabajo='+id_trabajo,
			dataType:"html",
			success: function(msg){
				$("#datos_modificar").html(msg);
				
				}
		
		});
	
	
	}

function buscar(string){

	$.ajax({
			url:'../consultas_sql/buscar_documento.php',
			type:'POST',
			data:'string='+string,
			dataType:"html",
			success: function(msg){
				$("#historial").html(msg);
				$("#historial").fadeIn(0);
				$("#historiales2").fadeOut(0);
				}
		
		});
	
}

function mostrar_datos(id_usuario){
	$.ajax({
			url:'../consultas_sql/ConsulSql.php',
			type:'POST',
			data:'id_usuario='+id_usuario+'&opcion='+6,
			dataType:"json",
			success: function(msg){
						if(id_usuario!=0){

							$("#correo_student").val(msg.correo);
							$("#telefono_student").val(msg.telefono);
						}
				}
		
		});

}

</script>
<style type="text/css">
.none{
	display: none;
}
.input{
	
	width:300px;
	height:30px;
	margin-top:20px;
	margin-bottom:20px;
	font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size:16px;
	padding-left:5px;}

.p{cursor:pointer;}

.encabezado_proyecto{text-align:center;width:310px;}
.hijo{display: table-cell;
	vertical-align: middle;}

.tabla{border:0px solid #000; width:100%;}

.encabezado_proyecto, .cuerpo_proyecto{
	
	height:40px;
	border:1px solid #000;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	display: table;
	}

.cuerpo_proyecto{ padding-left:10px; padding-right:10PX; border-top:0px;width:290px; text-align:justify;}

.btn_propuestas{
	width:100px;
	height:50px;
	margin-right:5px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12;
	color:#FFF;
	border-radius:5px;
	background:#06F;
	margin-top:2px;
	cursor:pointer;}
	
#datos_modificar{
	margin-top:10px;}
	
#selec_director, #selec_interno, #selec_externo, #selec_director_invest{
	width:300px;
	height:30px;
	}
	
.label{
	margin-right:10px;
	font-family:arial;
	font-size:14px; }
	
.selec_jurado{
	width:300px;
	height:30px;}
	
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

</style>

<input type="text" class="input" placeholder="Código o nombre del Proyecto" onkeyup="buscar(this.value)">

<div id="historial">
	<table width="80%" cellspacing="0" border="1" align="center">
    	<tr>
        	<th width="14%">Código</th>
            <th>Título</th>
            <th width="12%">Fecha Aprobación</th>
            <th>Etapa</th>
            <th width="10%">Tiempo de Ejecución</th>
            <th>Historial</th>
        </tr>
        
        <?php
			 while($f=mysqli_fetch_assoc($datos)){
				 
				 
				 
				 $fecha_inicial=new DateTime($f['fecha_aprobacion']);
			     $diferencia=$fecha_inicial->diff($fecha_final);
			     $meses=($diferencia->y*12)+$diferencia->m;
				 
				 if($meses>=12){
					 	if($f['tipo_documento']==0){$etapa="Propuesta";}
				 		if($f['tipo_documento']==1){$etapa="Proyecto";}
				 		if($f['tipo_documento']==2){$etapa="Informe";}
						$fecha=explode('-', $f['fecha_aprobacion']);
						
						$mes=obtenerMesCorto($fecha[1]);
						$fecha=$fecha[2].' '.$mes.' '.$fecha[0];
				 
						echo '<tr>
							<td align="center" height="70px">'.$f['codigo_trabajo'].'</td>
							<td align="center" style="font-size:12px">'.$f['titulo'].'</td>
							<td align="center">'.$fecha.'</td>
							<td align="center">'.$etapa.'</td>
							<td  align="center">'.$meses.' Meses</td>
							<td align="center"><p class="p" onClick="historial('.$f['id_trabajo'].')">Ver</p></td>				 
						  </tr>';
					 }
			 
		 
		 } 
		
		?>
    
    </table>
</div>

<div id="historiales2" style="margin:0px auto; width:900px;"></div>

