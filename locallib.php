<?php
/*
 *  Copyright (C) 2013 Javier Martinez Baena
 *                     Antonio Garrido Carrillo
 *                     - University of Granada -
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

/**
 * IDList2 enrolments plugin. Auxiliary functions
 * 
 * @package    enrol
 * @subpackage idlist2
 * @copyright  2013 Javier Martinez Baena, Antonio Garrido Carrillo
 * @author     Javier Martinez Baena, Antonio Garrido Carrillo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Get all field names (standard and non-standard)
function enrol_idlist2_get_fieldlist()
{
  global $USER;
  $campos = array();
  $camposestandar = user_get_default_fields();
  foreach ($camposestandar as $campo)
    $campos[] = $campo;
  $camposextra = array_keys((array)profile_user_record($USER->id));
  foreach ($camposextra as $campo)
    $campos[] = $campo;
  return $campos;
}

// Input: field names
// Output: Positio nof the preferred field (in this order: DNI or email or the first one)
function enrol_idlist2_preferred_field($campos)
{
  // Por defecto: si existe dni, sino email
  $defecto = array_search('dni', $campos);
  if (!$defecto) {
    $defecto = array_search('email', $campos);
    if (!$defecto)
      $defecto = 0;
  }
  return $defecto;
}

// Return the value of the field of the user
// $campo = field name to check
function enrol_idlist2_userid($campo,$usuario)
{
  $nombrecampo = 'unnombre';
  $$nombrecampo = /*$instance->customchar1*/ $campo;
  if (array_search(/*$instance->customchar1*/ $campo,user_get_default_fields())!=false) {
    // Es un campo estandar
    $valorusu = $usuario->${$nombrecampo};
  } else {
    // Es un campo adicional
    $cmp = (array)profile_user_record($usuario->id);
    if (array_key_exists(/*$instance->customchar1*/$campo,$cmp))
      $valorusu = $cmp[/*$instance->customchar1*/$campo];
    else
      $valorusu = 'no existe el campo';
  }
  return $valorusu;
}

// Authorized list of values (filtered with regular expression)
// $datos : string with all authorized values (and maybe more things)
function enrol_idlist2_authlist($expreg,$datos)
{
  // Reguslar expression must be between demiliters
  preg_match_all('%'.$expreg.'%', $datos, $listaids);
  return $listaids[0];
}


function enrol_idlist2_authorized($valorusu,$listaids,$expreg,$marca)
{
  if ($marca==true) {
    // Filter user field with regular expression
    preg_match_all('%'.$expreg.'%', $valorusu, $res);
    $valorusufilt = $res[0][0];
  } else
    $valorusufilt = $valorusu;

  $result = array_search($valorusufilt,$listaids);
  if ($result!==false)
    $result = true;
  return $result;
}

// Return unauthorized user id list
// $context
// $listaids : authorized ID
function enrol_idlist2_unauthorized($context,$listaids,$campo)
{
  // Enrolled users
  $matriculados = get_enrolled_users($context);

  // Field name
  $campos = enrol_idlist2_get_fieldlist();
  $elcampo = $campos[$campo];

  $mat = array();
  //$campo = enrol_idlist2_userid($campo,$usuario)

  foreach ($matriculados as $usu) {
    $valorusu = enrol_idlist2_userid($elcampo,$usu);
    $esta = array_search($valorusu,$listaids);
    if ($esta===false)
      $mat[] = $usu;
  }
  return $mat;
}

/*function enrol_idlist2_getfieldname($campo)
{
  $nom = get_user_field_name($campo);
  if (substr($nom,0,2)=='[[')
    $nom = $campo;
  return $nom;
}*/

// Input: user list
// Return: html table with users
function enrol_idlist2_usertable($listaid,$campo,$courseid)
{
  global $OUTPUT;
  // Nombre del campo
  $campos = enrol_idlist2_get_fieldlist();
  $elcampo = $campos[$campo];

  $tabla = new html_table();
  $tabla->head = array(get_string('enrol_idlist2_userpicture','enrol_idlist2'),$elcampo,'ID',
                       get_user_field_name('username'),get_user_field_name('firstname'),
                       get_user_field_name('lastname'),get_user_field_name('email'));
  $tabla->data = array();
  foreach ($listaid as $usu) {
    $fila = array();
    $fila[] = $OUTPUT->user_picture($usu);
    $fila[] = enrol_idlist2_userid($elcampo,$usu);
    $fila[] = $usu->id;
    $url = new moodle_url('/user/view.php',array('id'=>$usu->id,'course'=>$courseid));
    $fila[] = $OUTPUT->action_link($url,$usu->username);
    $fila[] = $usu->firstname;
    $fila[] = $usu->lastname;
    $fila[] = $usu->email;
    $tabla->data[] = $fila;
  }

  return html_writer::table($tabla);
}

?>
