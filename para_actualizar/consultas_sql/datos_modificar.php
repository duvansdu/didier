<?php
include "../connections/conection.php";

$id_trabajo=$_POST['id_trabajo'];

$id_modalidad=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_trabajo.id_modalidad, tb_comunicacion.tipo_documento
  FROM    pegasoun_proyecto.tb_comunicacion tb_comunicacion
       JOIN
          pegasoun_proyecto.tb_trabajo tb_trabajo
       ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE tb_trabajo.id_trabajo = '".$id_trabajo."'"));
 
 /*SIN MODIFICAR
 if(($id_modalidad['id_modalidad']==1 || $id_modalidad['id_modalidad']==4) && $id_modalidad['tipo_documento']!=0){
	 
	 echo Directores($id_trabajo, $link).'<br><br>';
	 echo Jurados($id_trabajo, $link).'<br><br>';
	 
	 echo '<button class="btn_propuestas" onClick="cambios(\''.$id_trabajo.'\')">Realizar Cambios</button>
	 
	 ';
	 }

if($id_modalidad['id_modalidad']==2){

	echo tutor_interno($id_trabajo, $link).'<br><br>';
	echo tutor_externo($id_trabajo, $link).'<br><br>';

	
	

	echo '<button class="btn_propuestas" onClick="cambios_tuto(\''.$id_trabajo.'\')">Realizar Cambios</button>
	';

}


if($id_modalidad['id_modalidad']==3 || $id_modalidad['id_modalidad']==5){

	echo director_invst($id_trabajo, $link).'<br><br>';

	echo '<button class="btn_propuestas" onClick="cambios_investi(\''.$id_trabajo.'\')">Realizar Cambios</button>
	';

}
 
 */
 
 if(($id_modalidad['id_modalidad']==1 || $id_modalidad['id_modalidad']==4) && $id_modalidad['tipo_documento']!=0){
	 echo Directores($id_trabajo, $link).'<br><br>';
	 echo Jurados($id_trabajo, $link).'<br><br>';
	 echo '
	 	<b class="none" id="idTrabajo">'.$id_trabajo.'</b>
	 	<button class="btn_propuestas" id="btnModifica">Realizar Cambios</button>
	 	<script src="./modificar.js"></script>
	 ';
}

if($id_modalidad['id_modalidad']==2){
	echo tutor_interno($id_trabajo, $link).'<br><br>';
	echo tutor_externo($id_trabajo, $link).'<br><br>';
	echo '
		<b class="none" id="idTrabajo">'.$id_trabajo.'</b>
		<button class="btn_propuestas" id="btnModifica">Realizar Cambios</button>
		<script src="./modificar.js"></script>
	';
}


if($id_modalidad['id_modalidad']==3 || $id_modalidad['id_modalidad']==5){
	echo director_invst($id_trabajo, $link).'<br><br>';
	echo '
		<b class="none" id="idTrabajo">'.$id_trabajo.'</b>
		<button class="btn_propuestas" id="btnModifica">Realizar Cambios</button>
		<script src="./modificar.js"></script>
	';
}


	 
echo desvincular($id_trabajo, $link);
 
 



