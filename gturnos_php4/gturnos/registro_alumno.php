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
 
	///Cargamos fichero de configuración para acceder a las variables globales.
	require_once("../../config.php");
	require_once("lib.php");
	global $USER;

	///Recogemos los parámetros provenientes de get
	$courseid = required_param('course', PARAM_CLEAN);
	$sesskey = required_param('sesskey', PARAM_ALPHANUM);

	//Esta función checkea que este logueado, y que tenga permisos para estar en este curso.
	//Evitamos que un guest acceda a información que no debería si escribe la url.
	require_login($courseid);

	///Comprobamos que sea alumno, y su sesskey	
	if(isstudent($courseid) && confirm_sesskey($sesskey))
	{
		///Impresión de cabecera moodle con opción de no guardar en cache
	 	print_header_simple(get_string('heading_registro_alumno','block_gturnos')
	 						,'',get_string('heading_registro_alumno','block_gturnos'),'','',false);
	 
		///Para cada bloque de ese curso sin el plazo cerrado
		$clausula = "courseid = ". $courseid . " AND lleno = false";
		
		if(count_records_select("bloques_entrega", $clausula)>0)
		{
			
			echo '<h3>'. get_string('turnos_disponibles','block_gturnos') . obtener_nombre_curso($courseid) . '</h3>';
			echo '<h4>';
			
			$bloques = get_records_select("bloques_entrega", $clausula, "dia") or die(mysql_error());
			
			echo '<form action = "../gturnos/confirmar_guardar_alumno.php" method = "POST">';
			
			$primera_vez = true;
			$i=1;
			foreach($bloques as $bloque)
			{
	
				if($primera_vez == true)
				{
					echo '<input type="radio" name="bloques_entrega_id" value= "' .$bloque->id .'" checked>';
					$primera_vez = false;
				}else{
					echo '<input type="radio" name= "bloques_entrega_id" value= "'.  $bloque->id .'">';
				}
				echo ' ' . $i . '# ';
				echo obtener_rango_bloque($bloque->id) . '<br><br>';
				$i++;
			}

			echo '<br>';
			echo get_string('preferencia_horario','block_gturnos');
		
			echo '<select size="1" name="preferencia">
					<option selected value="P">' . get_string('pronto','block_gturnos') . '</option>
					<option value="T">' . get_string('tarde','block_gturnos') . '</option>
				</select><br><br>';
		
			echo '<input type = "hidden" name ="courseid" value = "' . $courseid . '">';
			echo '<input type = "hidden" name ="sesskey" value = "' . $sesskey . '">';
			echo '<input type = "submit" value="'. get_string('btn_registrar','block_gturnos') .'">
		
			</form>
			</b></i>';
			echo '</h4><br>';
		}else{
			error('<h2>' . get_string('no_hay_turnos','block_gturnos') . '</h2>',url_pagina_ppal($courseid));
		}
		
		///Impresión de pie de página moodle
		print_footer($courseid);
	}else{
		redirect(url_pagina_ppal($courseid),'',0);	
	}

?>



</body>
</html>