<?php
    require "adminCabecera.php";
    require_once "sesion.php";
    require_once "bd.php";
    comprobar_sesion();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST["opcion"])){
            $opcion = $_POST["opcion"];
            switch($opcion){
                case "crear":
                    $idUsuario = $_POST["idUsuario"];
                    $nombre = $_POST["nombre"];
                    $apellido = $_POST["apellidos"];
                    $clave = $_POST["clave"];
                    $descRol = $_POST["descRol"];
                    $correo = $_POST["correo"];
                    $fechaNac = $_POST["fechaNac"];
                    crearUsuario($idUsuario, $nombre, $apellido, $clave, $descRol, $correo, $fechaNac);
                    break;

                case "eliminar":
                    $idUsuario = $_POST["idUsuario"];
                    eliminarUsuario($idUsuario);
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
    <h2> Gestión de usuarios</h2>
    <h3> Creación de usuarios</h3>
    <form action="adminUsuarios.php" method="POST">
        <input type="hidden" name="opcion" value="crear">
        <label for="idUsuario">ID Usuario:</label>
        <input type="text" name="idUsuario" id="idUsuario">
        <br>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre">
        <br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos">
        <br>
        <label for="clave">Clave:</label>
        <input type="password" name="clave" id="clave">
        <br>
        <label for="descRol">Descripción de rol:</label>
        <select name="descRol" id="descRol">
            <option value="Administrador">Administrador</option>
            <option value="Cliente">Cliente</option>
        </select>
        <br>
        <label for="correo">Correo:</label>
        <input type="text" name="correo" id="correo">
        <br>
        <label for="fechaNac">Fecha de nacimiento:</label>
        <input type="date" name="fechaNac" id="fechaNac">
        <br>
        <input type="submit" value="Crear usuario">
    </form>
    <!--
    <h3> Modificación de usuarios</h3>
    <h4> Escriba el ID del usuario y los campos que desea modificar</h4>
    <form action="adminUsuarios.php" method="POST">
        <input type="hidden" name="opcion" value="modificar">
        <label for="idUsuario">ID Usuario*:</label>
        <input type="text" name="idUsuario" id="idUsuario">
        <br>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre">
        <br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos">
        <br>
        <label for="clave">Clave:</label>
        <input type="password" name="clave" id="clave">
        <br>
        <label for="codRol">Código de rol:</label>
        <input type="text" name="codRol" id="codRol">
        <br>
        <label for="descRol">Descripción de rol:</label>
        <select name="descRol" id="descRol">
            <option value="Administrador">Administrador</option>
            <option value="Cliente">Cliente</option>
        <br>
        <label for="correo">Correo:</label>
        <input type="text" name="correo" id="correo">
        <br>
        <label for="fechaNac">Fecha de nacimiento:</label>
        <input type="date" name="fechaNac" id="fechaNac">
        <br>
        <input type="submit" value="Modificar usuario"> -->

    <h3> Eliminación de usuarios</h3>
    <form action="adminUsuarios.php" method="POST">
        <input type="hidden" name="opcion" value="eliminar">
        <label for="idUsuario">Id de usuario:</label>
        <input type="text" name="idUsuario" id="idUsuario">
        <br>
        <input type="submit" value="Eliminar usuario">
        <br>
    </form>
</body>
</html>

