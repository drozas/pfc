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
 * Created by drozas on 11-oct-06
 *
 * Muestra al profesor los alumnos que hay apuntados actualmente
 */

	require_once("../../config.php");
	require_once("lib.php");
 	/*Recogemos parámetros que vienen por GET*/
	$courseid = required_param('course', PARAM_CLEAN);
	$sesskey = required_param('sesskey', PARAM_ALPHANUM);

	//Esta función checkea que este logueado, y que tenga permisos para estar en este curso.
	//Evitamos que un guest acceda a información que no debería si escribe la url.
	require_login($courseid);

	//Comprobamos que es profesor, y su sesskey
	if (isteacher($courseid) && confirm_sesskey($sesskey))
	{
		///Impresión de cabecera moodle con opción de no guardar en cache
	 	print_header_simple(get_string('heading_ver_alumnos','block_gturnos'),'',
	 						get_string('heading_ver_alumnos','block_gturnos'),'','',false);
		
		///Si hay bloques de entrega
		if(count_records("bloques_entrega", "courseid", $courseid)>0)
		{
			echo '<h2>'. get_string('apuntados_gral','block_gturnos') . ' ' . obtener_nombre_curso($courseid) .'</h2>';
			$bloques = get_records("bloques_entrega","courseid",$courseid, "dia");
			
			///Para cada bloque de este curso
			foreach($bloques as $bloque)
			{
	
				echo '<h3><b>'. get_string('Turno','block_gturnos') . ' : ' . obtener_rango_bloque($bloque->id) . '<br></h3></b>';	
				$clausula = 'courseid = '. $courseid . ' AND ' . 'bloques_entrega_id = ' . $bloque->id; 
				///En la tabla de user_bloque, mostramos todos los alumnos apuntados a ese rango
				if(count_records_select("user_bloque",$clausula)>0)
				{
					$alumnos = get_records_select("user_bloque", $clausula, 'fecha_registro');
					mostrar_alumnos_preferencias($alumnos);
	
				}else{
					echo '<h4>' . get_string('no_hay_alumnos','block_gturnos') . '<br><h4>';
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



</body>
</html>
