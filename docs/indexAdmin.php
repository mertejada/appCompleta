
<?php
    require "adminCabecera.php";
    require_once "sesion.php";
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
    <h1>Bienvenido, administrador.</h1>
    <h2> ¿Qué desea gestionar?</h2>
    <ul>
        <li><a href="adminUsuarios.php">Usuarios</a></li>
        <li><a href="adminCategorias.php">Categorías</a></li>
        <li><a href="adminProductos.php">Productos</a></li>
        <li><a href="adminPedidos.php">Pedidos</a></li>
    </ul>
    <form action="indexAdmin.php" method="post">
        <input type="submit" name="cerrarSesion" value="Cerrar sesión">
    </form> 
</body>
</html>