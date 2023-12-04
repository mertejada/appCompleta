<?php
    require_once 'bd.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $idUsuario = $_POST['idUsuario'];
        $clave = $_POST['clave'];

        /*
        $iniciarComoAministrador = false;

        if(isset($_POST['iniciarComoAministrador'])){
            $iniciarComoAministrador = true;
        }

        if($iniciarComoAministrador){
            if(comprobarAdmin($idUsuario, $clave)){
                session_start();
                $_SESSION['usuario'] = $idUsuario;
		        $_SESSION['carrito'] = [];
                header('Location: indexAdmin.php');
            }elseif(comprobarUsuario($idUsuario, $clave)){
                $err = "No tienes permisos de administrador";
            }else{
                $err = "Tu nombre de usuario o contraseña no son correctos.";
            }
        }else{
            if(comprobarUsuario($idUsuario, $clave)){
                session_start();
                $_SESSION['usuario'] = $idUsuario;
                $_SESSION['carrito'] = [];
                header('Location: indexCliente.php');
            }else{
                $err = "Tu nombre de usuario o contraseña no son correctos.";
            }
        
        }*/

        if(comprobarUsuario($idUsuario, $clave)){
            if(comprobarAdmin($idUsuario, $clave)){
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
            $err = "Tu nombre de usuario o contraseña no son correctos.";
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
    <form action="login.php" method="post">
        <div>
            <label for="IdUsuario">Nombre de usuario</label>
            <input type="text" name="idUsuario" placeholder="Usuario" require>
        </div>
        <div>
        <label for="password">Clave</label>
        <input type="password" name="clave" placeholder="Clave" require>
        </div>

        <!--<div>
        <label for="iniciarComoAministrador">Admin</label>
        <input type="checkbox" name="iniciarComoAministrador" id="iniciarComoAministrador">
        </div><-->
        <div>
        <input type="submit" value="Ingresar">
        </div>
        <div>
        <!--<input type="submit" name="registro" value="Registrarse"> Si me da tiempo <-->
        </div>
    </form>

    <?php if(isset($err)){ echo "<p>$err</p>";} ?>
    
</body>
</html>