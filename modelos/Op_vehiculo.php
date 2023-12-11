<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Op_vehiculo{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($item,$valor){
	$sql="INSERT INTO op_vehiculo (item,valor) VALUES ('$item','$valor')";
	return ejecutarConsulta($sql);
}

public function editar($id,$valor){
	$sql="UPDATE op_vehiculo SET valor='$valor' 
	WHERE id='$id'";
	return ejecutarConsulta($sql);
}
public function eliminar($id){
	$sql="DELETE FROM op_vehiculo WHERE id='$id'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id){
	$sql="SELECT * FROM op_vehiculo WHERE id='$id'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar($item){
	$sql="SELECT * FROM op_vehiculo WHERE item='$item'";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select($item){
	$sql="SELECT * FROM op_vehiculo WHERE item='$item'";
	return ejecutarConsulta($sql);
}
}

 ?>
