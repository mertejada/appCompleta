<?php
    require_once 'bd.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $idUsuario = $_POST['idUsuario'];
        $clave = $_POST['clave'];

        if(comprobarUsuario($idUsuario, $clave)){
            if(comprobarAdmin($idUsuario)){
                session_start();
                $_SESSION['usuario'] = $idUsuario;
                header('Location: indexAdmin.php');
            }else{
                session_start();
                $_SESSION['usuario'] = $idUsuario;
                $_SESSION['carrito'] = [];
                header('Location: indexCliente.php');
            }
        }else{
            $err = "<b><span style='color: red;'>Tu nombre de usuario o contraseña no son correctos.</span></b>";
        }

        if(isset($_POST['registro'])){
            header('Location: registro.php');
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
    <h2>Bienvenido a Nebula</h2>
    <?php  if(isset($_GET['registro'])){ echo "<h5>¡Registro realizado con éxito! Inicie sesión con su cuenta.</h5>";} 
    if(isset($_GET['redirigido'])){ echo "<h5>Debe iniciar sesión para continuar.</h5>";} ?>
    <form action="login.php" method="post">
        <div>
            <label for="IdUsuario">Nombre de usuario</label>
            <input type="text" name="idUsuario" placeholder="Usuario" require>
        </div>
        <div>
        <label for="password">Clave</label>
        <input type="password" name="clave" placeholder="Clave" require>
        </div><br>

        <div>
        <input type="submit" value="Ingresar">
        <input type="submit" name="registro" value="Registrarse">
        </div>
    </form>

    <?php if(isset($err)){ echo "<p>$err</p>";} ?>
    
</body>
</html>