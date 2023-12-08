<?php
require "adminCabecera.php";
require "sesion.php";
require_once "bd.php";
comprobar_sesion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["opcion"])) {
        $opcion = $_POST["opcion"];
        switch ($opcion) {
            case "crear":
                $nomProd = $_POST["nomProd"];
                $descripcionProd = $_POST["descripcionProd"];
                $stock = $_POST["stock"];
                $precioProd = $_POST["precioProd"];
                $pesoProd = $_POST["pesoProd"];
                $codCat = $_POST["codCat"];
                crearProducto($nomProd, $descripcionProd, $stock, $precioProd, $pesoProd, $codCat);
                break;

            case "eliminar":
                $codProd = $_POST["codProd"];
                eliminarProducto($codProd);
                break;

            case "modificar":
                $codProd = $_POST["codProd"];
                $stock = $_POST["stock"];
                modificarStock($codProd, $stock);
                break;
        }
    }
}

$productos = mostrarProductosGestion(); // puedo bor
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de productos</title>
    <style>
        table {
            width: auto;
            border-collapse: collapse;
            margin-bottom: 20px;
            text-align: left;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h2>Gestión de productos</h2>

    <h3>Creación de productos</h3>
    <form action="adminProductos.php" method="POST">
        <input type="hidden" name="opcion" value="crear">
        <label for="nomProd">Nombre del producto:</label>
        <input type="text" name="nomProd" id="nomProd" required>
        <br>
        <label for="descripcionProd">Descripción del producto:</label>
        <input type="text" name="descripcionProd" id="descripcionProd" required>
        <br>
        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" min= 0 required> 
        <br>
        <label for="precioProd">Precio del producto:</label>
        <input type="number" step="0.01" name="precioProd" id="precioProd" required>
        <br>
        <label for="pesoProd">Peso del producto (kg):</label>
        <input type="number" step="0.01" name="pesoProd" id="pesoProd" required>
        <br>
        <label for="codCat">Categoría:</label>
        <select name="codCat" id="codCat">
            <?php
            $categorias = mostrarListaCategorias();
            foreach ($categorias as $cat) {
                echo "<option value='" . $cat['CodCat'] . "'>" . $cat['NomCat'] . "</option>";
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Crear">
    </form>

    <h3>Eliminación y Modificación de productos</h3>
    <?php if ($productos !== false) { ?>
        <table>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Código de categoría</th>
                <th>Descripción</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Peso (kg)</th>
                <th>Eliminar producto</th>
            </tr>
            <?php foreach ($productos as $prod) { ?>
                <tr>
                    <td><?= $prod['CodProd'] ?></td>
                    <td><?= $prod['NomProd'] ?></td>
                    <td><?= $prod['CodCat'] ?></td>
                    <td><?= $prod['DescripcionProd'] ?></td>
                    <td>
                        <form action="adminProductos.php" method="POST">
                            <input type="hidden" name="opcion" value="modificar">
                            <input type="hidden" name="codProd" value="<?= $prod['CodProd'] ?>">
                            <input type="number" name="stock" value="<?= $prod['Stock'] ?>" min=0>
                            <input type="submit" value="Actualizar">
                        </form>
                    </td>
                    <td><?= $prod['PrecioProd'] ?></td>
                    <td><?= $prod['PesoProd'] ?></td>
                    <td>
                        <form action="adminProductos.php" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar este producto?');">
                            <input type="hidden" name="opcion" value="eliminar">
                            <input type="hidden" name="codProd" value="<?= $prod['CodProd'] ?>">
                            <input type="submit" value="Eliminar">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else {
        echo "No hay productos para mostrar.";
    } ?>
</body>

</html>
