<?php
function Desarrollo_gestion($integrantes, $director, $programa, $programa2, $programa3, $directores){
$html='';
 if($integrantes==0){
 	
    $html='<h2>Integrantes Del Proyecto</h2>
   
    <table align="center">
    	<tr>
        	<td><label>Código Estudiantil</label></td>
            <td><input type="text" class="input_estudiante" id="codigo1"></td>
        </tr>
        
        <tr>
        	<td><label>Nombre</label></td>
            <td><input type="text" class="input_estudiante" id="nombre1"></td>
        </tr>
         <tr>
        	<td><label>Apellido</label></td>
            <td><input type="text" class="input_estudiante" id="apellido1"></td>
        </tr>
		<tr>
        	<td><label>Teléfono</label></td>
            <td><input type="text" class="input_estudiante" id="telefono1"></td>
        </tr>
		<tr>
        	<td><label>Correo</label></td>
            <td><input type="text" class="input_estudiante" id="correo1"></td>
        </tr>
        <tr height="50px" valign="top">
        	<td><label>Programa</label></td>
            <td><select class="input_estudiante" id="select1">
                	<option value="0">Selecione Programa</option>';
                    
						while($f=mysqli_fetch_array($programa)){
                        
							$html.='<option value="'.$f['id_programa'].'">'. $f['nombre'].'</option>';
							
						}
					 
                    
                $html.='</select></td>
       						</tr>
							
							<tr>
								<td><label>Código Estudiantil</label></td>
								<td><input type="text" class="input_estudiante" id="codigo2"></td>
							</tr>
							
							<tr>
								<td><label>Nombre</label></td>
								<td><input type="text" class="input_estudiante" id="nombre2"></td>
							</tr>
							
							 <tr>
								<td><label>Apellido</label></td>
								<td><input type="text" class="input_estudiante" id="apellido2"></td>
							</tr>
							<tr>
        						<td><label>Teléfono</label></td>
            					<td><input type="text" class="input_estudiante" id="telefono2"></td>
        					</tr>
							<tr>
        						<td><label>Correo</label></td>
            					<td><input type="text" class="input_estudiante" id="correo2"></td>
        					</tr>
							
							<tr height="50px" valign="top">
								<td><label>Programa</label></td>
								<td><select class="input_estudiante" id="select2">
										<option value="0">Selecione Programa</option>';
								
						while($f=mysqli_fetch_array($programa2)){
                        
									$html.='<option value="'.$f['id_programa'].'">'.$f['nombre'].'</option>';
							
								}
					 
                    
                $html.='</select></td>
						</tr>
						
						<tr>
							<td><label>Código Estudiantil</label></td>
							<td><input type="text" class="input_estudiante" id="codigo3"></td>
						</tr>
						
						<tr>
							<td><label>Nombre</label></td>
							<td><input type="text" class="input_estudiante" id="nombre3"></td>
						</tr>
						
						 <tr>   
							<td><label>Apellido</label></td>
							<td><input type="text" class="input_estudiante" id="apellido3"></td>
						</tr>
						<tr>
        					<td><label>Teléfono</label></td>
           		 			<td><input type="text" class="input_estudiante" id="telefono3"></td>
        				</tr>
						<tr>
        					<td><label>Correo</label></td>
            				<td><input type="text" class="input_estudiante" id="correo3"></td>
       					</tr>
						<tr height="50px" valign="top">
							<td><label>Programa</label></td>
							<td><select class="input_estudiante" id="select3">
									<option value="0">Selecione Programa</option>';
                   
						while($f=mysqli_fetch_array($programa3)){
                        
							$html.='<option value="'.$f['id_programa'].'">'.$f['nombre'].'</option>';
							
						  }
                $html.='    
            </td>
        </tr>
    </table>';
	 }
	
		
	$html.='<div id="subir_acta" style="width:200px; margin-top:10px; display:inline-block;">
			<button id="btn_actas" class="btn_documento">Cargar Documento</button>
			<input type="text" id="txt_acta_individual" style="margin-top:10px; margin-bottom:10px; width:200px; height:30px">';
    
    if($integrantes==0){
     		$html.='<button id="btn_documento" class="btn_documento">Enviar</button>';
      }
		
	else{
					$html.='<button id="btn_documento2" class="btn_documento">Enviar</button>';
		}
	
	
$html.='</div>
			<div id="file">
				<input type="file" id="txt_documento" accept="application/pdf" onChange="cambiar_acta(this.value)" style="display:inline-block">
		</div>';

	

	return $html;
	
	}
	
