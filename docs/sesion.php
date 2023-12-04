<?php
function comprobar_sesion(){
	session_start();
	if(!isset($_SESSION['usuario'])){	
		header("Location: login.php?redirigido=true");
	}		
}

//debo controlar que el usuario sea administrador? o solo que este logueado? 