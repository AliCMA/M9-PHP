<?php
session_start();
require_once 'database.php';

// Define your database configuration here
define('DB_SERVER', 'mariadb');
define('DB_USER', 'root');
define('DB_PASSWORD', 'hooyo123');
define('DB_NAME', 'newsletter');

$db = new Database(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
?>
