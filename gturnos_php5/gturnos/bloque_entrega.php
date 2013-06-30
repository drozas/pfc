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
 * Clase bloque de entrega
 * 
 */

	/*Clase para almacenar la información del registro de un bloque de entrega en la db*/
	class bloque_entrega
	{
	    /// Atributos php5
	    public $id;
	    public $courseid;
	    public $dia;
	    public $h_inicio;
	    public $h_fin;
	    public $n_correctores;
	    public $duracion_turno;
	    public $lleno;
	    public $definitiva;
	    
	    /// Atributos php4
	    /*var $id;
	    var $courseid;
	    var $dia;
	    var $h_inicio;
	    var $h_fin;
	    var $n_correctores;
	    var $duracion_turno;
	    var $lleno;
	    var $definitiva;*/
	    
	    function __construct()
    	{
    	}


	}

?>