function formulacion_investigacion($integrantes, $director, $programa, $programa2, $programa3, $directores, $link){
	
	
	
	$html='';

 if($integrantes==0 && $director==0){
 	
    $html.='<h2>Integrantes Del Proyecto</h2>
   
    <table align="center">
    	<tr>
        	<td><label>Codigo Estudiantil</label></td>
            <td><input type="text" class="input_estudiante" id="codigo1"></td>
        </tr>
        
        <tr>
        	<td><label>Nombre</label></td>
            <td><input type="text" class="input_estudiante" id="nombre1"></td>
        </tr>
         <tr>
        	<td><label>Apellido</label></td>
            <td><input type="text" class="input_estudiante" id="apellido1"></td>
        </tr>
		<tr>
        	<td><label>Teléfono</label></td>
           	<td><input type="text" class="input_estudiante" id="telefono1"></td>
        </tr>
		<tr>
        	<td><label>Correo</label></td>
            <td><input type="text" class="input_estudiante" id="correo1"></td>
       	</tr>

        <tr height="50px" valign="top">
        	<td><label>Programa</label></td>
            <td><select class="input_estudiante" id="select1">
                	<option value="0">Selecione Programa</option>';
                    
						while($f=mysqli_fetch_array($programa)){
                        
							$html.='<option value="'.$f['id_programa'].'">'. $f['nombre'].'</option>';
							
						}
					 
                    
                $html.='</select></td>
       						</tr>
							
							<tr>
								<td><label>Codigo Estudiantil</label></td>
								<td><input type="text" class="input_estudiante" id="codigo2"></td>
							</tr>
							
							<tr>
								<td><label>Nombre</label></td>
								<td><input type="text" class="input_estudiante" id="nombre2"></td>
							</tr>
							
							 <tr>
								<td><label>Apellido</label></td>
								<td><input type="text" class="input_estudiante" id="apellido2"></td>
							</tr>
							<tr>
        						<td><label>Teléfono</label></td>
           						<td><input type="text" class="input_estudiante" id="telefono2"></td>
        					</tr>
							<tr>
        						<td><label>Correo</label></td>
            					<td><input type="text" class="input_estudiante" id="correo2"></td>
       						</tr>

							
							<tr height="50px" valign="top">
								<td><label>Programa</label></td>
								<td><select class="input_estudiante" id="select2">
										<option value="0">Selecione Programa</option>';
								
						while($f=mysqli_fetch_array($programa2)){
                        
									$html.='<option value="'.$f['id_programa'].'">'.$f['nombre'].'</option>';
							
								}
					 
                    
                $html.='</select></td>
						</tr>
						
						<tr>
							<td><label>Codigo Estudiantil</label></td>
							<td><input type="text" class="input_estudiante" id="codigo3"></td>
						</tr>
						
						<tr>
							<td><label>Nombre</label></td>
							<td><input type="text" class="input_estudiante" id="nombre3"></td>
						</tr>
						
						 <tr>   
							<td><label>Apellido</label></td>
							<td><input type="text" class="input_estudiante" id="apellido3"></td>
						</tr>
						<tr>
        					<td><label>Teléfono</label></td>
           					<td><input type="text" class="input_estudiante" id="telefono3"></td>
        				</tr>
						<tr>
        					<td><label>Correo</label></td>
            				<td><input type="text" class="input_estudiante" id="correo3"></td>
       					</tr>

						<tr height="50px" valign="top">
							<td><label>Programa</label></td>
							<td><select class="input_estudiante" id="select3">
									<option value="0">Selecione Programa</option>';
                   
						while($f=mysqli_fetch_array($programa3)){
                        
							$html.='<option value="'.$f['id_programa'].'">'.$f['nombre'].'</option>';
							
						  }
					
                    
                $html.='</select></td>
						</tr>
				   </table>';
	 }
	 
	 
	$html.='<div id="subir_acta" style="width:200px; margin-top:10px; display:inline-block;">
	<button id="btn_actas" class="btn_documento">Cargar Documento</button>
    <input type="text" id="txt_acta_individual" style="margin-top:10px; margin-bottom:10px; width:200px; height:30px">';
    
    if($integrantes==0 && $director==0){
     		$html.='<button id="btn_documento" class="btn_documento">Enviar</button>';
      }
		
	else{
					$html.='<button id="btn_documento2" class="btn_documento">Enviar</button>';
		}
	
	
$html.='</div>
			<div id="file">
				<input type="file" id="txt_documento" accept="application/pdf" onChange="cambiar_acta(this.value)" style="display:inline-block">
		</div>';
	return $html;
	
	
	}
	
