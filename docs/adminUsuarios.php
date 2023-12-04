<?php
    require "adminCabecera.php";
    require_once "sesion.php";
    require_once "bd.php";
    comprobar_sesion();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST["opcion"])) {
            $opcion = $_POST["opcion"];
            switch ($opcion) {
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

    $usuarios = mostarUsuarios(); // Función ficticia para obtener la lista de usuarios

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: auto;
            
            border-collapse: collapse;
            margin-bottom: 20px;
			text-align: left;
        } th, td { border: 1px solid #ddd;padding: 5px;}
    </style>
</head>

<body>
    <h2> Gestión de usuarios</h2>

    <!-- Formulario para añadir nuevo usuario -->
    <h3> Creación de usuarios</h3>
    <form action="adminUsuarios.php" method="POST">
        <input type="hidden" name="opcion" value="crear">
        <label for="idUsuario">ID Usuario:</label>
        <input type="text" name="idUsuario" id="idUsuario">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre">
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos">
        <label for="clave">Clave:</label>
        <input type="password" name="clave" id="clave">
        <label for="descRol">Descripción de rol:</label>
        <select name="descRol" id="descRol">
            <option value="Administrador">Administrador</option>
            <option value="Cliente">Cliente</option>
        </select>
        <label for="correo">Correo:</label>
        <input type="text" name="correo" id="correo">
        <label for="fechaNac">Fecha de nacimiento:</label>
        <input type="date" name="fechaNac" id="fechaNac">
        <input type="submit" value="Crear usuario">
    </form>

    <!-- Tabla con la información de usuarios y botones para eliminar -->
    <h3> Lista de usuarios</h3>
    <table>
        <tr>
            <th>ID Usuario</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Clave</th>
            <th>Descripción de Rol</th>
            <th>Correo</th>
            <th>Fecha de Nacimiento</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $usuario) : ?>
            <tr>
                <td><?= $usuario['IdUsuario'] ?></td>
                <td><?= $usuario['NombreUsuario'] ?></td>
                <td><?= $usuario['ApellidoUsuario'] ?></td>
                <td><?= $usuario['Clave'] ?></td>
                <td><?= $usuario['DescripcionRol'] ?></td>
                <td><?= $usuario['Correo'] ?></td>
                <td><?= $usuario['FechaNac'] ?></td>
                <?php if (($usuario['DescripcionRol'] == "Administrador" && $usuario['IdUsuario'] != $_SESSION['usuario'])) { ?>
                <td>
                    <form action="adminUsuarios.php" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar este usuario? Se eliminarán todo sus pedidos.');">
                        <input type="hidden" name="opcion" value="eliminar">
                        <input type="hidden" name="idUsuario" value="<?= $usuario['IdUsuario'] ?>">
                        <input type="submit" value="Eliminar usuario">
                    </form>
                </td>
                <?php } ?>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
