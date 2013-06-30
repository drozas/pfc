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
 * Created by drozas on 28-oct-06
 *
 * Muestra una pantalla de confirmación para el cierre de todos los bloques de ese curso.
 */

	require_once("../../config.php");
	require_once("lib.php");

 	/*Recogemos parametros get*/
	$courseid = required_param('course', PARAM_CLEAN);
	$sesskey = required_param('sesskey', PARAM_ALPHANUM);

	//Esta función checkea que este logueado, y que tenga permisos para estar en este curso.
	//Evitamos que un guest acceda a información que no debería si escribe la url.
	require_login($courseid);

	//Además comprobamos que sea profe y que la sesskey sea correcta.
	if (isteacher($courseid) && confirm_sesskey($sesskey))
	{
		///Impresión de cabecera moodle con opción de no guardar en cache
	 	print_header_simple(get_string('heading_confirmar_cerrar','block_gturnos'),'',
							get_string('heading_confirmar_cerrar','block_gturnos'),'','',false);
	 
	  	///Si hay bloques de entrega 
		if(count_records("bloques_entrega", "courseid", $courseid)>0)
		{
	
			$mensaje = "<h3>" .get_string('confirmar_cerrar_bloques','block_gturnos') ."<br>";
			$mensaje .= get_string('explicacion_cierre', 'block_gturnos') . '</h3>';
			$urlyes = $CFG->wwwroot. '/blocks/gturnos/cerrar.php?courseid=' .$courseid .'&sesskey=' . $sesskey;
			notice_yesno($mensaje,$urlyes,url_pagina_ppal($courseid));
			
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
