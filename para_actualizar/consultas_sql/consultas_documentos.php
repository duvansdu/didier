<?php
$desa_tecno=mysqli_query($link, "SELECT tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       tb_trabajo.id_trabajo,
       tb_programa.id_programa,
	   tb_trabajo.id_modalidad,
       tb_programa.nombre,
       `tb_trabajo tb_desarrollo tecnologico`.propuesta,
       tb_comunicacion.emisor,
       tb_comunicacion.recetor
  FROM    (   (   pegasoun_proyecto.tb_comunicacion tb_comunicacion
               JOIN
                  pegasoun_proyecto.tb_trabajo tb_trabajo
               ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo))
           JOIN
              pegasoun_proyecto.tb_programa tb_programa
           ON (tb_trabajo.id_programa = tb_programa.id_programa))
       JOIN
          pegasoun_proyecto.`tb_trabajo tb_desarrollo tecnologico` `tb_trabajo tb_desarrollo tecnologico`
       ON (`tb_trabajo tb_desarrollo tecnologico`.id_trabajo =
              tb_trabajo.id_trabajo)
 WHERE     tb_comunicacion.tipo_documento = '0'
 	   AND (tb_comunicacion.emisor = '4' OR tb_comunicacion.emisor='1')
	   AND tb_comunicacion.recetor = '3'
       AND tb_comunicacion.habilita_plataforma = '0'
       AND tb_comunicacion.estado_proyecto = '1'
       AND tb_programa.id_programa = '".$f['id_programa']."'");
 
 	$rows=mysqli_num_rows($desa_tecno);
	$sum+=$rows;
	
	
$gest_empre=mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo,
       tb_trabajo.id_trabajo,
       tb_trabajo.titulo,
       tb_programa.id_programa,
	   tb_trabajo.id_modalidad,
       tb_programa.nombre,
       `tb_trabajo tb_gestion_empresarial`.propuesta,
       tb_comunicacion.emisor,
       tb_comunicacion.recetor
  FROM    (   (   pegasoun_proyecto.tb_comunicacion tb_comunicacion
               JOIN
                  pegasoun_proyecto.tb_trabajo tb_trabajo
               ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo))
           JOIN
              pegasoun_proyecto.tb_programa tb_programa
           ON (tb_trabajo.id_programa = tb_programa.id_programa))
       JOIN
          pegasoun_proyecto.`tb_trabajo tb_gestion_empresarial` `tb_trabajo tb_gestion_empresarial`
       ON (`tb_trabajo tb_gestion_empresarial`.id_trabajo =
              tb_trabajo.id_trabajo)
 WHERE     tb_comunicacion.tipo_documento = '0'
       AND (tb_comunicacion.emisor = '4' OR tb_comunicacion.emisor = '1')
       AND tb_comunicacion.recetor = '3'
       AND tb_comunicacion.habilita_plataforma = '0'
       AND tb_comunicacion.estado_proyecto = '1'
       AND tb_programa.id_programa ='".$f["id_programa"]."' ");
	 $rows=mysqli_num_rows($gest_empre);
	$sum+=$rows;

$formu_inves=mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo,
       tb_trabajo.id_trabajo,
       tb_trabajo.titulo,
       tb_programa.id_programa,
       tb_trabajo.id_modalidad,
       tb_programa.nombre,
       `tb_trabajo tb_formulacion_investigacion`.propuesta,
       tb_comunicacion.emisor,
       tb_comunicacion.recetor
  FROM    (   (   pegasoun_proyecto.tb_trabajo tb_trabajo
               JOIN
                  pegasoun_proyecto.tb_programa tb_programa
               ON (tb_trabajo.id_programa = tb_programa.id_programa))
           JOIN
              pegasoun_proyecto.`tb_trabajo tb_formulacion_investigacion` `tb_trabajo tb_formulacion_investigacion`
           ON (`tb_trabajo tb_formulacion_investigacion`.id_trabajo =
                  tb_trabajo.id_trabajo))
       JOIN
          pegasoun_proyecto.tb_comunicacion tb_comunicacion
       ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE     tb_comunicacion.tipo_documento = '0'
       AND (tb_comunicacion.emisor = '4' OR tb_comunicacion.emisor = '1')
       AND tb_comunicacion.recetor = '3'
       AND tb_comunicacion.habilita_plataforma = '0'
       AND tb_comunicacion.estado_proyecto = '1'
       AND tb_programa.id_programa = '".$f["id_programa"]."' "); 
	 $rows=mysqli_num_rows($formu_inves);
	 $sum+=$rows; 
	 
$Practica_profesional=mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo,
       tb_trabajo.titulo,
       tb_trabajo.id_trabajo,
       tb_programa.id_programa,
	   tb_trabajo.id_modalidad,
       tb_programa.nombre,
       `tb_trabajo tb_pofesional`.plan_trabajo,
       tb_comunicacion.emisor,
       tb_comunicacion.recetor
  FROM    (   (   pegasoun_proyecto.tb_comunicacion tb_comunicacion
               JOIN
                  pegasoun_proyecto.tb_trabajo tb_trabajo
               ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo))
           JOIN
              pegasoun_proyecto.tb_programa tb_programa
           ON (tb_trabajo.id_programa = tb_programa.id_programa))
       JOIN
          pegasoun_proyecto.`tb_trabajo tb_pofesional` `tb_trabajo tb_pofesional`
       ON (`tb_trabajo tb_pofesional`.id_trabajo = tb_trabajo.id_trabajo)
 WHERE     tb_comunicacion.tipo_documento = '0'
       AND (tb_comunicacion.emisor = '4' OR tb_comunicacion.emisor = '1')
       AND tb_comunicacion.recetor = '3'
       AND tb_comunicacion.habilita_plataforma = '0'
       AND tb_comunicacion.estado_proyecto = '1'
       AND tb_programa.id_programa = '".$f["id_programa"]."' "); 
	 $rows=mysqli_num_rows($Practica_profesional);
	 $sum+=$rows; 

$desa_inves=mysqli_query($link,"SELECT tb_trabajo.codigo_trabajo,
       tb_trabajo.id_trabajo,
       tb_trabajo.titulo,
       tb_programa.id_programa,
       tb_trabajo.id_modalidad,
       tb_programa.nombre,
       `tb_trabajo tb_desarrollo_investigcion`.solicitud_inclusion,
       tb_comunicacion.emisor,
       tb_comunicacion.recetor
  FROM    (   (   pegasoun_proyecto.tb_trabajo tb_trabajo
               JOIN
                  pegasoun_proyecto.tb_programa tb_programa
               ON (tb_trabajo.id_programa = tb_programa.id_programa))
           JOIN
              pegasoun_proyecto.`tb_trabajo tb_desarrollo_investigcion` `tb_trabajo tb_desarrollo_investigcion`
           ON (`tb_trabajo tb_desarrollo_investigcion`.id_trabajo =
                  tb_trabajo.id_trabajo))
       JOIN
          pegasoun_proyecto.tb_comunicacion tb_comunicacion
       ON (tb_comunicacion.id_trabajo = tb_trabajo.id_trabajo)
 WHERE     tb_comunicacion.tipo_documento = '0'
       AND (tb_comunicacion.emisor = '4' OR tb_comunicacion.emisor = '1')
       AND tb_comunicacion.recetor = '3'
       AND tb_comunicacion.habilita_plataforma = '0'
       AND tb_comunicacion.estado_proyecto = '1'
       AND tb_programa.id_programa ='".$f["id_programa"]."'"); 
	 $rows=mysqli_num_rows($desa_inves);
	$sum+=$rows;

?>