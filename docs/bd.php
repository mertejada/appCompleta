<?php 

//FUNCIONES DE CONEXION CON LA BASE DE DATOS 
function leer_config($nombre, $esquema){
	$config = new DOMDocument();
	$config->load($nombre);
	$res = $config->schemaValidate($esquema);
	if ($res===FALSE){ 
	   throw new InvalidArgumentException("Revise fichero de configuración");
	} 		
	$datos = simplexml_load_file($nombre);	
	$ip = $datos->xpath("//ip");
	$nombre = $datos->xpath("//nombre");
	$usu = $datos->xpath("//usuario");
	$clave = $datos->xpath("//clave");	
	$cad = sprintf("mysql:dbname=%s;host=%s", $nombre[0], $ip[0]);
	$resul = [];
	$resul[] = $cad;
	$resul[] = $usu[0];
	$resul[] = $clave[0];
	return $resul;
}

function conectarBD(){
    try{
        $datos = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($datos[0], $datos[1], $datos[2]);
        return $bd;
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
}

//FUNCIONES DE USUARIOS:

function mostrarUsuarios(){
    $bd = conectarBD();
    $sql = "SELECT * FROM usuarios";

    $stmt = $bd->prepare($sql);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$res){
        return false;
    }
    if(count($res) === 0){
        return false;
    }
    return $res;
}
function comprobarUsuario($idUsuario, $clave) {
    $bd = conectarBD();
    $sql = "SELECT Clave FROM usuarios WHERE IdUsuario = :idUsuario";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->execute();

    $hashedPassword = $stmt->fetchColumn();

    if ($hashedPassword && password_verify($clave, $hashedPassword)) {
        return true;
    } else {
        return false;
    }
}

function comprobarAdmin($idUsuario){
    $bd = conectarBD();
    $sql = "SELECT * FROM usuarios WHERE IdUsuario = :idUsuario AND CodRol = 1";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($res) == 1){
        return true;
    }else{
        return false;
    }
}


//FUNCIONES DE GESTION DEL ADMINISTRADOR
//FUNCIONES DE GESTION DE USUARIOS
function crearUsuario($idUsuario, $nombre, $apellido, $clave, $descRol, $correo, $fechaNac){
    $bd = conectarBD();
    
    if($descRol == "Admin"){
        $codRol = 1;
    }else{
        $codRol = 0;
    }

    $claveEncriptada = password_hash($clave, PASSWORD_BCRYPT, ['cost' => 4]);
    $sql = "INSERT INTO usuarios 
            VALUES (:idUsuario, :nombre, :apellido, :clave, :codRol, :descRol, :correo, :fechaNac)";
    
    try {
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':clave', $claveEncriptada);
        $stmt->bindParam(':codRol', $codRol);
        $stmt->bindParam(':descRol', $descRol);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':fechaNac', $fechaNac);
        $stmt->execute();

        //devuelve true si se ha creado correctamente
        return true;
        
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) { // es un codigo de error específico para clave duplicada
            echo '<span style="color: red;">Ya existe ese nombre de usuario. Por favor, inténtelo de nuevo, </span>';
        } else {
            echo '<span style="color: red;">Algo salió mal. Por favor, inténtelo de nuevo.</span>';
            // Log del error (puedes registrar el error en un archivo de registro, base de datos, etc.)
            error_log($e->getMessage());
        }
    }
}

function eliminarUsuario($idUsuario){
    $bd = conectarBD();
    try {
        $bd->beginTransaction();

        $stmt = $bd->prepare("DELETE FROM pedidosproductos WHERE CodPedido IN (SELECT CodPedido FROM pedidos WHERE IdUsuario = :idUsuario)");
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        $stmt = $bd->prepare("DELETE FROM pedidos WHERE IdUsuario = :idUsuario");
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        $stmt = $bd->prepare("DELETE FROM usuarios WHERE IdUsuario = :idUsuario");
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        $bd->commit();
    } catch (PDOException $e) {
        $bd->rollBack();
    }
}

//FUNCIONES DE GESTION DE CATEGORIAS
function mostrarCategorias(){
    $bd = conectarBD();
    $sql = "SELECT * FROM categorias";

    $stmt = $bd->prepare($sql);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$res){
        return false;
    }
    if(count($res) === 0){
        return false;
    }
    return $res;
}
function crearCategoria($nomCat, $descripcionCat){
    $bd = conectarBD();

    $sql = "INSERT INTO categorias (nomCat, descripcionCat) VALUES (:nomCat, :descripcionCat)";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':nomCat', $nomCat);
    $stmt->bindParam(':descripcionCat', $descripcionCat);
    $stmt->execute();

    
}

