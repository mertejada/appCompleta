<?php 
	require_once 'sesion.php';
	require_once 'bd.php';
    require 'cliCabecera.php';
	comprobar_sesion();

    if (isset($_POST['Vaciar'])) {
        unset($_SESSION['carrito']);
        $_SESSION['carrito'] = [];
        header ("Location: cliCarrito.php");
    }

    if (isset($_POST['RealizarPedido'])) {
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Carrito de la compra</title>	
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
		<?php 
            $codigosProductos = array_keys($_SESSION['carrito']);
            $prodCarrito = mostrarProductos($codigosProductos);
            if ($prodCarrito === FALSE) {
                echo "<p>No hay productos en el carrito. ¡Navega para hacer compras!</p>";
                exit;
                
            }?>

            <table>
                <tr>
                    <th>Productos</th>
                    <th>Precio (€)</th>
                    <th>Unidades</th>
                </tr>

                <?php
                
                $precioPedido = 0;
                $pesoPedido = 0;

                foreach($prodCarrito as $producto){
                    $codProd = $producto['CodProd'];
                    $nomProd = $producto['NomProd'];
                    $precioProd = $producto['PrecioProd'];
                    $pesoProd = $producto['PesoProd'];
                    $codCat = $producto['CodCat'];
                    $unidades = $_SESSION['carrito'][$codProd];
                    $precioPedido += $precioProd * $unidades;
                    $pesoPedido += $pesoProd * $unidades;
                    ?>
                    <tr>
                        <td><?php echo $nomProd; ?></td>
                        <td><?php echo $precioProd."€"; ?></td>
                        <td><?php echo $unidades; ?></td>
                    </tr>
                    <table>
                    <?php
                    
                }

                echo "<p>Precio total del pedido: $precioPedido €</p>";
            

            

            
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
