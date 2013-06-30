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
 * Contiene todas las cadenas usadas por la aplicaci�n en castellano. Juego de caracteres : ISO-8859-1.
 *
 */
 
 /*****************************************************************************************************/
 /*Cadenas de prop�sito general*/
 /*****************************************************************************************************/
 $string['gturnos'] = 'Gestor de turnos';
 $string['gracias'] = 'Gracias';
 $string['datos_ok'] = 'Los datos se han guardado correctamente.';
 $string['dia_entrega'] = 'D�a de entrega : ';
 $string['h_inicio'] = 'Hora de inicio : ';
 $string['h_fin'] = 'Hora de fin : ';
 $string['duracion'] = 'Duraci�n de cada turno (en minutos) : ';
 $string['n_correctores'] = 'N�mero de correctores : ';
 $string['btn_anadir_bloque'] = 'Agregar nuevo bloque';
 $string['turno'] = 'turno';
 $string['Turno'] = 'Turno';
 $string['bloque'] = 'bloque';
 $string['Bloque'] = 'Bloque';
 $string['preferencia'] = 'preferencia';
 $string['Preferencia'] = 'Preferencia';
 $string['nombre'] = 'nombre';
 $string['Nombre'] = 'Nombre';
 $string['Registrado_desde'] = 'Registrado desde';
 $string['hora'] = 'hora';
 $string['Hora'] = 'Hora';
 $string['e_no_bloques']  ='No hay bloques de entrega configurados para este curso.';
 $string['no_hay_alumnos'] = 'No hay alumnos registrados en este turno';
 $string['pronto'] = 'Lo antes posible';
 $string['tarde'] = 'Lo m�s tarde posible';
 $string['configtitle'] = 'T�tulo del bloque.<br>Ej.: \"Entrega de pr�cticas de junio\"';

 
 /*****************************************************************************************************/
 /*Cadenas para block_gturnos.php*/
 /*****************************************************************************************************/
 /*Mensajes para el alumno*/
 $string['fecha_no_asignada'] = 'Todav�a no tienes fecha asignada.';
 $string['fecha_definitiva'] = 'Esta fecha es definitiva.';
 $string['fecha_no_definitiva'] = 'La lista de entregas no est� cerrada.<br>�Esta fecha todav�a no es definitiva!';
 $string['no_registrado'] = 'Todav�a no te has registrado.';
 /*Opciones del menu profesor/alumno*/
 $string['registrarse'] = 'Registrarse';
 $string['configurar_bloques'] = 'Configurar bloques de entrega';
 $string['ver_alumnos'] = 'Ver alumnos por orden de registro';
 $string['vista_previa'] = 'Vista previa de lista de entrega';
 $string['cerrar_lista'] = 'Cerrar lista de entrega';


 /*****************************************************************************************************/
 /*Cadenas para registro_bloque.php*/
 /*****************************************************************************************************/
 $string['heading_registro_bloque'] = 'Gesti�n de bloques de turnos';
 $string['introduce_datos_bloque'] = 'Introduce los datos del nuevo bloque de turnos : ';
 $string['bloques_configurados'] = 'Bloques configurados actualmente : ';


 /*****************************************************************************************************/
 /*Cadenas para confirmar_guardar_bloque.php*/
 /*****************************************************************************************************/
 $string['heading_confirmar_guardar_bloque'] = 'Confirmar nuevo bloque';
 $string['confirmar_datos_bloque'] = '�Desea agregar el siguiente bloque?';
 /*Mensajes de error*/
 $string['e_horas'] = 'La hora de fin debe ser mayor que la de inicio.';
 $string['e_duracion'] = 'La duraci�n del turno debe ser un n�mero entero mayor que cero.';
 $string['e_n_correctores'] = 'El n�mero de correctores debe ser un n�mero entero mayor que cero.';


 /*****************************************************************************************************/
 /*Cadenas para guardar_bloque.php*/
 /*****************************************************************************************************/
 $string['heading_guardar_bloque'] = 'Guardar nuevo bloque';


 /*****************************************************************************************************/
 /*Cadenas para ver_alumnos.php*/
 /*****************************************************************************************************/
 $string['heading_ver_alumnos'] = 'Ver alumnos registrados y sus preferencias';
 $string['apuntados_gral'] = 'Alumnos apuntados para ';

 /*****************************************************************************************************/
 /*Cadenas para vista_previa.php*/
 /*****************************************************************************************************/
 $string['heading_vista_previa'] = 'Vista previa de asignaci�n de turnos';
 $string['listado_gral'] = 'Lista de turnos para ';
 
 /*****************************************************************************************************/
 /*Cadenas para confirmar_cerrar.php*/
 /*****************************************************************************************************/
 $string['heading_confirmar_cerrar'] = 'Confirmar cierre de lista';
 $string['confirmar_cerrar_bloques'] = '�Desea cerrar la lista de entrega?';
 $string['explicacion_cierre'] = 'De esta forma, impedir� el registro de nuevos alumnos e informar� a los registrados de que la fecha asignada es definitiva.';

 /*****************************************************************************************************/
 /*Cadenas para cerrar.php*/
 /*****************************************************************************************************/
 $string['heading_cerrar'] = 'Cerrar lista de entrega';
 $string['cierre_ok'] = 'cerrado con �xito';

 /*****************************************************************************************************/
 /*Cadenas para registro_alumno.php*/
 /*****************************************************************************************************/
 $string['heading_registro_alumno'] = 'Registro en bloque de turnos';
 $string['turnos_disponibles'] = 'Turnos disponibles en ';
 $string['preferencia_horario'] = 'Preferencia de horario : ';
 $string['no_hay_turnos'] = 'Lo siento, de momento no hay turnos disponibles.';
 $string['btn_registrar'] = 'Registrase';


 /*****************************************************************************************************/
 /*Cadenas para confirmar_guardar_alumno.php*/
 /*****************************************************************************************************/
 $string['heading_confirmar_guardar_alumno'] = 'Confirmar registro en el turno';
 $string['e_preferencia'] = 'Preferencia no v�lida.';
 $string['confirmar_datos_alumno'] = '�Deseas registrarte con estos datos?';
 

 /*****************************************************************************************************/
 /*Cadenas para guardar_alumno.php*/
 /*****************************************************************************************************/
 $string['heading_guardar_alumno'] = 'Guardar elecci�n y preferencias de turno';
 
 /*****************************************************************************************************/
 /*Cadenas lib.php*/
 /*****************************************************************************************************/
 /*Funci�n mostrar_bloques*/
 $string['plazas_total'] = 'N� total de plazas : ';
 $string['plazas_ocupadas'] = 'N� de plazas ocupadas : ';
 $string['estado'] = 'Estado : ';
 $string['estado_cerrado'] = 'Cerrado. No se admiten nuevos registros, y la lista es definitiva.';
 $string['estado_completo'] = 'Completo. No se admiten nuevos registros, pero la lista no se marcado todav�a como definitiva.';
 $string['estado_abierto'] = 'Abierto.';
 $string['plazas_libres'] = ' plazas libres';
 /*Funci�n tiene_fecha_asignada*/
 $string['entrega_es'] = 'La entrega es el ';
 $string['a_las'] = ' a las ';
 $string['todavia_no_fecha'] = 'Todav�a no te han asignado fecha';
 /*Funci�n obtener_rango_bloque*/
 $string['de'] = ', de ';
 $string['a'] = ' a ';
?>
