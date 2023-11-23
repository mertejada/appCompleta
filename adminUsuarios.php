<?php
    require_once "sesion.php";
    require_once "bd.php";
    comprobar_sesion();

    if(isset($_POST['opcion'])){
        $opcion = $_POST['opcion'];
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
    <h2> Gestión de usuarios</h2>
    <form action="adminUsuarios.php" method="post">
        <div>
            <select name="opcion">
                <option value="1">Crear usuario</option>
                <option value="2">Modificar usuario</option>
                <option value="3">Eliminar usuario</option>
            </select>
            <input type="submit" value="Enviar">
        </div>

    </form>

    <?php
    /*
        switch($opcion){
            case 1: ?>
                <form action = "adminUsuarios.php" method="post">
                    <div>
                        <label for="idUsuario">ID Usuario</label>
                        <input type="text" name="idUsuario" id="idUsuario">
                    </div>
                    <div>
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre">
                    </div>
                    <div>
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" id="apellido">
                    </div>
                    <div>
                        <label for="clave">Clave</label>
                        <input type="text" name="clave" id="clave">
                    </div>
                    <div>
                        <label for="codRol">Código de rol</label>
                        <input type="text" name="codRol" id="codRol">
                    </div>
                    <div>
                        <select name="descRol">
                            <option value="1">Administrador</option>
                            <option value="2">Cliente</option>
                        </select>
                    </div>
                    <div>
                        <label for="correo">Correo</label>
                        <input type="text" name="correo" id="correo">
                    </div>
                    <div>
                        <label for="fechaNac">Fecha de nacimiento</label>
                        <input type="date" name="fechaNac" id="fechaNac">

                    </div>
                    <div>
                        <input type="submit" value="Enviar">
                    </div>

            <?php
                $idUsuario = $_POST['idUsuario'];
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $clave = $_POST['clave'];
                $codRol = $_POST['codRol'];
                $descRol = $_POST['descRol'];
                $correo = $_POST['correo'];
                $fechaNac = $_POST['fechaNac'];
                
                crearUsuario($idUsuario, $nombre, $apellido, $clave, $codRol, $descRol, $correo, $fechaNac);
                break;
            case 2:
                header("Location: modificarUsuario.php");
                break;
            case 3:
                header("Location: eliminarUsuario.php");
                break;
        }
    */?>
    
</body>
</html>

