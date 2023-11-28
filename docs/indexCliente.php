<?php
    require "cliCabecera.php";
    require "sesion.php";
    require_once "bd.php";
    comprobar_sesion();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['cerrarSesion'])){
            session_destroy();
            header('Location: login.php');
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
    <h1>¡Bienvenido, <?php echo $_SESSION['usuario']?>!</h1>
<hr>
<h2>¿Qué desea hacer?</h2>
    <form action="indexAdmin.php" method="post">
        <div>
        <a href="cliCategorias.php">Ver categorías</a><br>
        <a href="cliCarrito.php">Ver carrito</a><br></div>

        <div>
            <br>
        <input type="submit" name="cerrarSesion" value="Cerrar sesión">
        </div>
    </form> 
</body>
</html>