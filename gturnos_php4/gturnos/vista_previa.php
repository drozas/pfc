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
 * Created by drozas on 20-oct-06
 *
 * Muestra una lista previa con los alumnos apuntados, aplicando el algoritmo de 
 * reparto de turnos para todos los bloques de ese curso
 */

	require_once("../../config.php");
	require_once("lib.php");
 	/*Recogemos los parámetros que nos pasan por get*/
	$courseid = required_param('course', PARAM_CLEAN);
	$sesskey = required_param('sesskey', PARAM_ALPHANUM);
	
	//Esta función checkea que este logueado, y que tenga permisos para estar en este curso.
	//Evitamos que un guest acceda a información que no debería si escribe la url.
	require_login($courseid);

	//Además comprobamos que sea profe y que la sesskey sea correcta.
	if (isteacher($courseid) && confirm_sesskey($sesskey))
	{
		///Impresión de cabecera moodle con opción de no guardar en cache
	 	print_header_simple(get_string('heading_vista_previa','block_gturnos'),'',
							get_string('heading_vista_previa','block_gturnos'),'','',false);
	 
	 	///Si hay bloques de entrega 
		if(count_records("bloques_entrega", "courseid", $courseid)>0)
		{
			echo '<h2>'. get_string('listado_gral','block_gturnos') . ' : ' . obtener_nombre_curso($courseid) .'</h2>';
			$bloques = get_records("bloques_entrega","courseid",$courseid, "dia");
			
			///Para cada bloque de este curso
			foreach($bloques as $bloque)
			{
				echo '<h3><b>'. get_string('Turno','block_gturnos') . ' : ' . obtener_rango_bloque($bloque->id) . '</h3></b>';	
				
				///Tomamos todos los alumnos de ese bloque ordenados por orden de registro
				$clausula = 'courseid = '. $courseid . ' AND ' . 'bloques_entrega_id = ' . $bloque->id; 
				if(count_records_select("user_bloque",$clausula)>0)
				{
					$alumnos = get_records_select("user_bloque", $clausula, 'fecha_registro');
					
					//Ordenamos el array en función de las preferencias
					ordenar_lista($alumnos);
					//Asignación de horas
					asignar_horas($alumnos,$bloque);		
					///Mostramos la información para cada alumno
					mostrar_alumnos_entregas($alumnos);
	
				}else{
					echo '<h4><tr>' . get_string('no_hay_alumnos','block_gturnos') . '<br></h4></tr>';
				}
	
			}
	
		}else{
			error('<h2>' . get_string('e_no_bloques','block_gturnos') . '</h2>',url_pagina_ppal($courseid));
		}
	 	echo '<br>';
	 	///Impresión de pie de página moodle
		print_footer($courseid);
	}else{
		redirect(url_pagina_ppal($courseid),'',0);
	}
?>
