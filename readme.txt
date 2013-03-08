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

This software is a completely new implementation of "idlist", an enrollment plugin developed for Moodle 1.9 by Juan Pedro Bolivar Puente (https://savannah.nongnu.org/projects/cvg-moodle)

This plugin is designed to automatize the enrollment of users, using a list of authorized students. The users are enrolled automatically if they are included in the list. 

Most of the methods to enroll many users in moodle are based in the "userid" field. This plugin facilitates the enrollment of many users without knowing the "userid" field because the list is based on any of the users' fields.

In the plugin configuration, the teacher have to define (among other things):

1.- The field to be used for the validation, that is, one from the standard fields or even from the user profile (user defined fields).
2.- List of users allowed to enrol the course. This list includes, for each user, the value of the previous field (among other information).


If this plugin is active, the first time a student enters into the course, the value of the student' selected field is compared with those in the list of users. If the corresponding value is found in the list, then the user is automatically enrolled. Otherwise, the student is not allowed to enroll into the course.

For example, suppose you have a list of students who are allowed to enter our course (name, surname, email and age) like this:

  Name      Surname          Email                       Age
  Javier    Martinez Baena   jbaena@decsai.ugr.es        20
  Jose      Garcia Garcia    josegarcia@domain.com       21
  Antonio   Perez Perez      antonioperez@domain.com     24

If you configure the plugin to use the email as the field for validation, only the students with one of the emails in the list can access the course.

Note that when the list of authorized users is entered in the plugin configuration form, you can write a list as the one above, which also may include other information as the name, surname, age or even other fields that are not used. Obviously, we have to filter this values to compare only the selected field. In the plugin configuration you have to define a regular expression, used to select the values to be compared. In our example, the algorithm to find matches works as follows:

- We extract values ​​from the list of valid users that match the regular expression.
- We compare the "email" field of the user with each of the values obtained in previous step.

Note that the regular expression must be compatible with the type of field you want to validate. For example, if we are going to validate emails, then the regular expression should be something like \b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b (obtained from http://www.regular-expressions.info/regexbuddy/email.html)

Another option of the plugin configuration form is the checkbox "Filter user field". If actived, the value of the user field is also filtered (before matching) with the regular expression. Thus, we could even use just a part of the field.

Note that we have to configure the plugin carefully, because this algorithm does not guarantee the validated user to be the one you included in the list. Depending on the field of validation and the regular expression, an user could be enrolled by mistake. 

After configuring the plugin (saving changes), if you enter to the settings form again, you can see two lists:

1.- The list of unauthorized users, that is, the enrolled users who are not in the authorized users according to current configuration. This could happen when users are enrolled using other methods.
2.- The list of authorized values. These are all the values extracted from the list of authorized users, logically, using the regular expression. This list is usefull to test if the regular expression is working as desired.

Acknowledgements:
Special thanks to Antonio Garrido (University of Granada), who has contributed in many ways.

*****************
SPANISH / ESPAÑOL
*****************

Este software es una nueva implementación del plugin de matriculación denominado "idlist" que fue desarrollado por Juan Pedro Bolivar Puente para Moodle 1.9 (https://savannah.nongnu.org/projects/cvg-moodle).

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

Agradecimientos:
A Antonio Garrido (Universidad de Granada) por sus múltiples aportaciones al proyecto.
