<?php
    require 'sesion.php';
    require_once 'bd.php';
    require 'cliCabecera.php';
    comprobar_sesion();


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['idUsuario'], $_POST['clave'])){
            $idUsuario = $_POST['idUsuario'];
            $clave = $_POST['clave'];

            if(comprobarUsuario($idUsuario, $clave)){
                if($_SESSION['usuario'] == $idUsuario){
                    $mensaje= "Puede continuar con su pedido";
                    $confirmacion = true;
            }else{
                $mensaje = "Sus credenciales no son correctas <a href='cliCarrito.php'>Volver al carrito</a>";
            
            }
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
        $productos = mostrarProductos(array_keys($_SESSION['carrito']));

        ?>

        <h2>¡Pedido realizado!</h2>
        <h3>Resumen de la compra</h3>
        <table>
            <tr>
                <th>Producto</th>
                <th>Unidades</th>
            </tr>

        <?php
		foreach ($productos as $producto) {
			$cod=$producto['CodProd'];
			$nom=$producto['NomProd'];	
			$unidades=$_SESSION['carrito'][$cod];
		}

        $_SESSION['carrito'] = [];
        header('Location: indexCliente.php');
        ?>

        <tr>
            <td><?= $nom ?></td>
            <td><?= $unidades ?></td>
        </tr>
        <table>

        <?php } ?>
</body>
</html>