function eliminarCategoria($codCat){
    $bd = conectarBD();

    try {
        $bd->beginTransaction();

        $stmt = $bd->prepare("DELETE FROM productos WHERE CodCat = :codCat");
        $stmt->bindParam(':codCat', $codCat);
        $stmt->execute();

        $stmt = $bd->prepare("DELETE FROM categorias WHERE CodCat = :codCat"); // TRUNCATE para que el autoincremental del codigo se reinicie
        $stmt->bindParam(':codCat', $codCat);
        $stmt->execute();

        $bd->commit();
    } catch (PDOException $e) {
        $bd->rollBack();
        echo '<span style="color: red;">ERROR: Compruebe que no haya ningún pedido en el que se encuentre este producto.</span>';
    }
}

//FUNCIONES DE GESTION DE PRODUCTOS
//No hace falta el codProd porque es autoincremental en la BD
function mostrarProductosGestion(){
    $bd = conectarBD();
    $sql = "SELECT * FROM productos";

    $stmt = $bd->prepare($sql);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$res){
        return false;
    }
    if(count($res) === 0){
        return false;
    }
    return $res;
}
function crearProducto($nomProd, $descripcionProd, $stock, $precioProd, $pesoProd, $codCat){
    $bd = conectarBD();
    $sql = "INSERT INTO productos (nomProd, descripcionProd, stock, precioProd, pesoProd, codCat) VALUES (:nomProd, :descripcionProd, :stock, :precioProd, :pesoProd, :codCat)";


    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':nomProd', $nomProd);
    $stmt->bindParam(':descripcionProd', $descripcionProd);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':precioProd', $precioProd);
    $stmt->bindParam(':pesoProd', $pesoProd);
    $stmt->bindParam(':codCat', $codCat);
    $stmt->execute();
}

function eliminarProducto($codProd){
    $bd = conectarBD();
    try{
        $sql = "DELETE FROM productos WHERE CodProd = :codProd";

        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':codProd', $codProd);
        $stmt->execute();
    }catch(PDOException $e){
        if($e->errorInfo[1] == 1451){
            echo '<span style="color: red;">ERROR: Compruebe que no haya ningún pedido en el que se encuentre este producto.</span>';
        }else{
            echo '<span style="color: red;">Algo salió mal. Por favor, inténtelo de nuevo.</span>';
        }
    }
    
}

function modificarStock($codProd, $stock){
    $bd = conectarBD();
    $sql = "UPDATE productos SET stock = :stock WHERE CodProd = :codProd";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':codProd', $codProd);
    $stmt->execute();
}

//FUNCIONES DE GESTION DE PEDIDOS
function mostrarPedidos(){
    $bd = conectarBD();
    $sql = "SELECT * FROM pedidos";

    $stmt = $bd->prepare($sql);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$res){
        return false;
    }
    if(count($res) === 0){
        return false;
    }
    return $res;
}

function marcarPedidoEnviado($codPedido){
    $bd = conectarBD();
    $sql = "UPDATE pedidos SET Enviado = 1 WHERE CodPedido = :codPedido";
    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':codPedido', $codPedido);
    $stmt->execute();

    if(!$stmt){
        return false;
    }

    return true;
}


function marcarPedidoRecibido($codPedido){
    $bd = conectarBD();
    $sql = "UPDATE pedidos SET Recibido = 1 WHERE CodPedido = :codPedido";
    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':codPedido', $codPedido);
    $stmt->execute();

    if(!$stmt){
        return false;
    }

    return true;
}

function eliminarPedido($codPedido){
    $bd = conectarBD();
    $bd->beginTransaction();	

    try {
        $sql = "DELETE FROM pedidosproductos WHERE CodPedido = :codPedido";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':codPedido', $codPedido);
        $stmt->execute();

        $sql1 = "DELETE FROM pedidos WHERE CodPedido = :codPedido";
        $stmt1 = $bd->prepare($sql1);
        $stmt1->bindParam(':codPedido', $codPedido);
        $stmt1->execute();

        $bd->commit();
        return true;
    } catch (PDOException $e) {
        $bd->rollback();
        echo "Error al eliminar el pedido: " . $e->getMessage();
        return false;
    }
}


