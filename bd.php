<?php 
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