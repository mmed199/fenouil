<?php
/**
 * France departments
 *
 * @author  Moussaoui Mohammed <rodmontgt@gmail.com> http://espaciogt.wordpress.com
 * @version 1.0.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
global $states;

$states ['FR' ] = array (
    'GT-AV' => 'Alta Verapaz',
    'GT-BV' => 'Baja Verapaz',
    'GT-CM' => 'Chimaltenango',
    'GT-CQ' => 'Chiquimula',
    'GT-PR' => 'El Progreso',
    'GT-ES' => 'Escuintla',
    'GT-GU' => 'Guatemala',
    'GT-HU' => 'Huehuetenango',
    'GT-IZ' => 'Izabal',
    'GT-JA' => 'Jalapa',
    'GT-JU' => 'Jutiapa',
    'GT-PE' => 'Petén',
    'GT-QZ' => 'Quetzaltenango',
    'GT-QC' => 'Quiché',
    'GT-RE' => 'Retalhuleu',
    'GT-SA' => 'Sacatepéquez',
    'GT-SM' => 'San Marcos',
    'GT-SR' => 'Santa Rosa',
    'GT-SO' => 'Sololá',
    'GT-SU' => 'Suchitepéquez',
    'GT-TO' => 'Totonicapán',
    'GT-ZA' => 'Zacapa',
);

/*
$departements = json_decode(file_get_contents('departments.json'),true);

$departementsf = array();

foreach($departements as $key => $value){
    array_push($departementsf, $value['slug'],$value['slug'],$value['name']);
}

$states ['FR'] = $departementsf;
*/