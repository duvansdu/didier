<?php if(!isset( $_SESSION['user'])){session_start(); include '../../connections/conection.php';}
$programa=mysqli_query($link,"SELECT tb_programa.nombre, tb_programa.id_programa
  FROM pegasoun_proyecto.tb_programa tb_programa");
$programa2=mysqli_query($link,"SELECT tb_programa.nombre, tb_programa.id_programa
  FROM pegasoun_proyecto.tb_programa tb_programa");
  
  ?>
<script type="text/javascript">

function filtrar_informes(id_programa){
	$.ajax({
		url:'../consultas_sql/formularios_jurado.php',
		data:'id_programa='+id_programa+'&opcion='+2,
		type:'POST',
		dataType:"html",
		success: function(msg){
			$('#arear_trabjo').html(msg)
			
			}
		})
		
		
	}
	
function filtrar_proyectos(id_programa){
	$.ajax({
		url:'../consultas_sql/formularios_jurado.php',
		data:'id_programa='+id_programa+'&opcion='+1,
		type:'POST',
		dataType:"html",
		success: function(msg){
			$('#arear_trabjo').html(msg);
			
			}
		})
		
		
	}
	
function informes(){
	
	$("#filtro_proyectos").fadeOut(0);
	$("#filtro_informes").fadeIn(1);
	
	$.ajax({
			url:"subdirectorios/documentos.php",
			dataType:"html",
			success: function(msg){
				
					$('#arear_trabjo').html(msg)
				
				}
		})
	
	}
	
function proyectos(){
	$("#filtro_proyectos").fadeIn(1);
	$("#filtro_informes").fadeOut(0);
	
	$.ajax({
			url:"subdirectorios/proyectos_jurados.php",
			type:'POST',
			dataType:"html",
			success: function(msg){
					$('#arear_trabjo').html(msg)
				
				}
		})
	
	}
	
function string(id_trabajo){
	
		var string="<p>"+$("#"+id_trabajo).val()+"</p>";
		var capt=$("#anuncio2_"+id_trabajo).val();
		
		
	if(event.keyCode==13){
		$("#anuncio2_"+id_trabajo).val(capt+string);
		$("#carta_"+id_trabajo).html(capt+string);
		$("#"+id_trabajo).val("");
		
		}
	
	}
</script>
<style type="text/css">
.div1{
	width:50%;
	float:left;}
.tbl_tabe{ margin-left:9px; border:0px solid #000; width:97%;}
	
.div2{
	width:50%;
	float:right;
	
	}
	
.div_cuerpo{
	overflow:auto;
	overflow-y:hidden;
	padding-bottom:5px;}
.encabezado_proyecto{text-align:center;width:310px;}

.encabezado_proyecto, .cuerpo_proyecto{
	
	height:40px;
	border:1px solid #000;
	font-family:Arial, Helvetica, sans-serif;
	font-size:15px;
	display: table;
	}

.cuerpo_proyecto{ padding-left:15px; border-top:0px;width:296px; text-align:justify;}
	
.hijo{display: table-cell;
	vertical-align: middle;}
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

.p{color:#06F;}
.textarea{ resize:none;
overflow:hidden;
height:50px;
width:450px;
font-family:Arial, Helvetica, sans-serif;
font-size:12;
text-align:justify}

.a{ cursor:pointer;}
.btn_propuestas2{
	width:150px;
	height:60px;
	margin-right:10px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:16;
	color:#FFF;
	border-radius:5px;
	background:#06F;
	margin-top:2px;
	cursor:pointer;
	
	}

</style>



<div style="margin-top:10px; margin-bottom:15px;">
	<div style="margin-bottom:10px;"><button class="btn_propuestas2" onclick="proyectos()" >Proyectos</button><button class="btn_propuestas2"  onclick="informes()">Informes</button><button class="btn_propuestas2" id="configurarJurado">Configurar</button><button class="btn_propuestas2" style="border-radius:5px; border:1px #000000 solid" id="salir">Cerrar sesión</button></div>
    
   <div id="filtros">
   
   
   <div id="filtro_proyectos">
        <label style="font-family:arial; font-size:14px">Filtrar Por Programa</label>
        <select onchange="filtrar_proyectos(this.value)" class="filtros" id="selec_proyecto">
            <option>Selecione Programa</option>
            
            <?php
                while($f=mysqli_fetch_array($programa)){?>
                    
                    <option value="<?php echo $f['id_programa']?>" ><?php echo $f['nombre']?></option>
            <?php	}
            ?>
        
        </select>
    </div>
    
     <div id="filtro_informes">
        <label style="font-family:arial; font-size:14px">Filtrar Por Programa</label>
        <select onchange="filtrar_informes(this.value)" class="filtros" id="selec_informe">
            <option>Selecione Programa</option>
            
            <?php
                while($f=mysqli_fetch_array($programa2)){?>
                    
                    <option value="<?php echo $f['id_programa']?>" ><?php echo $f['nombre']?></option>
            <?php	}
            ?>
        
        </select>
    </div>
    
    </div>
</div>
<div id="arear_trabjo" style="padding-left:10px;"></div>

