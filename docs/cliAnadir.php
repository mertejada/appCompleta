<?php 
require_once 'sesion.php';
require 'bd.php';
comprobar_sesion();

$codProd = $_POST['codProd'];
$unidadesProd = (int)$_POST['unidades'];
$codCat=$_POST['codCat'];


if(isset($_SESSION['carrito'][$codProd])){
	$_SESSION['carrito'][$codProd] += $unidadesProd;
}else{
	$_SESSION['carrito'][$codProd] = $unidadesProd;		
}

//revision de que nunca se añadan más unidades de las que hay en stock
$stock = obtenerStock($codProd);
if($_SESSION['carrito'][$codProd] > $stock){
	$_SESSION['carrito'][$codProd] = $stock;
}
header("Location: cliProductos.php?categoria=$codCat");
