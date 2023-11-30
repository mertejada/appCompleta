<?php
    require_once "bd.php";
    require "sesion.php";
    require "cliCabecera.php";
    comprobar_sesion();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Lista de Categorías</h3>
    <?php
		$categorias = mostrarListaCategorias();
		if($categorias===false){
			echo "<p class='error'>ERROR: Se ha producido un error al mostrar las categorías</p>";
		}else{
			echo "<ul>";
			foreach($categorias as $cat){		
				$url = "cliProductos.php?categoria=".$cat['CodCat'];
				echo "<li><a href='$url'>".$cat['NomCat']."</a></li>";
			}
			echo "</ul>";
		}
		?>
    
</body>
</html>