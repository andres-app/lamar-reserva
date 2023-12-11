<?php 
//incluir la conexion de base de datos
//require "../config/Conexion.php";
require_once(dirname(__FILE__,2) . '/config/Conexion.php');
class Proveedor{

	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($tipo_documento,$num_documento,$nombres,$email,$telefono,$marca_vehiculo,$placa_vehiculo,$modelo_vehiculo){
	$sql="INSERT INTO proveedor (tipo_documento,num_documento,nombres,email,telefono,marca_vehiculo,placa_vehiculo,modelo_vehiculo) VALUES ('$tipo_documento','$num_documento','$nombres','$email','$telefono','$marca_vehiculo','$placa_vehiculo','$modelo_vehiculo')";
	return ejecutarConsulta($sql);
}


public function editar($id,$tipo_documento,$num_documento,$nombres,$email,$telefono,$marca_vehiculo,$placa_vehiculo,$modelo_vehiculo){
	$sql="UPDATE proveedor SET tipo_documento='$tipo_documento', num_documento='$num_documento',nombres='$nombres',email='$email',telefono='$telefono',marca_vehiculo='$marca_vehiculo',placa_vehiculo='$placa_vehiculo',modelo_vehiculo='$modelo_vehiculo' 
	WHERE id='$id'";
	return ejecutarConsulta($sql);
}
//funcion para eliminar datos
public function eliminar($id){
	$sql="DELETE FROM proveedor WHERE id='$id'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id){
	$sql="SELECT * FROM proveedor WHERE id='$id'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listarc(){
	$sql="SELECT * FROM proveedor";
	return ejecutarConsulta($sql);
}
}

 ?>
