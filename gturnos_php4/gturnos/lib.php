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
 * Created by drozas on 20-oct-06
 *
 * Librería con funciones generales de gTurnos
 */
 
 /**
 * Modifica la lista de alumnos recibida, reordenándola por preferencias
 *
 * @param array &$lista_original Lista de alumnos original, pasa por referencia.
 *
 */
 function ordenar_lista(&$lista_original)
 {
 	///Nuevo algoritmo : 
 	/// El algoritmo anterior da "más preferencia" a los últimos en apuntarse.
 	/// Ej.: P01-T02-T03-P04-T05-P06
 	/// Resultado será : P06-P04-P01-T02-T03-T05
 	/// Con el nuevo algoritmo : 
 	/// Ej.: P01-T02-T03-P04-T05-P06
 	///		-$alumnos_pronto (insertamos por el final (push))= P01-P04-P06
 	///		-$alumnos_tarde (insertamos por el ppo (unshift))= T05-T03-T02
 	///		-$array_resultado (insertamos por el final, primero $alumnos_pronto y después $alumnos_tarde):
 	///			->P01-P04-P06-T05-T03-T02
 	/// Lo cuál "da preferencia" a los primeros en apuntarse.
 	
 	
	///Separamos en dos arrays a los que escogieron pronto o tarde
	$alumnos_pronto = array();
	$alumnos_tarde = array();
	foreach($lista_original as $elemento) 	
	{
		if ($elemento->preferencia=="T")
		{
			//Si escogió tarde, agregamos por el principio en array de tarde.
			array_unshift($alumnos_tarde,$elemento);
		}else{
			//Si escogió pronto, agregamos por el final en array pronto
			array_push($alumnos_pronto,$elemento);
		}
	
	}

	///Fusionamos ambos arrays, insertando por el final, primero todos los 
	///ya ordenados que escogieron pronto y después todos los ya ordenados que escogieron tarde
	$array_resultado = array();

	///Alumnos que escogieron pronto
	foreach($alumnos_pronto as $elemento)
	{
		array_push($array_resultado,$elemento);
	}
	///Alumnos que escogieron tarde
	foreach($alumnos_tarde as $elemento)
	{
		array_push($array_resultado,$elemento);
	}	


	///Asignamos el resultado del proceso a la lista que nos pasaron originalmente	
	$lista_original = $array_resultado;
		
 }

 /**
 * Calcula el número total de plazas de ese bloque
 *
 * @param array $bloque Bloque de turnos completo
 *
 * @return int Número total de plazas
 */
 function calcular_plazas($bloque)
 {
	///Algoritmo : 
	/// nº de plazas de un bloque es igual a
	/// ((h_fin-h_inicio)*nº_correctores)/duracion_turno
 	
	///Calculamos el nº total de segundos disponibles
	$h_inicio = strtotime($bloque->h_inicio);
	$h_fin = strtotime($bloque->h_fin);
	
	///Guardamos la diferencia, y la pasamos a minutos
	$total = ($h_fin-$h_inicio)/60;
	
	///Multiplicamos por el nº de correctores, y dividimos por lo que dura cada turno
	$total = $total * $bloque->n_correctores;
	$total = $total / $bloque->duracion_turno;
	
	return (int)$total;	
 }


 /**
 * Calcula las horas para cada grupo de alumnos que eligieron cierto bloque.
 * Se guardan dichos valores en la bbdd.
 *
 * @param array $alumnos Array de alumnos ordenado por preferencias.
 * @param array $bloque Bloque con el que estamos calculando los rangos.
 *
 */
 function asignar_horas($alumnos, $bloque)
 {
	///ALGORITMO : 	-Tenemos el grupo de alumnos que pertenecen a ese bloque y su bloque
	///				-Calculamos el nº de plazas de ese bloque
	///				-Partimos de la h_inicio base. 
	///				-Para cada alumno : 
	///					-Asignar dia
	///					-Asignar hora
	///					-Aumentar n_correctores_aux.
	///					-Si n_correctores_aux==n_correctores->aumentar hora
	///					-Decrementar n_plazas
	///				Mientras(haya_alumnos y plazas)
	///				Si después de aplicar el algoritmo, el nº de plazas es 0 o menor que 0 (nos excedimos del rango)
	///					Bloqueamos dicho bloque
	///
	/// Se ejecuta :  - Para todo bloque y para todo alumno de ese bloque, al ejecutar el profesor vista_previa.php
	///				  - Para un bloque (y para todo alumno de ese bloque), cada vez que se registra un alumno.
	//					De esta forma evitamos que "se cuelen" alumnos, si el bloque ya está lleno.
	
	//Preparamos los valores de cálculo en formato timestamp de UNIX
	$h_inicio = strtotime($bloque->h_inicio);
	$h_fin = strtotime($bloque->h_fin);
	$h_actual = $h_inicio;
	$n_correctores = $bloque->n_correctores;
	$duracion_turno_sg = $bloque->duracion_turno * 60;
	$n_plazas = calcular_plazas($bloque);
	$n_correctores_aux = 1;

	foreach($alumnos as $alumno)
	{
		//Guardamos día y hora en la db
		set_field('user_bloque','dia_entrega',$bloque->dia,'userid',$alumno->userid,'courseid',$bloque->courseid,bloques_entrega_id,$bloque->id) or die;
		set_field('user_bloque','h_entrega',strftime('%H:%M',$h_actual),'userid',$alumno->userid,'courseid',$bloque->courseid,bloques_entrega_id,$bloque->id) or die;

		///Si ya no hay más correctores para ese turno, desplazamos la hora actual e inicializamos 
		///el nº de correctores auxiliar
		if($n_correctores_aux==$n_correctores)
		{
			$h_actual+=$duracion_turno_sg;
			$n_correctores_aux = 1;
			
		}else{
			$n_correctores_aux++;	
		}
		
		$n_plazas--;
	}

	///Si ya se han cubierto todas las plazas cerramos el bloque
	if ($n_plazas<=0)
	{
		set_field('bloques_entrega','lleno',true,'id',$bloque->id,'courseid',$bloque->courseid);
	}
 }


 /**
 * Devuelve el nombre completo del curso, a partir de su identificador
 *
 * @param int $courseid Identificador de curso
 * 
 * @return string Nombre completo del curso
 *
 */
 function obtener_nombre_curso($courseid)
 {
	$curso = get_record("course", "id", $courseid);
	return $curso->fullname;	
 } 
 
 /**
 * Devuelve el día y rango de horas de un bloque de turnos, a partir de su identificador
 *
 * @param int $bloque_curso_id Identificador de bloque de entrega
 *
 * @return string Día y hora en formato DD/MM/YY + HH:MM
 *
 */
 function obtener_rango_bloque($bloque_curso_id)
 {
	$bloque = get_record("bloques_entrega", "id", $bloque_curso_id);
	$rango = date('d/m/y',strtotime($bloque->dia)) . get_string('de','block_gturnos');
	$rango .= date('H:i',strtotime($bloque->h_inicio)) . get_string('a', 'block_gturnos');
	$rango .= date('H:i',strtotime($bloque->h_fin));
	
	return $rango;
 } 
 
 
 /**
 * Devuelve el nombre completo de usuario, a partir del identificador
 *
 * @param int $userid
 * 
 * @return string Nombre completo del usuario.
 *
 */
 function obtener_nombre_user($userid)
 {
	$user = get_record("user", "id", $userid);
	return $user->firstname .' ' . $user->lastname;
 } 
 
 
 /**
 * Muestra por pantalla la información de preferencia de los alumnos en una tabla
 *
 * @param array $alumnos Array de alumnos
 *
 */
 function mostrar_alumnos_preferencias($alumnos)
 {
 	echo '<table  border="2" bgcolor = "#AAAAAA" width="40%" cellspacing ="1" cellpadin="2">';
 	echo '<tr><th>' . get_string('Nombre','block_gturnos');
 	echo '<th>' . get_string('Preferencia', 'block_gturnos');
 	echo '<th>' . get_string('Registrado_desde','block_gturnos') . '</tr>';
	foreach ($alumnos as $alumno)
	{
		///Cambiamos los colores a pares e impares
		if($i%2==0)
		{
			$bgcolor = 	"#eeeee";
		}else{
			$bgcolor = "#e0e0e0";
		}
		$i++;

		echo '<tr bgcolor = "'. $bgcolor .'"><font size = "2">';
		echo '<th>'. obtener_nombre_user($alumno->userid);
		echo '<th>'. $alumno->preferencia;
		echo '<th>'. date('d/m/y , H:i',strtotime($alumno->fecha_registro));
		echo '</tr></font>';
	}
	echo '</table> <br><br>';
 } 
 
 /**
 * Muestra la información de entrega de los alumnos en una tabla.
 *
 * @param array $alumnos Array de alumnos
 *
 */
 function mostrar_alumnos_entregas($alumnos)
 {
 	echo '<table  border="2" bgcolor = "#AAAAAA" width="40%" cellspacing ="1" cellpadin="2">';
 	echo '<tr><th>' . get_string('Hora','block_gturnos');
	echo '<th>'. get_string('Nombre','block_gturnos') . '</tr>';
	
	foreach ($alumnos as $alumno)
	{
		///Cambiamos los colores a pares e impares
		if($i%2==0)
		{
			$bgcolor = 	"#eeeee";
		}else{
			$bgcolor = "#e0e0e0";
		}
		$i++;

		///Una columna de horas, y otra con los nombres
		echo '<tr bgcolor = "'. $bgcolor .'"><font size = "2">';
		echo '<th>'. strftime('%H:%M',strtotime($alumno->h_entrega));
		echo '<th>'. obtener_nombre_user($alumno->userid);
		echo '</tr></font>';
	}
	echo '</table> <br><br>';
 } 
 
 /**
 * Muestra la información de los bloques de turnos en una tabla.
 *
 * @param array $bloques Array de bloques
 *
 */
 function mostrar_bloques($bloques)
 {

	echo '<table  border="2" bgcolor = "#AAAAAA" cellspacing ="1" cellpadin="2">';
	foreach($bloques as $bloque)
	{
		///Cambiamos los colores a pares e impares
		if($i%2==0)
		{
			$bgcolor = 	"#eeeee";
		}else{
			$bgcolor = "#e0e0e0";
		}
		$i++;
			
		echo 
			'<tr>' .
				'<td bgcolor = "'. $bgcolor .'">' .
							'<font size = "2">';
			
			echo '<b>'. get_string('dia_entrega','block_gturnos').'</b> ' . obtener_rango_bloque($bloque->id) . '<br>';
			echo '<b>'. get_string('duracion','block_gturnos').'</b> ' .  $bloque->duracion_turno . '<br>';
			echo '<b>'. get_string('n_correctores','block_gturnos').'</b> ' . $bloque->n_correctores . '<br>';
			echo '<b>'. get_string('plazas_total','block_gturnos').'</b> ' . calcular_plazas($bloque) . '<br>';
			echo '<b>'. get_string('plazas_ocupadas','block_gturnos').' </b> ' . plazas_ocupadas($bloque->courseid,$bloque->id) . '<br>';
			echo '<b>'. get_string('estado','block_gturnos').'</b> ';
	
			if (es_definitivo($bloque->courseid,$bloque->id))
			{
				echo get_string('estado_cerrado','block_gturnos').'<br>';
			
			}else{
			
				if (esta_lleno($bloque->courseid,$bloque->id))
				{
					echo get_string('estado_completo','block_gturnos').'<br>';
			
				}else{
			
					$plazas_libres = (int)calcular_plazas($bloque)-(int)plazas_ocupadas($bloque->courseid,$bloque->id);
					echo  get_string('estado_abierto','block_gturnos');
					echo '(' . $plazas_libres . get_string('plazas_libres','block_gturnos') . ')<br>';
				}
			}
				
			echo '</tr>';	
	
	}
	echo '</table>';
 } 
 
 /**
 * Comprueba si un alumno tiene fecha asignada.
 * Si es así, devuelve un booleano a true, y guarda la fecha en la variable $fecha
 * Si no, no guarda nada; y devuelve false
 *
 * @param int $courseid
 * @param int $userid
 * @param string &$fecha
 *
 * @return boolean Indica si tiene o no fecha asignada. Además se guarda la fecha al pasarla por referencia.
 *
 */
 function tiene_fecha_asignada($courseid,$userid,&$fecha)
 {
	if(record_exists('user_bloque','courseid',$courseid,'userid',$userid))
	{
		$clausula = 'courseid = '. $courseid . ' AND ' . 'userid = ' . $userid; 
		$info_alumno = get_record_select('user_bloque',$clausula);
		if($info_alumno->dia_entrega!='' and $info_alumno->h_entrega !='')
		{
			$rango = date('d/m/y',strtotime($bloque->dia)) .', de ';
			$rango .= date('H:i',strtotime($bloque->h_inicio)) . ' a ';
			$fecha = get_string('entrega_es','block_gturnos');
			$fecha .= date('d/m/y',strtotime($info_alumno->dia_entrega));
			$fecha .= get_string('a_las','block_gturnos');
			$fecha .= date('H:i',strtotime($info_alumno->h_entrega));

		}else{
			$fecha = get_string('todavia_no_fecha','block_gturnos');
		}
		return true;
	}else{
		return false;
	}
 }
 
 
 /**
 * Calcula el nº de plazas ocupadas de un bloque
 *
 * @param int $courseid Identificador de curso
 * @param int $bloques_entrega_id Identificador de bloque
 *
 * @return int Nº de alumnos apuntados a ese bloque
 *
 */
 function plazas_ocupadas($courseid,$bloques_entrega_id)
 {

	$clausula = 'courseid = '. $courseid . ' AND ' . 'bloques_entrega_id = ' . $bloques_entrega_id; 
	return count_records_select("user_bloque",$clausula);
 } 
 
 
 /**
 * Devuelve un link a la página principal
 *
 * @param int $courseid
 *
 * @return string Enlace html a la página principal del curso
 * 
 */
 function link_pagina_ppal($courseid)
 {
 	global $CFG;
	return'<a href= "' . $CFG->wwwroot .'/course/view.php?id=' . $courseid .'> Volver al curso</a>';
 }
 
 /**
 * Devuelve el url de la página principal
 *
 * @param int $courseid
 *
 * @return string Url de la página principal del curso
 * 
 */
 function url_pagina_ppal($courseid)
 {
 	global $CFG;
	return $CFG->wwwroot .'/course/view.php?id=' . $courseid;
 }
 
 /**
 * Devuelve el url de la página donde se añaden los bloques
 *
 * @param int $courseid
 * 
 * @return string Url de la página de configuración de bloques
 *
 */
 function url_registro_bloque($courseid)
 {
 	global $CFG;
 	return $CFG->wwwroot .'/blocks/gturnos/registro_bloque.php?course=' . $courseid;
 }
 
  /**
 * Devuelve un booleano indicando si el bloque es definitivo o no
 *
 * @param int $courseid Identificador de curso
 * @param int $bloqueid Identificador de bloque
 * 
 * @return boolean Indica si es definitivo o no
 *
 */
 function es_definitivo($courseid, $bloque_entrega_id)
 {
	if(record_exists('bloques_entrega','courseid',$courseid,'id',$bloque_entrega_id))
	{
		$clausula = 'courseid = '. $courseid . ' AND ' . 'id = ' . $bloque_entrega_id; 
		$bloque = get_record_select('bloques_entrega',$clausula);
		return $bloque->definitiva;
	}else{
		return false;
	};
 }
 
 /**
 * Devuelve un booleano indicando si el bloque está lleno o no
 *
 * @param int $courseid Identificador de curso
 * @param int $bloqueid Identificador de bloque
 * 
 * @return boolean Indica si está lleno o no 
 *
 */
 function esta_lleno($courseid, $bloque_entrega_id)
 {
	if(record_exists('bloques_entrega','courseid',$courseid,'id',$bloque_entrega_id))
	{
		$clausula = 'courseid = '. $courseid . ' AND ' . 'id = ' . $bloque_entrega_id; 
		$bloque = get_record_select('bloques_entrega',$clausula);
		return $bloque->lleno;
	}else{
		return false;
	};
 }
 
 /**
 * Obtiene el id de bloque al que está apuntado el alumno (si lo está)
 *
 * @param int $courseid Identificador de curso.
 * @param int $userid Identificador de usuario.
 *
 * @return int El id de bloque si existe, 0 en caso contrario
 *
 */
 function obtener_id_bloque_alumno($courseid,$userid)
 {
	if(record_exists('user_bloque','courseid',$courseid,'userid',$userid))
	{
		$clausula = 'courseid = '. $courseid . ' AND ' . 'userid = ' . $userid; 
		$info_alumno = get_record_select('user_bloque',$clausula);
		return $info_alumno->bloques_entrega_id;
	}else{
		return 0;
	}
 }
 
 
 /**
 * Comprueba si la fecha del alumno es definitiva
 *
 * @param int $courseid Identificador de curso.
 * @param int $userid Identificador de usuario.
 *
 * @return boolean true si la fecha es definitiva, false en caso contrario
 *
 */
 function es_fecha_definitiva($courseid,$userid)
 {
 	///Obtenemos su id_bloque, y así comprobamos que está apuntado
 	$id_bloque = obtener_id_bloque_alumno($courseid,$userid);
	if($id_bloque!=0)
	{
		return es_definitivo($courseid,$id_bloque);
	}else{
		return false;
	}
 }
 
 /**
 * Devuelve un string con el enlace del heading y el título que le queramos dar 
 * al siguiente apartado
 *
 * @param int $courseid Identificador de curso.
 * @param int $titulo Título del siguiente apartado
 *
 * @return string Heading compuesto
 *
 */
 /*function obtener_heading($courseid,$titulo)
 {
 	global $CFG;
 	
	$cabecera = '<a href="'.$CFG->wwwroot.'/course/view.php?id='. $courseid .'">';
	$cabecera .= obtener_nombre_curso($courseid) .'</a> -> ';
	$cabecera .= $titulo;
	
	return $cabecera;
 }*/
 
 /**
 * Devuelve una descripción de la preferencia
 *
 * @param string $preferencia Caracter que indica la preferencia
 *
 * @return string Descripción de la preferencia
 *
 */
 function obtener_descripcion_preferencia($preferencia)
 {
	 	if ($preferencia=="P"){
	 		return get_string('pronto','block_gturnos');
	 	}else if ($preferencia=='T'){
	 		return get_string('tarde','block_gturnos');
	 	}else{
	 		return '';	
	 	}
 }

?>
