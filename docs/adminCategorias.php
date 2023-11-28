<?php
    require "adminCabecera.php";
    require_once "sesion.php";
    require_once "bd.php";
    comprobar_sesion();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        

        if(isset($_POST["opcion"])){
            $opcion = $_POST['opcion'];
            switch($opcion){
                case "crear":
                    $nomCat = $_POST["nomCat"];
                    $descripcionCat = $_POST["descripcionCat"];
                    crearCategoria($nomCat, $descripcionCat);
                    break;

                case "eliminar":
                    $codCat = $_POST["codCat"];
                    eliminarCategoria($codCat);
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
    <h2> Gestión de categorías</h2>
    <h4> Creación de categorías</h4>
    <form action="adminCategorias.php" method="POST">
        <input type="hidden" name="opcion" value="crear">
        <label for="nomCat">Nombre de la categoría:</label>
        <input type="text" name="nomCat" id="nomCat">
        <br>
        <label for="descripcionCat">Descripción de la categoría:</label>
        <input type="text" name="descripcionCat" id="descripcionCat">
        <br>
        <input type="submit" value="Crear">
    </form>

    <h4> Eliminación de categorías</h4>
    <form action="adminCategorias.php" method="POST">
        <input type="hidden" name="opcion" value="eliminar">
        <label for="codCat">Código de la categoría:</label>
        <input type="text" name="codCat" id="codCat">
        <br>
        <input type="submit" value="Eliminar">
    </form>
</body>
</html>