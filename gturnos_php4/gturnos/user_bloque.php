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
 * Clase user_bloque
 * 
 */

	/*Clase para almacenar la información del registro de un usuario en un bloque de entrega en la db*/
	class user_bloque
	{
		/*Los atributos se declaran de forma diferente en las versiones 4 y 5 de php.
		 * Tendré que crear dos lanzamientos distintos.
		 */
	    /// Atributos php5
	    /*public $userid;
	    public $courseid;
	    public $bloques_entrega_id;
	    public $preferencia;
	    public $dia_entrega;
	    public $h_entrega;
	    public $fecha_registro;*/
	    
	   	/// Atributos php4
	    var $userid;
	    var $courseid;
	    var $bloques_entrega_id;
	    var $preferencia;
	    var $dia_entrega;
	    var $h_entrega;
	    var $fecha_registro;
	    
	    ///¡Cuidado, parece que no se pueden sobrecargar los constructores!
	    function __construct()
    	{
    	}

	    /*function __construct($userid,$nombre,$email,$turno)
    	{
    		$this->userid = $userid;
    		$this->nombre = $nombre;
    		$this->email = $email;
    		$this->turno = $turno;
    	}*/
	    
	    /// Métodos
	    /*public function mostrar()
	    {
	        echo 'Nombre = ' . $this->nombre . '<br>';
	        echo 'Id = ' . $this->userid . '<br>';
	        echo 'Email = ' . $this->email . '<br>';
	        echo 'turno = ' . $this->turno . '<br>';
	    }*/
	    
	}

?>
