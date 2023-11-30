<?php
    require "adminCabecera.php";
    require "sesion.php";
    require_once "bd.php";
    comprobar_sesion();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST["opcion"])){
            $opcion = $_POST["opcion"];
            switch($opcion){
                case "crear":
                    $nomProd = $_POST["nomProd"];
                    $descripcionProd = $_POST["descripcionProd"];
                    $stock = $_POST["stock"];
                    $precioProd = $_POST["precioProd"];
                    $pesoProd = $_POST["pesoProd"];
                    $codCat = $_POST["codCat"];

                    crearProducto($nomProd, $descripcionProd, $stock, $precioProd, $pesoProd, $codCat);
                    break;

                case "eliminar":
                    $codProd = $_POST["codProd"];
                    eliminarProducto($codProd);
                    break;
                
                case "modificar":
                    $codProd = $_POST["codProd"];
                    $stock = $_POST["stock"];
                    modificarStock($codProd, $stock);
                    break;

            }
        }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2> Gestión de productos</h2>

    <h3> Creación de productos</h3>
    <form action="adminProductos.php" method="POST">
        <input type="hidden" name="opcion" value="crear">
        <label for="nomProd">Nombre del producto:</label>
        <input type="text" name="nomProd" id="nomProd">
        <br>
        <label for="descripcionProd">Descripción del producto:</label>
        <input type="text" name="descripcionProd" id="descripcionProd">
        <br>
        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock">
        <br>
        <label for="precioProd">Precio del producto:</label>
        <input type="number" name="precioProd" id="precioProd">
        <br>
        <label for="pesoProd">Peso del producto:</label>
        <input type="number" name="pesoProd" id="pesoProd">
        <br>
        <label for="codCat">Código de categoría:</label>
        <input type="number" name="codCat" id="codCat">
        <br>
        <input type="submit" value="Crear">
    </form>

    <h3> Eliminación de productos</h3>
    <form action="adminProductos.php" method="POST">
        <input type="hidden" name="opcion" value="eliminar">
        <label for="codProd">Código de producto:</label>
        <input type="text" name="codProd" id="codProd">
        <br>
        <input type="submit" value="Eliminar">
    </form>

    <h3> Modificación de stock</h3>
    <form action="adminProductos.php" method="POST">
        <input type="hidden" name="opcion" value="modificar">
        <label for="codProd">Código de producto:</label>
        <input type="text" name="codProd" id="codProd">
        <br>
        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock">
        <br>
        <input type="submit" value="Modificar">
</body>
</html>