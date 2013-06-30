<?php
/********************************************************************************
 * gTurnos. Block for moodle which manages the distribution of turns.    
 * Copyright (C) 2006  David Rozas Domingo     david.rozas@gmail.com                
 *                                                                                    
 * This file is part of gTurnos.                                                
 *                                                                              
 * gTurnos is free software; you can redistribute it and/or modify                
 * it under the terms of the GNU General Public License as published by            
 * the Free Software Foundation; either version 2 of the License, or            
 * (at your option) any later version.                                            
 *                                                                                 
 * gTurnos is distributed in the hope that it will be useful,                    
 * but WITHOUT ANY WARRANTY; without even the implied warranty of                
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                
 * GNU General Public License for more details.                                    
 *                                                                                
 * You should have received a copy of the GNU General Public License            
 * along with this program; if not, write to the Free Software                    
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA    
 ********************************************************************************/

/*
 * Created by drozas on 29-oct-06
 *
 * Pide confirmación y valida los datos del nuevo bloque
 */


	require_once("../../config.php");
	require_once("lib.php");
	global $USER;

	///Recogemos datos iniciales pasados por POST
	$courseid = required_param('courseid', PARAM_CLEAN);
	$sesskey = required_param('sesskey', PARAM_ALPHANUM);

	//Esta función checkea que este logueado, y que tenga permisos para estar en este curso.
	//Evitamos que un guest acceda a información que no debería si escribe la url.
	require_login($courseid);

	//Comprobamos que sea profesor, y su sesskey
	if (isteacher($courseid) && confirm_sesskey($sesskey))
	{
		///Recogemos el resto de parámetros POST
		$dia = required_param('dia', PARAM_INT);
		$mes = required_param('mes', PARAM_INT);
		$anyo = required_param('anyo', PARAM_INT);
		$h_inicio = required_param('h_inicio', PARAM_INT);
		$min_inicio = required_param('min_inicio', PARAM_INT);	
		$h_fin = required_param('h_fin', PARAM_INT);
		$min_fin = required_param('min_fin', PARAM_INT);
		$duracion_turno = required_param('duracion_turno', PARAM_INT);
		$n_correctores = required_param('n_correctores', PARAM_INT);
	
		///"Componemos" fecha y horas
		if ($min_inicio<=9)
		{
			$min_inicio = '0'.$min_inicio;
		}
		if ($min_fin<=9)
		{
			$min_fin = '0'.$min_fin;
		}
		$h_inicio_sql  = $h_inicio . ":" . $min_inicio;
		$h_fin_sql = $h_fin . ":" . $min_fin;
		$fecha_sql = $dia . "/" . $mes . "/" . $anyo;
		///Impresión de cabecera moodle con opción de no guardar en cache
	 	print_header_simple(get_string('heading_confirmar_guardar_bloque','block_gturnos'),''
	 						,get_string('heading_confirmar_guardar_bloque','block_gturnos'),'','',false);
	 
	 	///Validamos los datos que pueden presentar problemas
	 	if($n_correctores>0)
	 	{
	 		if($duracion_turno>0)
	 		{
				if(strtotime($h_fin_sql)>strtotime($h_inicio_sql)){
		 						
	 			///Si todo está ok, mostramos pantalla de confirmación.
	 			$mensaje = '<h3>' . get_string('confirmar_datos_bloque','block_gturnos'). '<br>';
				$mensaje .= get_string('dia_entrega','block_gturnos') . $fecha_sql . "<br>";
				$mensaje .= get_string('h_inicio','block_gturnos') . $h_inicio_sql . "<br>";
				$mensaje .= get_string('h_fin','block_gturnos') . $h_fin_sql . "<br>";
				$mensaje .= get_string('duracion','block_gturnos') . $duracion_turno . "<br>";
				$mensaje .= get_string('n_correctores','block_gturnos') . $n_correctores . "<br>";
						
				///Preparamos las url co los datos. Pasamos la fecha campo a campo, para recomponerla
				///después en formato YYYY/MM/DD
				$urlyes = $CFG->wwwroot. '/blocks/gturnos/guardar_bloque.php?courseid=' .$courseid;
				$urlyes .= '&dia=' . $dia . '&mes=' . $mes . '&anyo=' .  $anyo  . '&h_inicio=' . $h_inicio_sql . '&h_fin='. $h_fin_sql;
				$urlyes .= '&duracion_turno='. $duracion_turno . '&n_correctores=' . $n_correctores . '&sesskey=' . $sesskey; 	
				notice_yesno($mensaje,$urlyes,url_pagina_ppal($courseid));
	 			}else{
					error(get_string('e_horas','block_gturnos'),url_registro_bloque($courseid) . '&sesskey=' . $sesskey);
				}
	 		}else{
	 			error(get_string('e_duracion','block_gturnos'),url_registro_bloque($courseid). '&sesskey=' . $sesskey);
	 		}
	 	}else{
	 		error(get_string('e_n_correctores','block_gturnos'),url_registro_bloque($courseid).'&sesskey=' . $sesskey);
	 	}
	 
	
	 	echo '<br>';
	 	///Impresión de pie de página moodle
		print_footer($courseid);
	}else{
		redirect(url_pagina_ppal($courseid),'',0);
	}
 ?>
