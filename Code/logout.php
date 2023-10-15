<?php
include('dbConnector.php');
//Session starten||leeren||und löschen
session_start();
session_unset();
$_SESSION['loggedin'];
session_destroy();
header('Location: index.php');
?>