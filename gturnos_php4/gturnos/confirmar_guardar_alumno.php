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
 * Pide confirmación y valida los datos del registro del alumno
 */


	require_once("../../config.php");
	require_once("lib.php");
	global $USER;

	///Recogemos los datos del formulario provenientes del POST	 
	$courseid = required_param('courseid', PARAM_CLEAN);
	$sesskey = required_param('sesskey', PARAM_ALPHANUM);

	//Esta función checkea que este logueado, y que tenga permisos para estar en este curso.
	//Evitamos que un guest acceda a información que no debería si escribe la url.
	require_login($courseid);

	///Comprobamos que sea alumno, y su sesskey	
	if (isstudent($courseid) && confirm_sesskey($sesskey))
	{

		///Recogemos el resto de parámetros
		$bloques_entrega_id = required_param('bloques_entrega_id', PARAM_INT);	 
		$preferencia = required_param('preferencia', PARAM_ALPHA);

		///Impresión de cabecera moodle con opción de no guardar en cache
	 	print_header_simple(get_string('heading_confirmar_guardar_alumno','block_gturnos'),''
	 						,get_string('heading_confirmar_guardar_alumno','block_gturnos'),'','',false);
	 
	 	///Validamos los datos que pueden presentar problemas
	 	if(($preferencia=='T')||($preferencia=='P') )
	 	{
				
	 			///Si todo está ok, mostramos pantalla de confirmación.
	 			$mensaje = '<h3>' . get_string('confirmar_datos_alumno','block_gturnos') . '<br>';
				$mensaje .= get_string('Turno','block_gturnos') . ' : ' . obtener_rango_bloque($bloques_entrega_id) . '<br>';
				$mensaje .= get_string('Preferencia','block_gturnos') . ' : ' . obtener_descripcion_preferencia($preferencia) . '<br>';
						
				///Preparamos las url con los datos.
				$urlyes = $CFG->wwwroot. '/blocks/gturnos/guardar_alumno.php?courseid=' .$courseid .'&sesskey=' .$sesskey;
				$urlyes .= '&bloques_entrega_id=' . $bloques_entrega_id . '&preferencia=' . $preferencia; 	
				notice_yesno($mensaje,$urlyes,url_pagina_ppal($courseid));

	 	}else{
	 		error(get_string('e_preferencia','block_gturnos'),url_pagina_ppal($courseid));
	 	}
	 
	
	 	echo '<br>';
	 	///Impresión de pie de página moodle
		print_footer($courseid);
	}else{
		redirect(url_pagina_ppal($courseid),'',0);
	}
 ?>
