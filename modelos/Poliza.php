<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Poliza{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($nombre,$contacto){
	$sql="INSERT INTO poliza (nombre,contacto) VALUES ('$nombre','$contacto')";
	return ejecutarConsulta($sql);
}

public function editar($id,$nombre, $contacto){
	$sql="UPDATE poliza SET nombre='$nombre', contacto='$contacto' 
	WHERE id='$id'";
	return ejecutarConsulta($sql);
}
public function eliminar($id){
	$sql="DELETE FROM poliza WHERE id='$id'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id){
	$sql="SELECT * FROM poliza WHERE id='$id'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM poliza";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM poliza";
	return ejecutarConsulta($sql);
}
}

 ?>
