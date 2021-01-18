<?php
//liste des formats autorisés
$allowed = array('mp3', 'm4a', 'm4b', 'aac', 'aax', 'mpc');
foreach ($allowed as $value) {
    $list = $value . ', ';
}
require_once 'sqlparameters.php';

class Settings
{
    static $password = "polo022001";
    static $uploadFolder = "uploads/";
}