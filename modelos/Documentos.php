<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Documentos{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($nombre,$descripcion){
	$sql="INSERT INTO tipo_documentos (nombre,descripcion,condicion) VALUES ('$nombre','$descripcion','1')";
	return ejecutarConsulta($sql);
}

public function editar($iddocumentos,$nombre,$descripcion){
	$sql="UPDATE tipo_documentos SET nombre='$nombre',descripcion='$descripcion' 
	WHERE iddocumentos='$iddocumentos'";
	return ejecutarConsulta($sql);
}
public function desactivar($iddocumentos){
	$sql="UPDATE tipo_documentos SET condicion='0' WHERE iddocumentos='$iddocumentos'";
	return ejecutarConsulta($sql);
}
public function activar($iddocumentos){
	$sql="UPDATE tipo_documentos SET condicion='1' WHERE iddocumentos='$iddocumentos'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($iddocumentos){
	$sql="SELECT * FROM tipo_documentos WHERE iddocumentos='$iddocumentos'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM tipo_documentos";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM tipo_documentos WHERE condicion=1";
	return ejecutarConsulta($sql);
}
}

 ?>