function Directores($id_trabajo, $link){
	
			$director=mysqli_fetch_assoc(mysqli_query($link,"SELECT CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombre, tb_director.id_director
			  FROM pegasoun_proyecto.`tb_trabajo tb_director` `tb_trabajo tb_director`
				   CROSS JOIN pegasoun_proyecto.tb_director tb_director
				   JOIN pegasoun_proyecto.tb_usuario tb_usuario
					  ON (tb_director.id_usuario = tb_usuario.id_usuario)
			 WHERE     tb_director.id_director = `tb_trabajo tb_director`.id_director
				   AND `tb_trabajo tb_director`.id_trabajo =  '".$id_trabajo."'
				   AND `tb_trabajo tb_director`.estado = 1"));
				   
			$directores=mysqli_query($link,"SELECT tb_director.id_director, CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombres			  FROM    pegasoun_proyecto.tb_director tb_director
				   JOIN
					  pegasoun_proyecto.tb_usuario tb_usuario
				   ON (tb_director.id_usuario = tb_usuario.id_usuario)
			 WHERE tb_director.estado = 1");
			 
			 $option='';
			 while($f=mysqli_fetch_array($directores)){
				 $option.='<option value="'.$f['id_director'].'">'.$f['nombres'].'</option>';
				 
				 }
			 
			 
			return $html='<label class="label">Director</label><select id="selec_director">
					<option value="'.$director['id_director'].'">'.$director['nombre'].'</option>'.$option.'
			</select>';
	}

function Jurados($id_trabajo, $link){
	$cod[1]=0;
	$cod[2]=0;
	$html='';
	
	
	$juarado=mysqli_query($link,"SELECT tb_jurado.id_jurado, CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombre
				  FROM    (   pegasoun_proyecto.tb_jurado tb_jurado
						   JOIN
							  pegasoun_proyecto.tb_usuario tb_usuario
						   ON (tb_jurado.id_usuario = tb_usuario.id_usuario))
					   JOIN
						  pegasoun_proyecto.`tb_trabajo tb_jurado` `tb_trabajo tb_jurado`
					   ON (`tb_trabajo tb_jurado`.id_jurado = tb_jurado.id_jurado)
				 WHERE `tb_trabajo tb_jurado`.id_trabajo = '".$id_trabajo."' AND `tb_trabajo tb_jurado`.asignado = 1");
				 
				 
			
		$i=1;				 
		while($f=mysqli_fetch_array($juarado)){
			$juara[$i]=$f['nombre'];
			$cod[$i]=$f['id_jurado'];
			$i++;
			}
		
		if($cod[1]!=0 && $cod[2]!=0){
						
		$html='
		<b class="none" id="idJurado1">'.$cod[1].'</b><p>jurado 1 = '.$juara[1].'</p>
		<b class="none" id="idJurado2">'.$cod[2].'</b><p>jurado 2 = '.$juara[2].'</p>

		<label class="label">Jurado 1</label>
		<select name="jurado1" class="selec_jurado" id="jurado1" style=" margin-right:20px;">
		<option value="'.$cod[1].'">'.$juara[1].'</option>'.Jura($link).'		
		</select>';
		
		$html.='
		<label class="label">Jurado 2</label>
		<select name="jurado2" class="selec_jurado" id="jurado2">
			<option value="'.$cod[2].'">'.$juara[2].'</option>'.Jura($link).'	
		</select>
	
		';
			}
			

		
		
		return $html;
	
	}
	
function Jura($link){
	
	$juarados=mysqli_query($link,"SELECT tb_jurado.id_jurado, CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombres
							  FROM    pegasoun_proyecto.tb_jurado tb_jurado
								   JOIN
									  pegasoun_proyecto.tb_usuario tb_usuario
								   ON (tb_jurado.id_usuario = tb_usuario.id_usuario)
							 WHERE tb_jurado.estado = 1");
	
	$option='';					 
	while($g=mysqli_fetch_array($juarados)){
		
		$option.='<option value="'.$g['id_jurado'].'">'.$g['nombres'].'</option>';
		}
		
	return $option;
	}

function tutor_interno($id_trabajo, $link){
		$tutor_interno=mysqli_fetch_assoc(mysqli_query($link,"SELECT CONCAT(tb_usuario.nombre,' ',
				       tb_usuario.apellido) AS nombre,
				       tb_tutor_interno.id_tutor_interno
				  FROM    (   pegasoun_proyecto.tb_tutor_interno tb_tutor_interno
				           JOIN
				              pegasoun_proyecto.tb_usuario tb_usuario
				           ON (tb_tutor_interno.id_usuario = tb_usuario.id_usuario))
				       JOIN
				          pegasoun_proyecto.tb_histo_tuto_inter tb_histo_tuto_inter
				       ON (tb_histo_tuto_inter.id_tutor_interno =
				              tb_tutor_interno.id_tutor_interno)
				 WHERE tb_histo_tuto_inter.id_trabajo = '".$id_trabajo."' AND tb_histo_tuto_inter.estado = 1"));


								   
				 $tutores=mysqli_query($link,"SELECT CONCAT(tb_usuario.nombre,' ',
									       tb_usuario.apellido) AS nombres,
									       tb_tutor_interno.id_tutor_interno
									  FROM    (   pegasoun_proyecto.tb_tutor_interno tb_tutor_interno
									           JOIN
									              pegasoun_proyecto.tb_usuario tb_usuario
									           ON (tb_tutor_interno.id_usuario = tb_usuario.id_usuario))
									       JOIN
									          pegasoun_proyecto.tb_histo_tuto_inter tb_histo_tuto_inter
									       ON (tb_histo_tuto_inter.id_tutor_interno =
									              tb_tutor_interno.id_tutor_interno)
									 WHERE     tb_tutor_interno.estado = 1
									       AND tb_histo_tuto_inter.estado != 1
									       AND tb_histo_tuto_inter.id_trabajo = '".$id_trabajo."'");


			 
			 $option='';
			 while($f=mysqli_fetch_array($tutores)){
				 $option.='<option value="'.$f['id_tutor_interno'].'">'.$f['nombres'].'</option>';
				 
				 }
			 
			 
			return $html='<label class="label">Tutor Interno</label><select id="selec_interno">
					<option value="'.$tutor_interno['id_tutor_interno'].'">'.$tutor_interno['nombre'].'</option>'.$option.'
			</select>';

}

function tutor_externo($id_trabajo, $link){

		$tutor_externo=mysqli_fetch_assoc(mysqli_query($link,"SELECT CONCAT(tb_usuario.nombre,' ', 
								       tb_usuario.apellido) AS nombre,
								       tb_tutor_externo.id_tutor_externo
								  FROM    (   pegasoun_proyecto.tb_tutor_externo tb_tutor_externo
								           JOIN
								              pegasoun_proyecto.tb_usuario tb_usuario
								           ON (tb_tutor_externo.id_usuario = tb_usuario.id_usuario))
								       JOIN
								          pegasoun_proyecto.tb_histo_tuto_exter tb_histo_tuto_exter
								       ON (tb_histo_tuto_exter.id_tutor_externo =
								              tb_tutor_externo.id_tutor_externo)
								 WHERE tb_histo_tuto_exter.id_trabajo = '".$id_trabajo."' AND tb_histo_tuto_exter.estado = 1"));


								   
		$tutores=mysqli_query($link,"SELECT CONCAT(tb_usuario.nombre,' ',
							       tb_usuario.apellido) AS nombres,
							       tb_tutor_externo.id_tutor_externo
							  FROM    (   pegasoun_proyecto.tb_tutor_externo tb_tutor_externo
							           JOIN
							              pegasoun_proyecto.tb_usuario tb_usuario
							           ON (tb_tutor_externo.id_usuario = tb_usuario.id_usuario))
							       JOIN
							          pegasoun_proyecto.tb_histo_tuto_exter tb_histo_tuto_exter
							       ON (tb_histo_tuto_exter.id_tutor_externo =
							              tb_tutor_externo.id_tutor_externo)
							 WHERE     tb_tutor_externo.estado = 1
							       AND tb_histo_tuto_exter.estado != 1
							       AND tb_histo_tuto_exter.id_trabajo = '".$id_trabajo."'");


			 
			 $option='';
			 while($f=mysqli_fetch_array($tutores)){
				 $option.='<option value="'.$f['id_tutor_externo'].'">'.$f['nombres'].'</option>';
				 
				 }
			 
			 
			return $html='<label class="label">Tutor Externo</label><select id="selec_externo">
					<option value="'.$tutor_externo['id_tutor_externo'].'">'.$tutor_externo['nombre'].'</option>'.$option.'
			</select>';	
}

function director_invst($id_trabajo, $link){

	$director=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_director_investi.id_director_inves,
							       CONCAT(tb_usuario.nombre,' ',
							       tb_usuario.apellido) AS nombre
							  FROM    (   pegasoun_proyecto.tb_director_investi tb_director_investi
							           JOIN
							              pegasoun_proyecto.tb_usuario tb_usuario
							           ON (tb_director_investi.id_usuario = tb_usuario.id_usuario))
							       JOIN
							          pegasoun_proyecto.tb_dir_trabajo tb_dir_trabajo
							       ON (tb_dir_trabajo.id_director_inves =
							              tb_director_investi.id_director_inves)
							 WHERE tb_dir_trabajo.id_trabajo = '".$id_trabajo."' AND tb_dir_trabajo.estado = 1"));

	$id_dir_traba=mysqli_fetch_assoc(mysqli_query($link,"SELECT tb_director_investi.id_director_inves
									  FROM    pegasoun_proyecto.tb_dir_trabajo tb_dir_trabajo
									       JOIN
									          pegasoun_proyecto.tb_director_investi tb_director_investi
									       ON (tb_dir_trabajo.id_director_inves =
									              tb_director_investi.id_director_inves)
									 WHERE tb_dir_trabajo.id_trabajo ='".$id_trabajo."' AND tb_dir_trabajo.estado = 1"));	

	$directores=mysqli_query($link,"SELECT tb_director_investi.id_director_inves,
							       CONCAT(tb_usuario.nombre,' ',
							       tb_usuario.apellido) AS nombres
							  FROM    pegasoun_proyecto.tb_director_investi tb_director_investi
							       JOIN
							          pegasoun_proyecto.tb_usuario tb_usuario
							       ON (tb_director_investi.id_usuario = tb_usuario.id_usuario)
							 WHERE     tb_director_investi.estado = 1
							       AND tb_director_investi.id_director_inves != '".$id_dir_traba['id_director_inves']."' ");


	$option='';
			 while($f=mysqli_fetch_array($directores)){
				 $option.='<option value="'.$f['id_director_inves'].'">'.$f['nombres'].'</option>';
				 
				 }

	return $html='<label class="label">Director</label><select id="selec_director_invest">
					<option value="'.$director['id_director_inves'].'">'.$director['nombre'].'</option>'.$option.'
			</select>';

}


	
function desvincular($id_trabajo, $link){
	
	$html='<h2>Desvincular Estudiante</h2>';
	
	$estudiantes=mysqli_query($link,"SELECT tb_usuario.id_usuario, CONCAT(tb_usuario.nombre,' ', tb_usuario.apellido) AS nombre
  FROM pegasoun_proyecto.`tb_trabajo tb_estudiante` `tb_trabajo tb_estudiante`
       CROSS JOIN pegasoun_proyecto.tb_estudiante tb_estudiante
       JOIN pegasoun_proyecto.tb_usuario tb_usuario
          ON (tb_estudiante.id_usuario = tb_usuario.id_usuario)
 WHERE     `tb_trabajo tb_estudiante`.id_usuario = tb_estudiante.id_usuario
       AND `tb_trabajo tb_estudiante`.id_trabajo = '".$id_trabajo."' AND `tb_trabajo tb_estudiante`.estado=1");
	   
	   $option='';
	   while($f=mysqli_fetch_array($estudiantes)){
		   
		   $option.='<option value="'.$f['id_usuario'].'">'.$f['nombre'].'</option>';
		   
		   }
		   
	$html.='<table align="center">
	
		<tr>
			<td><label class="label">Estudiante</label></td>
			<td>
					<select class="selec_jurado" id="integrante" onChange="mostrar_datos(this.value)">
	  					<option value="0">Selecione Etudiante</option>'.$option.'
	  				</select>
			</td>
		</tr>
		
		<tr>
			<td><label class="label">Correo</label></td>
			<td><input type="text" class="selec_jurado" id="correo_student" /></td>
		</tr>
		<tr>
			<td><label class="label">Télefono</label></td>
			<td><input type="text" class="selec_jurado" id="telefono_student"/></td>
		</tr>
		
		<tr>
			<td><label class="label">Solicitud</label></td>
			<td><textarea cols="50" rows="10" id="motivo_dersercion"></textarea></td>
		</tr>
	</table>';
	
	$html.='<div id="subir_acta" style="width:300px; margin-top:10px; display:inline-block;">
			<button id="btn_actas" class="btn_documento" onClick="cargando()">Cargar Solicitud</button>
			<input type="text" id="txt_acta_individual" style="margin-top:10px; margin-bottom:10px; width:300px; height:30px">
			<button id="btn_actas" class="btn_propuestas" onClick="desvincular()">Desvincular</button>
			</div>
			<div id="file">
				<input type="file" id="txt_documento" accept="application/pdf" onChange="cambiar_acta(this.value)" style="display:inline-block">
		</div>';
	   
	return $html;
	}
?>