function integrantes($id_trabajo, $link){
	
	$programa=programa($link);
    $html='<h2>Integrantes Del Trabajo</h2>
   
    <table align="center">
    	<tr>
        	<td><label>Codigo Estudiantil</label></td>
            <td><input type="text" class="input_estudiante" id="codigo1"></td>
        </tr>
        
        <tr>
        	<td><label>Nombre</label></td>
            <td><input type="text" class="input_estudiante" id="nombre1"></td>
        </tr>
         <tr>
        	<td><label>Apellido</label></td>
            <td><input type="text" class="input_estudiante" id="apellido1"></td>
        </tr>
		<tr>
        	<td><label>Teléfono</label></td>
           	<td><input type="text" class="input_estudiante" id="telefono1"></td>
        </tr>
		<tr>
        	<td><label>Correo</label></td>
            <td><input type="text" class="input_estudiante" id="correo1"></td>
       	</tr>
        <tr height="50px" valign="top">
        	<td><label>Programa</label></td>
            <td><select class="input_estudiante" id="select1">
                	<option value="0">Selecione Programa</option>';
                    
						while($f=mysqli_fetch_array($programa)){
                        
							$html.='<option value="'.$f['id_programa'].'">'. $f['nombre'].'</option>';
							
						}
						
						
				$programa2=programa($link);		
                $html.='</select></td>
       						</tr>
							
							<tr>
								<td><label>Codigo Estudiantil</label></td>
								<td><input type="text" class="input_estudiante" id="codigo2"></td>
							</tr>
							
							<tr>
								<td><label>Nombre</label></td>
								<td><input type="text" class="input_estudiante" id="nombre2"></td>
							</tr>
							
							 <tr>
								<td><label>Apellido</label></td>
								<td><input type="text" class="input_estudiante" id="apellido2"></td>
							</tr>
							<tr>
        						<td><label>Teléfono</label></td>
           						<td><input type="text" class="input_estudiante" id="telefono2"></td>
        					</tr>
							<tr>
        						<td><label>Correo</label></td>
            					<td><input type="text" class="input_estudiante" id="correo2"></td>
       						</tr>
							
							<tr height="50px" valign="top">
								<td><label>Programa</label></td>
								<td><select class="input_estudiante" id="select2">
										<option value="0">Selecione Programa</option>';
								
						while($f=mysqli_fetch_array($programa2)){
                        
									$html.='<option value="'.$f['id_programa'].'">'.$f['nombre'].'</option>';
							
								}

				$programa3=programa($link);	
                $html.='</select></td>
						</tr>
						
						<tr>
							<td><label>Codigo Estudiantil</label></td>
							<td><input type="text" class="input_estudiante" id="codigo3"></td>
						</tr>
						
						<tr>
							<td><label>Nombre</label></td>
							<td><input type="text" class="input_estudiante" id="nombre3"></td>
						</tr>
						
						 <tr>   
							<td><label>Apellido</label></td>
							<td><input type="text" class="input_estudiante" id="apellido3"></td>
						</tr>
						<tr>
        					<td><label>Teléfono</label></td>
           					<td><input type="text" class="input_estudiante" id="telefono2"></td>
        				</tr>
						<tr>
        					<td><label>Correo</label></td>
            				<td><input type="text" class="input_estudiante" id="correo2"></td>
       					</tr>
						<tr height="50px" valign="top">
							<td><label>Programa</label></td>
							<td><select class="input_estudiante" id="select3">
									<option value="0">Selecione Programa</option>';
                   
						while($f=mysqli_fetch_array($programa3)){
                        
							$html.='<option value="'.$f['id_programa'].'">'.$f['nombre'].'</option>';
							
						  }
                $html.='    
            </td>
        </tr>
    </table>';
	 

						
		return $html;
						
		 }

function programa($link){
	
	return mysqli_query($link,"SELECT tb_programa.id_programa, tb_programa.nombre
  FROM pegasoun_proyecto.tb_programa tb_programa");
	
	}	
?>