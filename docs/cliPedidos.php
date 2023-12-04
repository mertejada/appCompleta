<?php
    require "cliCabecera.php";
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
    <h2> Tus pedidos </h2>
    <table>
        <tr>
            <th>IdPedido</th>
            <th>IdUsuario</th>
            <th>Fecha</th>
            <th>Estado del pedido</th>
        </tr>
        <?php
            $pedidos = mostrarPedidosCliente($_SESSION['usuario']);
            if($pedidos === FALSE){
                echo "<p>No hay ningún pedido para gestionar</p>";
                exit;
            }


            if($pedidos === FALSE){
                echo "<p>No hay ningún pedido para gestionar</p>";
                exit;
            }
            
            foreach($pedidos as $pedido){ 
                $codPedido = $pedido['CodPedido'];
                $idUsuario = $pedido['IdUsuario'];
                $fecha = $pedido['Fecha'];
                $enviado = $pedido['Enviado'];
                $recibido = $pedido['Recibido'];

                $estado = "";

                if($enviado == 1){
                    $estado = "Enviado";
                    if($recibido == 1){
                        $estado = "Recibido";
                    }
                }else{
                    $estado = "Pendiente de envío";
                }

                
                ?>

                <tr>
                    <td><?= $codPedido ?></td>
                    <td><?= $idUsuario ?></td>
                    <td><?= $fecha ?></td>
                    <td><?= $estado ?></td>
                </tr>


        <?php } ?>
    
</body>
</html>