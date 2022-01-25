<?php
session_start();
include "../connections/conection.php";

$fecha_final=new DateTime(date('Y-m-d'));

$string=$_POST['string'];

$datos=mysqli_query($link,"SELECT tb_trabajo.id_trabajo,
       tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       tb_trabajo.fecha_aprobacion,
       tb_comunicacion.tipo_documento
  FROM    pegasoun_proyecto.tb_comunicacion tb_comunicacion
       JOIN
          pegasoun_proyecto.tb_trabajo tb_trabajo
       ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE tb_trabajo.titulo LIKE '%$string%' OR tb_trabajo.codigo_trabajo LIKE '%$string%' ORDER BY tb_trabajo.fecha_aprobacion ASC LIMIT 10");

$table='<table width="80%" cellspacing="0" border="1" align="center">
    	<tr>
        	<th width="14%">Código</th>
            <th>Título</th>
            <th width="12%">Fecha Aprobación</th>
            <th>Etapa</th>
            
            <th>Historial</th>
        </tr>';
		
			 while($f=mysqli_fetch_assoc($datos)){
				 
				
					 	if($f['tipo_documento']==0){$etapa="Propuesta";}
				 		if($f['tipo_documento']==1){$etapa="Proyecto";}
				 		if($f['tipo_documento']==2){$etapa="Informe";}

				 		if($f['fecha_aprobacion']!=0){
				 			$fecha=explode('-', $f['fecha_aprobacion']);
				 			$mes=obtenerMesCorto($fecha[1]);
							$fecha=$fecha[2].' '.$mes.' '.$fecha[0];

				 		}

				 		else{$fecha='En espera';}
						
						$table.='<tr>
							<td align="center" height="70px">'.$f['codigo_trabajo'].'</td>
							<td align="center" style="font-size:12px">'.$f['titulo'].'</td>
							<td align="center">'.$fecha.'</td>
							<td align="center">'.$etapa.'</td>
							
							<td align="center"><p class="p" onClick="historial('.$f['id_trabajo'].')">Ver</p></td>				 
						  </tr>';
		 } 
    $table.='</table>';

    echo $table;
?>