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
 * Created by drozas on 25-oct-06
 *
 * Guarda los datos del nuevo bloque en la base de datos
 */


	require_once("../../config.php");
	require_once("lib.php");
	require_once("bloque_entrega.php");
	global $USER;

	///Recogemos los datos del formulario provenientes de GET 
	$courseid = required_param('courseid');
	$sesskey = required_param('sesskey', PARAM_ALPHANUM);

	//Esta función checkea que este logueado, y que tenga permisos para estar en este curso.
	//Evitamos que un guest acceda a información que no debería si escribe la url.
	require_login($courseid);

	//Comprobamos que sea profesor, y su sesskey
	if (isteacher($courseid) && confirm_sesskey($sesskey))
	{
		///Recogemos resto de parámetros GET
		$dia = required_param('dia', PARAM_INT);
		$mes = required_param('mes', PARAM_INT);
		$anyo = required_param('anyo', PARAM_INT);
		$h_inicio = required_param('h_inicio', PARAM_CLEAN);
		$h_fin = required_param('h_fin', PARAM_CLEAN);
		$duracion_turno = required_param('duracion_turno', PARAM_INT);
		$n_correctores = required_param('n_correctores', PARAM_INT);
		
	 	print_header_simple(get_string('heading_guardar_bloque','block_gturnos'),''
	 						,get_string('heading_guardar_bloque','block_gturnos'),'','',false);
		
	 	/*Inserción del bloque en la base de datos*/
	 	$bloque = new bloque_entrega();
		$bloque->courseid = $courseid;
		$bloque->dia = $anyo . '-' . $mes . '-' . $dia;
		$bloque->h_inicio = $h_inicio;
		$bloque->h_fin = $h_fin;
		$bloque->n_correctores = $n_correctores;
		$bloque->duracion_turno = $duracion_turno;
		$bloque->lleno = false;
		$bloque->definitiva = false;
		insert_record("bloques_entrega",$bloque) or die(mysql_error());
	 	
	 	
	 	///Si todo fue correcto, mostramos mensaje de todo_ok
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
