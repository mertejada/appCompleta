<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de productos por categoría</title>
    <style>
        table {
            width: auto + 10px;
            border-collapse: collapse;
            margin-bottom: 20px;
			text-align: left;
        } th, td { border: 1px solid #ddd;padding: 5px;}
    </style>
</head>
<body>
    <?php
        /*comprueba que el usuario haya abierto sesión o redirige*/
        require 'sesion.php';
        require_once 'bd.php';
        require 'cliCabecera.php';
        comprobar_sesion();

        $categoria = mostrarInformacionCategoria($_GET['categoria']);
        $codCat = $_GET['categoria'];

        // Verifica si la categoría existe antes de mostrar la información
        if($categoria === FALSE){
            echo "<p class='error'>Error al conectar con la base de datos</p>";
            exit;
        }

        echo "<h3>Productos de la categoría: ".$categoria['NomCat']."</h3>";
        echo "<h4>".$categoria['DescripcionCat']."</h4>";

        $listaProductos = mostrarListaProductos($_GET['categoria']);
        if($listaProductos === FALSE){
            echo "Lo sentimos. Aún no existen productos para esta categoría.
            <a href='cliCategorias.php'>Volver a categorías</a>";
            exit;
        }
    ?>
    
    <table>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
			<th>Peso</th>
            <th>Comprar</th>
        </tr>

        <?php foreach ($listaProductos as $producto) { 
			$codProd = $producto['CodProd'];
			$nomProd = $producto['NomProd'];
			$desProd = $producto['DescripcionProd'];
			$precioProd = $producto['PrecioProd'];
			$stockProd = $producto['Stock'];
			$pesoProd = $producto['PesoProd'];
			$codCat = $producto['CodCat'];

            if($stockProd >= 1){
			?>
            <tr>
                <td><?php echo $nomProd; ?></td>
                <td><?php echo $desProd; ?></td>
                <td><?php echo $precioProd; ?>€</td>
                <td><?php echo $stockProd; ?></td>
				<td><?php echo $pesoProd; ?></td>
                <td>
                    <form action="cliAnadir.php" method="POST">
                        <input type="hidden" name="codProd" value="<?php echo $codProd; ?>">
                        <input name='unidades' type='number' min='1' value="1" max='<?php echo $stockProd; ?>'>
                        <input name='codCat' type='hidden' value='<?php echo $codCat ?>'>
						<input type='submit' value='Añadir'>
                    </form>
                </td>
            </tr>
        <?php } } ?>
    </table>
</body>
</html>
