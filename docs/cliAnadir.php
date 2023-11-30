<?php 
require_once 'sesion.php';
comprobar_sesion();

 
$codProd = $_POST['codProd'];
$unidadesProd = (int)$_POST['unidades'];
$codCat=$_POST['codCat'];

if(isset($_SESSION['carrito'][$codProd])){
	$_SESSION['carrito'][$codProd] += $unidadesProd;
}else{
	$_SESSION['carrito'][$codProd] = $unidadesProd;		
}
header("Location: cliProductos.php?categoria=$codCat");
