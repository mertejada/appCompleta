<?php
    require 'sesion.php';
    require_once 'bd.php';
    require 'cliCabecera.php';
    comprobar_sesion();


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['idUsuario'], $_POST['clave'])){
            $idUsuario = $_POST['idUsuario'];
            $clave = $_POST['clave'];

        if($_SESSION['usuario'] == $idUsuario && comprobarUsuario($idUsuario, $clave)){
            $confirmacion = true;
            $mensaje = "Puede continuar con su pedido";
        }else{
            $mensaje = "<b>Lo sentimos,sus credenciales no son correctas.</b> <a href='cliCarrito.php'>Volver al carrito</a>";
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
<h2>Procesamiento de pedido</h2>
    <?php 

    if(!isset($idUsuario, $clave)){
        echo "<p>Debe acreditar su credenciales de nuevo por motivos de seguridad.</p>";?>
    
        <form action="cliProcesarPedido.php" method="post">
            <div>
                <label for="IdUsuario">Nombre de usuario</label>
                <input type="text" name="idUsuario" placeholder="Usuario" require>
            </div>
            <div>
            <label for="password">Clave</label>
            <input type="password" name="clave" placeholder="Clave" require>
            </div>

            <div>
            <input type="submit" value="Verificar">
            </div>
        </form>

        <?php } 
    if(isset($mensaje)){
        echo "<p>$mensaje</p>";
    }
    if(isset($confirmacion)){

        $resul = realizarPedido($_SESSION['carrito'], $_SESSION['usuario']);
		$compra=$_SESSION['carrito'];
        
        foreach($compra as $producto){
            $stock = $producto['stock'];
            $stock = $stock - $producto['cantidad'];
            modificarStock($producto['codProd'], $stock);
        }

        $_SESSION['carrito'] = [];
        header('Location: cliCarrito.php?comprarealizada=true');
        echo '<h3><span style="color: green;">¡Gracias por su compra!</span></h3>';
        } ?>
</body>
</html>