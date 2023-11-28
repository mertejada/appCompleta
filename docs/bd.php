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

//FUNCIONES DE LOGIN:
function comprobarUsuario($idUsuario, $clave){
    $bd = conectarBD();
    $sql = "SELECT * FROM usuarios WHERE IdUsuario = :idUsuario AND Clave = :clave";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario); //bindParam vincula el parametro con la variable
    $stmt->bindParam(':clave', $clave);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll devuelve un array con todas las filas coincidentes
    if(count($res) == 1){
        return true;
    }else{
        return false;
    }
}

function comprobarAdmin($idUsuario, $clave){
    $bd = conectarBD();
    $sql = "SELECT * FROM usuarios WHERE IdUsuario = :idUsuario AND Clave = :clave AND CodRol = 1";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':clave', $clave);
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
    if($descRol == "Administrador"){
        $codRol = 1;
    }else{
        $codRol = 0;
    }

    $sql = "INSERT INTO usuarios VALUES (:idUsuario, :nombre, :apellido, :clave, :codRol, :descRol, :correo, :fechaNac)";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':clave', $clave);
    $stmt->bindParam(':codRol', $codRol);
    $stmt->bindParam(':descRol', $descRol);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':fechaNac', $fechaNac);
    $stmt->execute();
}

function eliminarUsuario($idUsuario){
    $bd = conectarBD();
    $sql = "DELETE FROM usuarios WHERE IdUsuario = :idUsuario";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario);
    $stmt->execute();
}


//FUNCIONES DE GESTION DE PRODUCTOS
//No hace falta el codProd porque es autoincremental en la BD
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
    $sql = "DELETE FROM productos WHERE CodProd = :codProd";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':codProd', $codProd);
    $stmt->execute();
}

//FUNCIONES DE GESTION DE CATEGORIAS
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
    $sql = "DELETE FROM categorias WHERE CodCat = :codCat";

    $stmt = $bd->prepare($sql);
    $stmt->bindParam(':codCat', $codCat);
    $stmt->execute();
}

//FUNCIONES DE CLIENTE
function mostrarCategorias(){
    $bd = conectarBD();
    $sql = "SELECT * FROM categorias";

    $stmt = $bd->prepare($sql);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}