//FUNCIONES DE CLIENTE
function mostrarListaCategorias(){
    $bd = conectarBD();
    $sql = "SELECT NomCat, CodCat FROM categorias";

    $stmt = $bd->prepare($sql);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC); // uso fetchAll porque espero varias filas

    if (!$res) {
		return FALSE;
	}
	if (count($res) === 0) {
        return FALSE;
    }
	return $res;	
}

function mostrarInformacionCategoria($codCat){
    $bd = conectarBD();
    $sql = "SELECT NomCat, DescripcionCat FROM categorias WHERE CodCat = :codCat";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':codCat', $codCat);
    $stmt->execute();

    $res = $stmt->fetch(PDO::FETCH_ASSOC); //uso fetch porque solo espero una fila

    if (!$res) {
		return FALSE;
	}
	if (count($res) === 0) {
        return FALSE;
    }
    return $res;
}

function mostrarListaProductos($codCat){
    $bd = conectarBD();
    $sql = "SELECT * FROM productos WHERE codCat = :codCat";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':codCat', $codCat);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$res){
        return false;
    }
    if(count($res) === 0){
        return false;
    }
    return $res;
}

function mostrarProductos($codigosProductos){
    $bd = conectarBD();
    
    // Crear marcadores de posición según la cantidad de códigos de productos
    if(count($codigosProductos) === 0){
        return false;
    }
    $marcadores = implode(',', array_fill(0, count($codigosProductos), '?'));

    $sql = "SELECT * FROM productos WHERE CodProd IN ($marcadores)";

    $stmt = $bd->prepare($sql);
    $stmt->execute($codigosProductos); // Pasa los códigos de productos como un array

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$res || count($res) === 0){
        return false;
    }

    return $res;
}

function obtenerStock($codProd){
    $bd = conectarBD();
    $sql = "SELECT stock FROM productos WHERE CodProd = :codProd";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':codProd', $codProd);
    $stmt->execute();

    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    return $res['stock'];
}


function realizarPedido($carrito, $idUsuario){
    $bd = conectarBD();
    $bd->beginTransaction();	
    $fechaEnvio = date("Y-m-d H:i:s", time());

    // insertar el pedido
    $sql = "INSERT INTO pedidos(Enviado, IdUsuario, Fecha) 
            VALUES(0, :idUsuario, :fechaEnvio)";
    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':fechaEnvio', $fechaEnvio);
    $stmt->execute();

    if (!$stmt) {
        $bd->rollback();
        return FALSE;
    }
    $pedido = $bd->lastInsertId();

    foreach($carrito as $codProd => $unidades){
        $sql = "INSERT INTO pedidosproductos(CodProd, CodPedido, Unidades) 
                VALUES(:codProd, :pedido, :unidades)";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':codProd', $codProd);
        $stmt->bindParam(':pedido', $pedido);
        $stmt->bindParam(':unidades', $unidades);
        $stmt->execute();

        $sql1 = "UPDATE productos SET stock=stock-$unidades WHERE codProd=:codProd";
        $stmt1 = $bd->prepare($sql1);
        $stmt1->bindParam(':codProd', $codProd);
        $stmt1->execute();

        if (!$stmt || !$stmt1) {
            $bd->rollback();
            return FALSE;
        }
    }
    $bd->commit();
    return $pedido;
}

function mostrarPedidosCliente($idUsuario){
    $bd = conectarBD();
    try{
        $sql = "SELECT * FROM pedidos WHERE IdUsuario = :idUsuario";

        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$res){
            return false;
        }
        if(count($res) === 0){
            return false;
        }
        return $res;

    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
    
}

function listaProductosPedido($codPedido){
    $bd = conectarBD();
    $sql = "SELECT * FROM pedidosproductos WHERE CodPedido = :codPedido";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':codPedido', $codPedido);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$res){
        return false;
    }
    if(count($res) === 0){
        return false;
    }
    return $res;
}

function nombreProducto($codPedido){
    $bd = conectarBD();
    $sql = "SELECT NomProd FROM productos WHERE CodProd = :codPedido";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':codPedido', $codPedido);
    $stmt->execute();

    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$res){
        return false;
    }
    if(count($res) === 0){
        return false;
    }
    return $res['NomProd'];

}




