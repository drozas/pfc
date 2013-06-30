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
 * Hace definitiva la lista de entrega. Impide el registro de nuevos usuarios y marca como definitivos
 * todos los bloques de turnos de ese curso.
 */

	require_once("../../config.php");
	require_once("lib.php");

 	/*Recogemos valores provenientes de GET*/
	$courseid = required_param('courseid', PARAM_CLEAN);
	$sesskey = required_param('sesskey', PARAM_ALPHANUM);
	
	//Esta función checkea que este logueado, y que tenga permisos para estar en este curso.
	//Evitamos que un guest acceda a información que no debería si escribe la url.
	require_login($courseid);

	//Comprobamos que sea profe, y su sesskey
	if (isteacher($courseid) && confirm_sesskey($sesskey))
	{
		///Impresión de cabecera moodle con opción de no guardar en cache
	 	print_header_simple(get_string('heading_cerrar','block_gturnos'),'',
							get_string('heading_cerrar','block_gturnos'),'','',false);
	
	 	///Si hay bloques de entrega 
		if(count_records("bloques_entrega", "courseid", $courseid)>0)
		{
			$bloques = get_records("bloques_entrega","courseid",$courseid) or die(mysql_error());
			///Para cada bloque de este curso
			foreach($bloques as $bloque)
			{
				///Hacemos un último cálculo de horarios.
				$clausula = 'courseid = '. $courseid . ' AND ' . 'bloques_entrega_id = ' . $bloque->id; 
				if(count_records_select("user_bloque",$clausula)>0)
				{
					$alumnos = get_records_select("user_bloque", $clausula, 'dia_entrega') or die(mysql_error());	
					//Ordenamos el array en función de las preferencias
					ordenar_lista($alumnos);
					//Asignación de horas
					asignar_horas($alumnos,$bloque);
				}
	
				$mensaje .= '<h3>' . get_string('Bloque','block_gturnos') . ' ';
				$mensaje .= obtener_rango_bloque($bloque->id);
				//Bloqueamos nuevos registros, cambiando el campo 'llena'
				set_field('bloques_entrega','lleno',true,'id',$bloque->id,'courseid',$bloque->courseid) or die(mysql_error());
				//Y la hacemos definitiva, cambiando el campo 'definitiva'
				set_field('bloques_entrega','definitiva',true,'id',$bloque->id,'courseid',$bloque->courseid) or die(mysql_error());
				$mensaje .= ' ' . get_string('cierre_ok','block_gturnos') . '<br></h3>';
			}
			
			notice($mensaje,url_pagina_ppal($courseid));
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