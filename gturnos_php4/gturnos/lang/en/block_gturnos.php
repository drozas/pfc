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
 * Created on 31-oct-06 by drozas
 *
 * It contains all the strings used by the application in English. Charset ISO-8559-1
 *
 */
 
 /*****************************************************************************************************/
 /*	Strings of general intention*/
 /*****************************************************************************************************/
 $string['gturnos'] = 'Turns Manager';
 $string['gracias'] = 'Thanks';
 $string['datos_ok'] = 'Data is correctly saved';
 $string['dia_entrega'] = 'Delivery Day : ';
 $string['h_inicio'] = 'Beginning Time : ';
 $string['h_fin'] = 'Ending Time : ';
 $string['duracion'] = 'Duration of each turn (in minutes) : ';
 $string['n_correctores'] = 'Number of correctors : ';
 $string['btn_anadir_bloque'] = 'Add a new block';
 $string['turno'] = 'turn';
 $string['Turno'] = 'Turn';
 $string['bloque'] = 'block';
 $string['Bloque'] = 'Block';
 $string['preferencia'] = 'preference';
 $string['Preferencia'] = 'Preference';
 $string['nombre'] = 'name';
 $string['Nombre'] = 'Name';
 $string['Registrado_desde'] = 'Registered since';
 $string['hora'] = 'time';
 $string['Hora'] = 'Time';
 $string['e_no_bloques']  ='There are no configured delivery blocks for this course.';
 $string['no_hay_alumnos'] = 'There are no students registered in this turn';
 $string['pronto'] = 'As soon as possible';
 $string['tarde'] = 'As late as possible';
 $string['configtitle'] = 'Title of the block.<br>i.ex. : \"Delivery of June practices\"';

 
 /*****************************************************************************************************/
 /*Strings for block_gturnos.php*/
 /*****************************************************************************************************/
 /*Messages for the student*/
 $string['fecha_no_asignada'] = 'You have no assigned date yet.';
 $string['fecha_definitiva'] = 'This date is definitive.';
 $string['fecha_no_definitiva'] = 'The list of deliveries is not closed.<br>This date is not definitive yet!';
 $string['no_registrado'] = 'You are not registered yet.';
 /*Options of the menu professor/student*/
 $string['registrarse'] = 'Register';
 $string['configurar_bloques'] = 'Configure delivery blocks';
 $string['ver_alumnos'] = 'See students by registry order';
 $string['vista_previa'] = 'Delivery list preview';
 $string['cerrar_lista'] = 'Close delivery list';


 /*****************************************************************************************************/
 /*Strings for registro_bloque.php*/
 /*****************************************************************************************************/
 $string['heading_registro_bloque'] = 'Management of blocks of turns';
 $string['introduce_datos_bloque'] = 'Enter the data for a new block of turns : ';
 $string['bloques_configurados'] = 'Currently configured blocks : ';


 /*****************************************************************************************************/
 /*Strings for confirmar_guardar_bloque.php*/
 /*****************************************************************************************************/
 $string['heading_confirmar_guardar_bloque'] = 'Confirm new block';
 $string['confirmar_datos_bloque'] = 'Do you like to add the next block?';
 /*Messages of error*/
 $string['e_horas'] = 'The ending time must be greater than the beginning one';
 $string['e_duracion'] = 'The duration of the turn must be an integer greater than zero.';
 $string['e_n_correctores'] = 'The number of correctors must be an integer greater than zero';


 /*****************************************************************************************************/
 /*Strings for guardar_bloque.php*/
 /*****************************************************************************************************/
 $string['heading_guardar_bloque'] = 'Save a new block';
 

 /*****************************************************************************************************/
 /*Strings for ver_alumnos.php*/
 /*****************************************************************************************************/
 $string['heading_ver_alumnos'] = 'See registered students and their preferences';
 $string['apuntados_gral'] = 'Registered students in ';

 /*****************************************************************************************************/
 /*Strings for vista_previa.php*/
 /*****************************************************************************************************/
 $string['heading_vista_previa'] = 'Turns assignation preview';
 $string['listado_gral'] = 'Turns list for ';
 
 /*****************************************************************************************************/
 /*Strings for confirmar_cerrar.php*/
 /*****************************************************************************************************/
 $string['heading_confirmar_cerrar'] = 'Confirm list closing';
 $string['confirmar_cerrar_bloques'] = 'Do you like to close the delivery list?';
 $string['explicacion_cierre'] = 'Doing this, the registry of new students will not be allowed ' .
 		'						and the registered ones will be informed tha the date is definitive.';
 /*****************************************************************************************************/
 /*Strings for cerrar.php*/
 /*****************************************************************************************************/
 $string['heading_cerrar'] = 'Close delivery list';
 $string['cierre_ok'] = 'closed successfully';

 /*****************************************************************************************************/
 /*Strings for registro_alumno.php*/
 /*****************************************************************************************************/
 $string['heading_registro_alumno'] = 'Turns block registry';
 $string['turnos_disponibles'] = 'Available turns in ';
 $string['preferencia_horario'] = 'Desired time : '; /*o preferred schedule?*/
 $string['no_hay_turnos'] = 'Sorry, there are no available turns at this moment.';
 $string['btn_registrar'] = 'Register';


 /*****************************************************************************************************/
 /*Strings for confirmar_guardar_alumno.php*/
 /*****************************************************************************************************/
 $string['heading_confirmar_guardar_alumno'] = 'Confirm the registration on the turn';
 $string['e_preferencia'] = 'Invalid preference.';
 $string['confirmar_datos_alumno'] = 'Do you like to register with this data?';
 

 /*****************************************************************************************************/
 /*Strings for guardar_alumno.php*/
 /*****************************************************************************************************/
 $string['heading_guardar_alumno'] = 'Save preferences'; /*Está traducida muy libremente*/

 /*****************************************************************************************************/
 /*Strings for lib.php*/
 /*****************************************************************************************************/
 /*Function mostrar_bloques*/
 $string['plazas_total'] = 'Total number of seats :'; /*plaza=seat=asiento?*/
 $string['plazas_ocupadas'] = 'Occupied number of seats : ';
 $string['estado'] = 'State : ';
 $string['estado_cerrado'] = 'Closed. No new registries are allowed and the list is definitive.';
 $string['estado_completo'] = 'Complete. No new registries are allowed, but the list is not definitive yet.';
 $string['estado_abierto'] = 'Open.';
 $string['plazas_libres'] = ' free seats';
 /*Function tiene_fecha_asignada*/
 $string['entrega_es'] = 'The delivery date is ';
 $string['a_las'] = ' at ';
 $string['todavia_no_fecha'] = 'You do not have a delivery date yet.';
 /*Function obtener_rango_bloque*/
 $string['de'] = ', from ';
 $string['a'] = ' to ';
?>
