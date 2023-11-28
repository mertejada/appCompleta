<?php
	require_once 'sesion.php';	
	comprobar_sesion();
	$_SESSION = array();
	session_destroy();
	setcookie(session_name(), 123, time() - 1000); // eliminar la cookie
    header('Location: login.php');
?>

