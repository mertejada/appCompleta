<?php
    require "adminCabecera.php";
    require "sesion.php";
    require_once "bd.php";
    comprobar_sesion();

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
        $codPedido = $_POST['codPedido'];

        if($accion == "marcarEnviado"){
            marcarPedidoEnviado($codPedido);
        }else if($accion == "eliminar"){
            eliminarPedido($codPedido);

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
            width: auto + 10px;
            border-collapse: collapse;
            margin-bottom: 20px;
			text-align: left;
        } th, td { border: 1px solid #ddd;padding: 5px;}
    </style>
</head>
<body>
    <h2> Gestión de pedidos </h2>
    <table>
        <tr>
            <th>IdPedido</th>
            <th>IdUsuario</th>
            <th>Fecha</th>
            <th>Enviado</th>
            <th>Acciones</th>
        </tr>
        <?php
            $pedidos = mostrarPedidos();

            if($pedidos === FALSE){
                echo "<p>No hay ningún pedido para gestionar</p>";
                exit;
            }
            
            foreach($pedidos as $pedido){ 
                $codPedido = $pedido['CodPedido'];
                $idUsuario = $pedido['IdUsuario'];
                $fecha = $pedido['Fecha'];
                $enviado = $pedido['Enviado'];

                if($enviado == 0){
                    $enviado = "No";
                }else{
                    $enviado = "Si";
                }

                
                ?>

                <tr>
                    <td><?= $codPedido ?></td>
                    <td><?= $idUsuario ?></td>
                    <td><?= $fecha ?></td>
                    <td><?= $enviado ?></td>
                    <td><form action="adminPedidos.php" method="post">
                        <select name="accion">
                            <option value="marcarEnviado">Marcar como enviado</option>
                            <option value="eliminar">Eliminar pedido</option>
                        </select>
                        <input type="hidden" name="codPedido" value="<?= $codPedido ?>">
                        <input type="submit" value="Confirmar">
                    </form>
                    </td>
                </tr>


        <?php } ?>
    
</body>
</html>