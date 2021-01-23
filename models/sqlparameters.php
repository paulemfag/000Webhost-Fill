<?php
define('HOST', 'localhost');
define('DB', 'fill');
define('USER', 'dieu');
define('PASSWORD', 'A');
$dsn = 'mysql:dbname=' . DB . '; host=' . HOST;
$db = new PDO($dsn, USER, PASSWORD);
