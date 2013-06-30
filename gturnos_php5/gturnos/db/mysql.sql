# This file contains a complete database schema for all the 
# tables used by this module, written in SQL

#
# Table structure for table `appointment`
#

# gTurnos. Block for moodle which manages the distribution of turns.    
# Copyright (C) 2006  David Rozas Domingo     david.rozas@gmail.com                
#                                                                                    
# This file is part of gTurnos.                                                
#                                                                              
# gTurnos is free software; you can redistribute it and/or modify                
# it under the terms of the GNU General Public License as published by            
# the Free Software Foundation; either version 2 of the License, or            
# (at your option) any later version.                                            
#                                                                                 
# gTurnos is distributed in the hope that it will be useful,                    
# but WITHOUT ANY WARRANTY; without even the implied warranty of                
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                
# GNU General Public License for more details.                                    
#                                                                                
# You should have received a copy of the GNU General Public License            
# along with this program; if not, write to the Free Software                    
# Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA    


#25-10-06 drozas : 	- Eliminamos índices creados por DBDesigner
#			- Cambiado nombre de foreign keys
#			- Se añade campo duracion_turno, se eliminan "_" de los que hacen referencia a moodle, se cambia la forma de almacenar la fecha 			
#28-10-06 drozas : 	- Se añade campo lleno, que bloquea el acceso de nuevos usuarios, y el campo definitiva, que la presenta como definitiva.
#02-11-06 drozas : 	- Si existía la tabla, hacemos un drop table

DROP TABLE IF EXISTS mdl_bloques_entrega;
DROP TABLE IF EXISTS mdl_user_bloque;

CREATE TABLE mdl_bloques_entrega (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  courseid INT NOT NULL,
  dia DATE NOT NULL,
  h_inicio TIME NOT NULL,
  h_fin TIME NOT NULL,
  n_correctores INT NOT NULL DEFAULT '1',
  duracion_turno INT NOT NULL DEFAULT '15',
  lleno BOOL NOT NULL,
  definitiva BOOL NOT NULL,
  PRIMARY KEY(id, courseid),
  FOREIGN KEY(courseid)
    REFERENCES mdl_course(id)
      ON DELETE CASCADE
      ON UPDATE CASCADE
)COMMENT = 'Define la tabla mdl_bloques_entrega';

--#Ejemplo de insercion : insert into mdl_bloques_entrega (courseid,dia,h_inicio,h_fin,n_correctores,duracion_turno,finalizado_plazo) values(2,STR_TO_DATE('31/10/2006', '%d/%m/%Y'),'09:00','13:00',2,15,false);



CREATE TABLE mdl_user_bloque (
  userid INT NOT NULL,
  courseid INT NOT NULL,
  bloques_entrega_id INT UNSIGNED NOT NULL,
  preferencia VARCHAR(1) NOT NULL,
  dia_entrega DATE NULL,
  h_entrega TIME NULL,
  fecha_registro  DATETIME,
  PRIMARY KEY(userid, courseid),
  FOREIGN KEY(userid)
    REFERENCES mdl_user(id)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(bloques_entrega_id, courseid)
    REFERENCES mdl_bloques_entrega(id, courseid)
      ON DELETE CASCADE
      ON UPDATE CASCADE
)COMMENT = 'Define la tabla mdl_user_bloque';

--#Ejemplo de insercion : insert into mdl_user_bloque(userid,courseid,bloques_entrega_id,preferencia,dia_entrega,h_entrega) VALUES  (5,2,3,'P',STR_TO_DATE('31/10/2006', '%d/%m/%Y'),'12:15');

