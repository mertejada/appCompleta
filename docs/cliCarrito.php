<?php 
	require_once 'sesion.php';
	require_once 'bd.php';
    require 'cliCabecera.php';
	comprobar_sesion();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Carrito de la compra</title>		
	</head>
	<body>
		<?php 
            $codigosProductos = array_keys($_SESSION['carrito']);
            $prodCarrito = mostrarProductos($codigosProductos);
            if ($prodCarrito === FALSE) {
                echo "<p>No hay productos en el carrito</p>";
                
            }

            print_r($prodCarrito);

            if (isset($_POST['Vaciar'])) {
                unset($_SESSION['carrito']);
                $_SESSION['carrito'] = [];
            }

            if (isset($_POST['RealizarPedido'])) {
                // Aquí puedes implementar la lógica para realizar el pedido
            }
        ?>
		<hr>
        
		<form action="cliCarrito.php" method="POST">
            <label for="RealizarPedido"></label>
            <input type="submit" name="RealizarPedido" value="Realizar pedido">
            <label for="Vaciar"></label>
            <input type="submit" name="Vaciar" value="Vaciar">
        </form>	
	</body>
</html>
