<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'railbooking';

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
