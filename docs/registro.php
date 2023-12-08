<?php

require_once 'bd.php';

$error= "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['registro'])) {
        $idUsuario = $_POST['idUsuario'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $clave = $_POST['clave'];
        $descRol = "Cliente";
        $correo = $_POST['correo'];
        $fechaNac = $_POST['fechaNac'];

        $resultadoRegistro = crearUsuario($idUsuario, $nombre, $apellido, $clave, $descRol, $correo, $fechaNac);

        if($resultadoRegistro){
            session_start();
                $_SESSION['usuario'] = $idUsuario;
                $_SESSION['carrito'] = [];
            header('Location: indexCliente.php');
        }else{
            $error = "<b><span style='color: red;'>$resultadoRegistro</span></b>";
        }
    }

    if (isset($_POST['volver'])) {
        header('Location: login.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>
    <h3>Formulario de registro</h3>
    <?php
    if (!empty($error)) {
        echo $error;
    }
    ?>
    <form action="registro.php" method="POST">
        <table>
            <tr>
                <td><label for="idUsuario">Nombre usuario:</label></td>
                <td><input type="text" name="idUsuario" id="idUsuario" pattern="[a-zA-Z0-9]+" required></td>
            </tr>
            <tr>
                <td><label for="nombre">Nombre:</label></td>
                <td><input type="text" name="nombre" id="nombre" pattern="[A-Za-z]+" required></td>
            </tr>
            <tr>
                <td><label for="apellido">Apellidos:</label></td>
                <td><input type="text" name="apellido" id="apellido" pattern="[A-Za-z]+" required></td>
            </tr>
            <tr>
                <td><label for="clave">Clave:</label></td>
                <td><input type="password" name="clave" id="clave" required></td>
            </tr>
            <tr>
                <td><label for="correo">Correo:</label></td>
                <td><input type="text" name="correo" id="correo" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required></td>
            </tr>
            <tr>
                <td><label for="fechaNac">Fecha de nacimiento:</label></td>
                <td><input type="date" name="fechaNac" id="fechaNac" value="1950-01-01" required></td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="registro" value="Registrarse">
                    <a href="login.php">Volver al login</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
