<?php 
//incluir la conexion de base de datos
//require "../config/Conexion.php";
require_once(dirname(__FILE__,2) . '/config/Conexion.php');
class Cliente{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($nombre,$apellidos,$tipo_documento,$num_documento,$direccion,$telefono,$email,$licencia){
	$sql="INSERT INTO cliente (nombre,apellidos,tipo_documento,num_documento,direccion,telefono,email,licencia) VALUES ('$nombre','$apellidos','$tipo_documento','$num_documento','$direccion','$telefono','$email','$licencia')";
	return ejecutarConsulta($sql);
}


public function editar($idcliente,$nombre,$apellidos,$tipo_documento,$num_documento,$direccion,$telefono,$email,$licencia){
	$sql="UPDATE cliente SET nombre='$nombre',apellidos='$apellidos',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email', licencia='$licencia' 
	WHERE idcliente='$idcliente'";
	return ejecutarConsulta($sql);
}
//funcion para eliminar datos
public function eliminar($idcliente){
	$sql="DELETE FROM cliente WHERE idcliente='$idcliente'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idcliente){
	$sql="SELECT * FROM cliente WHERE idcliente='$idcliente'";
	return ejecutarConsultaSimpleFila($sql);
}

public function mostrar_contrato($idcliente){
	$sql="SELECT * FROM cliente WHERE idcliente='$idcliente'";
	return ejecutarConsulta($sql);
}
//listar registros
public function listarc(){
	$sql="SELECT * FROM cliente";
	return ejecutarConsulta($sql);
}
}

 ?>
