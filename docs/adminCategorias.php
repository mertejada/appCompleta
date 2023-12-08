<?php
require "adminCabecera.php";
require_once "sesion.php";
require_once "bd.php";
comprobar_sesion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["opcion"])) {
        $opcion = $_POST['opcion'];
        if($opcion == "crear"){
            $nomCat = $_POST["nomCat"];
            $descripcionCat = $_POST["descripcionCat"];
            crearCategoria($nomCat, $descripcionCat);
        }else if($opcion == "eliminar"){
            $codCat = $_POST["codCat"];
            eliminarCategoria($codCat);
        }
    }
}

// Obtener la lista de categorías
$categorias = mostrarCategorias();
if ($categorias === false) {
    $error= "No hay ninguna categoría para gestionar.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
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
    <h2>Gestión de categorías</h2>

    <h4>Creación de categorías</h4>
    <form action="adminCategorias.php" method="POST">
        <input type="hidden" name="opcion" value="crear">
        <label for="nomCat">Nombre de la categoría:</label>
        <input type="text" name="nomCat" id="nomCat" required>
        <br>
        <label for="descripcionCat">Descripción de la categoría:</label>
        <input type="text" name="descripcionCat" id="descripcionCat" required>
        <br>
        <input type="submit" value="Crear">
    </form>

    <h4>Categorías</h4>
    <?php if ($categorias !== false) { ?>
        <table>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Eliminar</th>
            </tr>
            <?php foreach ($categorias as $cat) { ?>
                <tr>
                    <td><?= $cat['CodCat'] ?></td>
                    <td><?= $cat['NomCat'] ?></td>
                    <td><?= $cat['DescripcionCat'] ?></td>
                    <td>
                        <form action="adminCategorias.php" method="POST" onsubmit="return confirm('¿Estás seguro de querer eliminar esta categoría? Se eliminarán todo sus productos.');">
                            <input type="hidden" name="opcion" value="eliminar">
                            <input type="hidden" name="codCat" value="<?= $cat['CodCat'] ?>">
                            <input type="submit" value="Eliminar">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } if(isset($error)) {echo $error;}?>
</body>
</html>
