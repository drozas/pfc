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
 * Created by drozas on 13-oct-06
 *
 * Página que presenta al alumno las opciones para registrarse en un turno
 */
	///Cargamos nuestra librería y las de moodle
	require_once("../../config.php");
	require_once("lib.php");
	global $USER;

	///Recogemos parámetros provenientes de GET. Es mejor pasar course como PARAM_CLEAN, ya que si lo pasamos 
	///como PARAM_INT e insertamos por ejemplo una letra, lo deja vacío y toma 0 en lugar de dar un error.
	$courseid = required_param('course', PARAM_CLEAN);
	$sesskey = required_param('sesskey', PARAM_ALPHANUM);

	//Esta función checkea que este logueado, y que tenga permisos para estar en este curso.
	//Evitamos que un guest acceda a información que no debería si escribe la url.
	require_login($courseid);

	//Comprobamos que es profesor, y su sesskey
	if (isteacher($courseid) && confirm_sesskey($sesskey))
	{
		///Impresión de cabecera moodle con opción de no guardar en cache
	 	print_header_simple(get_string('heading_registro_bloque','block_gturnos')
	 						,'',get_string('heading_registro_bloque','block_gturnos'),'','',false);
	
	
		/// Formulario de añadir un nuevo bloque
		///////////////////////////////////////////////////////////////////////	
		echo '<form action = "../gturnos/confirmar_guardar_bloque.php" method = "POST">';
		echo '<h2>' . get_string('introduce_datos_bloque', 'block_gturnos') . '</h2>';
		///Item de fecha de moodle, para el día de entrega
		echo '<h3>' . get_string('dia_entrega', 'block_gturnos');
		print_date_selector("dia","mes","anyo");
		echo '<br><br>';
	
		///Item de horas de moodle, para hora de inicio
		echo get_string('h_inicio', 'block_gturnos');
		print_time_selector("h_inicio","min_inicio",0,5);
		echo '<br><br>';
		
		///Item de horas de moodle, para hora de fin
		echo get_string('h_fin', 'block_gturnos');
		print_time_selector("h_fin","min_fin",0,5);
		echo '<br><br>';
	
		///Campo de texto para la duración de cada turno
		 echo get_string('duracion', 'block_gturnos');
		 echo '<input type ="text" name ="duracion_turno" value = 15>';
		 echo ' <br><br>';
		 
		///Campo de texto para el nº de correctores
		echo get_string('n_correctores', 'block_gturnos');
		echo '<input type ="text" name ="n_correctores" value = 1>';
		echo '<br><br>';
	
		///Campo oculto de courseid
		echo '<input type = "hidden" name = "courseid" value = '. $courseid .'>';
		
		///Campo oculto con sesskey
		echo '<input type = "hidden" name = "sesskey" value = '. $sesskey .'>';
		
		//Botón de envio
		echo '<input type = "submit" value="'.get_string('btn_anadir_bloque','block_gturnos').'">';
		echo '<br><br>';
	
		echo '</h3></form>';
	
	
		/// Mostrar bloques ya configurados
		///////////////////////////////////////////////////////////////////////
		if(count_records("bloques_entrega", "courseid", $courseid)>0)
		{
			
			echo '<br><br><h2>' . get_string('bloques_configurados','block_gturnos') . '</h2><br>';
			$bloques = get_records("bloques_entrega", "courseid", $courseid, "dia");
			mostrar_bloques($bloques);
	
		}	
		 echo '<br>';
	 	///Impresión de pie de página moodle
		print_footer($courseid);
	}else{
		redirect(url_pagina_ppal($courseid),'',0);
	}
?>
