<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'm295db';

$mysqli = new mysqli($host, $username, $password, $database);

if($mysqli->connect_error) {
    die('Verbindungsfehler (' .$mysqli->connect_error. ') '. $mysqli->connect_error);
} else {
    session_start();
}
?>