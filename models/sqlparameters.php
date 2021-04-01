<?php
define('HOST', 'localhost');
define('DB', 'fill');
define('USER', 'paulemfag');
define('PASSWORD', 'polo022001');
$dsn = 'mysql:dbname=' . DB . '; host=' . HOST;
$db = new PDO($dsn, USER, PASSWORD);
