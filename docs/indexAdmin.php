
<?php
    require_once "sesion.php";
    require_once "bd.php";
    comprobar_sesion();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST["opcion"])){
            $opcion = $_POST["opcion"];
            switch($opcion){
                case 1:
                    header('Location: adminUsuarios.php');
                    break;
                case 2:
                    header('Location: adminProductos.php');
                    break;
                case 3:
                    header('Location: adminCategorias.php');
                    break;
                case 4:
                    header('Location: adminDescuentos.php');
                    break;
            }
        }

        

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
    <h1>Bienvenido, administrador</h1>
    <h2> ¿Qué desea gestionar?</h2>
    <form action="indexAdmin.php" method="post">
        <div>
            <select name="opcion">
                <option value="1">Usuarios</option>
                <option value="2">Productos</option>
                <option value="3">Categorías</option>
                <option value="4">Descuentos</option>
            </select>
            <input type="submit" value="Enviar">
        </div>
        <div>
        <input type="submit" name="cerrarSesion" value="Cerrar sesión">
    </form> 
</body>
</html>