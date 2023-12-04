<?php 
	require_once 'sesion.php';
	require_once 'bd.php';
    require 'cliCabecera.php';
	comprobar_sesion();

    

    if (isset($_POST['modificar'])) {
        $codProd = $_POST['codProd'];
        $unidades = $_POST['unidades'];
        $_SESSION['carrito'][$codProd] = $unidades;
        header ("Location: cliCarrito.php");
    }

    if(isset($_POST['eliminar'])){
        $codProd = $_POST['codProd'];
        unset($_SESSION['carrito'][$codProd]);
        header ("Location: cliCarrito.php");
    }

    if (isset($_POST['Vaciar'])) {
        unset($_SESSION['carrito']);
        $_SESSION['carrito'] = [];
        header ("Location: cliCarrito.php");
    }

    if (isset($_POST['realizarPedido'])) {
        header ("Location: cliProcesarPedido.php");
    }

    if(isset($_GET['comprarealizada'])){
        echo "<h2><span style='color: green;'>¡Gracias por su compra!</span></h2>";

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
        <h2>Tu carrito</h2>

        

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
                    <th>Subtotal(Producto)</th>
                    <th>Eliminar</th>
                </tr>

                <?php
                
                $subtotalPedido = 0;
                $pesoPedido = 0;
                $precioPedido = 5;

                foreach($prodCarrito as $producto){
                    $codProd = $producto['CodProd'];
                    $nomProd = $producto['NomProd'];
                    $precioProd = $producto['PrecioProd'];
                    $pesoProd = $producto['PesoProd'];
                    $codCat = $producto['CodCat'];
                    $unidades = $_SESSION['carrito'][$codProd];
                    $subtotalPedido += $precioProd * $unidades;
                    $pesoPedido += $pesoProd * $unidades;
                    ?>

                    <tr>
                        <td><?php echo $nomProd; ?></td>
                        <td><?php echo $precioProd."€"; ?></td>
                        <td><form method= POST action=cliCarrito.php>
                            <input type="hidden" name="codProd" value="<?php echo $codProd; ?>">
                            <input type="number" name="unidades" min="1" value="<?php echo $unidades; ?>">
                            <input type="submit" name="modificar" value="Modificar"></form>
                        </td>
                        <td><?php echo $precioProd * $unidades."€"; ?></td>
                        <td><form method= POST action=cliCarrito.php>
                            <input type="hidden" name="codProd" value="<?php echo $codProd; ?>">
                            <input type="submit" name="eliminar" value="Eliminar"></form>
                        </td>
                    </tr>
                    
                <?php } 
                
                if($subtotalPedido > 50){
                    $precioPedido = $subtotalPedido;}
                ?>  
                
                <tr><td><b>Subtotal: </b><?php echo $subtotalPedido."€";?> </td></tr>
                <tr><td><b>Total del pedido: </b><?php echo $precioPedido."€";?> </td></tr>
                <tr><td><b>Peso del pedido: </b><?php echo $pesoPedido."kg";?> </td></tr>
                <table><hr>
                <b><i>El envío es gratuito para pedidos superiores a 50€. Si no, el precio de envío será de 5€</i></b><br><hr>

		<form action="cliCarrito.php" method="POST">
            <label for="realizarPedido"></label>
            <input type="submit" name="realizarPedido" value="Realizar pedido">
            <label for="Vaciar"></label>
            <input type="submit" name="Vaciar" value="Vaciar">
        </form>	

	</body>
</html>
