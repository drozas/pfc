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
 * Definición de la clase gturnos.
 */
 

  require_once($CFG->dirroot.'/blocks/gturnos/lib.php');
 
  class block_gturnos extends block_list {
 
	/// Functions

	/**
	 * Define las variables miembro de las clase
	 *
	 */
    function init() {
        $this->title = get_string('gturnos', 'block_gturnos');
        $this->version = 2006110700;
    }
    /**
	 * No podemos usar this->config en el método init.
	 * Pero con este método se garantiza que se llama en cuanto la
	 * configuración está cargada
	 *
	 */
	function specialization() {
		if (!isset($this->config->title))
		{
			$this->title = get_string('gturnos', 'block_gturnos');
		}else{
    		$this->title = $this->config->title;
		}
	}
	
    
    /**
	 * Muestra el contenido de nuestro bloque.
	 * Es un bloque de tipo lista e instancia única.
	 */
    function get_content() {
    	global $COURSE;
    	global $USER;
    	
    	///Chequeamos que haya contenido previo, para no recalcularlo
		if ($this->content !== NULL) {
        	return $this->content;
    	}

		///Instanciamos la clase
    	$this->content = new stdClass;
    	$this->content->items = array();
		$this->content->icons = array();
  	
		///Si es estudiante, mostramos sólo la opción de registro o la fecha de entrega
		if (isstudent($COURSE->id))
		{
			$this->content->footer.= '<br> ';
			
    		if(tiene_fecha_asignada($COURSE->id, $USER->id, $fecha)==true)
    		{
    			if($fecha=='')
    			{
    				$this->content->footer = '<b>' . get_string('fecha_no_asignada','block_gturnos') .'</b>';
    			}else{
    				$this->content->footer = '<b>' . $fecha . '</b><br>';
    				if(es_fecha_definitiva($COURSE->id,$USER->id))
    				{
    					$this->content->footer .= get_string('fecha_definitiva','block_gturnos');
    				}else{
    					$this->content->footer .= get_string('fecha_no_definitiva','block_gturnos');	
    				}
    			}
    		}else{

	    		$this->content->items[] = '<a href=../blocks/gturnos/registro_alumno.php?course='. $COURSE->id . '&sesskey=' . sesskey(). '>' . get_string('registrarse','block_gturnos') . '</a>';
    			$this->content->icons[] = '<img src="../blocks/gturnos/icons/registrarse.gif" width="16" height="16" alt="" />';
    			$this->content->footer = '<b>' . get_string('no_registrado','block_gturnos') . '</b>';
    		}

		}
		
    	///Si es profesor, mostramos opciones de configuración/visualización
    	if (isteacher($COURSE->id))
    	{
	    	$this->content->items[] = '<a href=../blocks/gturnos/registro_bloque.php?course=' . $COURSE->id . '&sesskey=' . sesskey() .'>' . get_string('configurar_bloques','block_gturnos') .'</a>';
	    	$this->content->icons[] = '<img src="../blocks/gturnos/icons/configurar.gif" width="16" height="16" alt="" />';

  	    	$this->content->items[] = '<a href=../blocks/gturnos/ver_alumnos.php?course=' . $COURSE->id . '&sesskey=' . sesskey().'>' . get_string('ver_alumnos','block_gturnos') .'</a>';
	    	$this->content->icons[] = '<img src="../blocks/gturnos/icons/ver.gif" width="16" height="16" alt="" />';
	    	
		    $this->content->items[] = '<a href=../blocks/gturnos/vista_previa.php?course=' . $COURSE->id . '&sesskey=' . sesskey() .'>' . get_string('vista_previa','block_gturnos') .'</a>';	
    		$this->content->icons[] = '<img src="../blocks/gturnos/icons/calcular.gif" width="16" height="16" alt="" />';
    	
		    $this->content->items[] = '<a href=../blocks/gturnos/confirmar_cerrar.php?course=' . $COURSE->id .'&sesskey=' . sesskey() .'>' . get_string('cerrar_lista','block_gturnos') .'</a>';	
     		$this->content->icons[] = '<img src="../blocks/gturnos/icons/publicar.gif" width="16" height="16" alt="" />';
    		
    		//$this->content->footer = 'Recuerda : ¡El día 21 es el último para que se registren los alumnos!';
    	}
	  	return $this->content;
	}
	
	/**
	 * Función para darle a nuestro bloque opciones de configuración específicas.
	 * Esto no se requiere en multi-instancia
	 */
	function instance_allow_config() {
		return true;
	}
	
	
	/**
	 * Función para sobreescribir el array asociativo que determina en que formatos se ve el bloque.
	 * Sólo permitimos que se muestre en cursos.
	 */
	function applicable_formats() {
		
    	return array('course-view' => true, 'site' => false);
	}
	
	/**
	* Función que sobreescribimos para eliminar toda la información referente a ese curso en 
	* nuestra base de datos cuando se elimina una instancia.
	*/
	function instance_delete(){
		
		global $COURSE;
		
		///Borramos todos los registros asociados a ese curso de las tablas user_bloque 
		///y bloque de entrega.
	
		delete_records('user_bloque','courseid',$COURSE->id);
		delete_records('bloques_entrega','courseid',$COURSE->id);
	}

}
 
 
?>
