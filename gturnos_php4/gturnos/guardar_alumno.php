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
 * Guarda los datos del alumno en la base de datos y aplica el algoritmo de reparto de turnos para
 * el bloque escogido.
 */


	require_once("../../config.php");
	require_once("lib.php");
	require_once("user_bloque.php");
	global $USER;

	///Recogemos valores provenientes de GET
	$courseid = required_param('courseid', PARAM_CLEAN);
	$sesskey = required_param('sesskey', PARAM_ALPHANUM);
	
	//Esta función checkea que este logueado, y que tenga permisos para estar en este curso.
	//Evitamos que un guest acceda a información que no debería si escribe la url.
	require_login($courseid);

	///Comprobamos que sea alumno, y su sesskey	
	if(isstudent($courseid) && confirm_sesskey($sesskey))
	{
		///Recogemos el resto de parámetros
		$bloques_entrega_id = required_param('bloques_entrega_id', PARAM_INT);	 
		$preferencia = required_param('preferencia', PARAM_ALPHA);
	
		///Impresión de cabecera moodle con opción de no guardar en cache
	 	print_header_simple(get_string('heading_guardar_alumno','block_gturnos'),''
	 						,get_string('heading_guardar_alumno','block_gturnos'),'','',false);
		

		$query = "INSERT INTO mdl_user_bloque (userid, courseid, bloques_entrega_id, preferencia, dia_entrega, h_entrega, fecha_registro) " .
				"VALUES ('$USER->id', '$courseid' , '$bloques_entrega_id', '$preferencia', NULL, NULL, NOW())";	
		
		execute_sql($query,false) or die(mysql_error());
	 		 	
	  	///Calculamos el algoritmo de turnos cada vez que se registre un alumno para ese bloque.
	 	
		///Cogemos el registro completo de este bloque 
		$clausula = "courseid = " . $courseid . " AND id = ". $bloques_entrega_id;
		$bloque = get_record_select("bloques_entrega",$clausula) or die(mysql_error());
		
		///Calculamos las horas para todos los alumnos de ese bloque
		$clausula = 'courseid = '. $courseid . ' AND ' . 'bloques_entrega_id = ' . $bloque->id; 
		///Esta condición ya no haría falta (al menos hay este, pero nunca esta de más comprobar)
		if(count_records_select("user_bloque",$clausula)>0)
		{
			$alumnos = get_records_select("user_bloque", $clausula, 'fecha_registro') or die(mysql_error());
			//Ordenamos el array en función de las preferencias
			ordenar_lista($alumnos);
			//Asignación de horas
			asignar_horas($alumnos,$bloque);
		}
	
	 	///Si todo fue correcto, mostramos mensaje 
	 	$mensaje = '<h3>' . get_string('gracias','block_gturnos') .', '. fullname($USER);
	 	$mensaje .='<br>' . get_string ('datos_ok','block_gturnos') .'</h3><br>';
	 	notice($mensaje,url_pagina_ppal($courseid));
	 	
	  	echo '<br>';
	 	///Impresión de pie de página moodle
		print_footer($courseid);
	}else{
		redirect(url_pagina_ppal($courseid),'',0);
	}
 ?>