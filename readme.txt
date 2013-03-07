/*
 *  Copyright (C) 2013 Javier Martinez Baena
 *
 *  This file is part of enrol/idlist2.
 *   
 *  enrol/idlist2 is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  enrol/idlist2 is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

*******
ENGLISH
*******

This plugin is designed to automate the process of enrollment of students when the teacher has prior information that uniquely identifies them. No need to know the "userid".

The teacher must define a field with which to verify if a student is allowed or not in the course. You must also provide a list of valid values ​​for that field. When students first enter the course (without being previously enrolled) will check if the value of the field defined by the teacher matches any of the values ​​from the list provided by the teacher. If so automatically enrolls.

The field can be one of the standard fields moodle or one of the user profile fields (defined by the site administrator).

By introducing the list of allowed values​​, you can write more information than is strictly necessary. For example, suppose you have a list that looks like this (DNI is an identification number):

    DNI           Name      Surnames
    12121212X     Javier    Martinez Baena
    32451423A     Antonio   Garrido Carrillo
    X-345264-A    Joaquin   Fernandez Valdivia
    ...

If we admit in the course only to students whose "DNI" are on the list we have to create a new field for the user named "DNI". We copy that list in the plugin configuration (no need to remove names even if they are not used in verification). Since the list has more information than we need, what we will do is filter it and extract only the data that verify a regular expression (also configurable in the plugin). In this example, we can extract the "DNI" numbers without letters with this regular expression: [0-9][0-9][0-9][0-9][0-9]+ ie extract all those numbers with 5 or more digits (we consider that a "DNI" is a sequence that contains at least 5 consecutive digits).

Thus any student with a "DNI" that matches 12121212, 32451423 or 345264 will have access to the course. If the student defines his "DNI" with letters, this can also be filtered by applying the regular expression (this is another option of the plugin).

After configuring the plugin, if you went back to the settings you can see a list of the field values ​​obtained after filtering with regular expression. We also have a list of students who are enrolled in the course but do not appear in the list of authorized plugin.


*****************
SPANISH / ESPAÑOL
*****************

Este plugin está diseñado para automatizar el proceso de matriculación de los estudiantes cuando el profesor dispone de información previa sobre ellos que los identifica unívocamente. No necesita conocer el "userid".

El profesor debe definir un campo por el que se va a verificar si un alumno está autorizado o no en el curso. También debe suministrar una lista de valores válidos para ese campo. Cuando el alumno entra por primera vez al curso (sin estar matriculado) se comprobará si el valor del campo definido por el profesor coincide con alguno de los valores de la lista suministrada por el profesor. De ser así se matricula automáticamente.

El campo puede ser uno de los campos estándar de moodle o uno de los campos de perfil del usuario (definido por el administrador del sitio).

Al introducir la lista de valores autorizados, es posible escribir más información de la estrictamente necesaria. Por ejemplo, supongamos que disponemos de un listado con el siguiente aspecto (DNI es un número de identificación):

    DNI           Nombre    Apellidos
    12121212X     Javier    Martinez Baena
    32451423A     Antonio   Garrido Carrillo
    X-345264-A    Joaquin   Fernandez Valdivia
    ...

Si deseamos admitir en el curso sólo a los alumnos cuyo DNI esté en esa lista debemos crear un nuevo campo para el usuario denominado "DNI". Copiamos esa lista en la configuración del plugin (no es necesario eliminar nombres aunque no se utilicen en la verificación). Puesto que en la lista hay más información de la que necesitamos, lo que haremos será filtrarla y extraer sólo aquellos datos que verifiquen una expresión regular (también configurable en el plugin). En este ejemplo, podemos extraer los números de DNI sin letra con esta expresión:  [0-9][0-9][0-9][0-9][0-9]+  es decir, extraemos todos aquellos números de 5 o más cifras (consideramos que un DNI es una secuencia que contiene, al menos, 5 dígitos consecutivos).

De esta forma cualquier alumno que tenga un DNI que coincida con 12121212, 32451423 o 345264 tendrá acceso al curso. Si el alumno define su DNI también con letra, esta puede filtrarse también aplicándole la expresión regular (una opción del plugin).

Una vez configurado el plugin, al entrar de nuevo en la configuración podemos ver un listado con los valores de los campos que se obtienen tras filtrar con la expresión regular. También tenemos un listado con los alumnos que están matriculados ne el curso pero que no aparecen en la lista de autorizados del plugin.
