<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Email{


	//implementamos nuestro constructor
public function __construct(){

}


public function editar($id,$host,$usuario,$clave,$puerto,$receptor){
	$sql="UPDATE email SET host='$host',usuario='$usuario', clave='$clave', puerto='$puerto',receptor='$receptor' 
	WHERE id='$id'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id){
	$sql="SELECT * FROM email WHERE id='$id'";
	return ejecutarConsultaSimpleFila($sql);
}

//funcion para eliminar datos
public function eliminar($id){
	$sql="DELETE FROM email_enviados WHERE id='$id'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM email";
	return ejecutarConsulta($sql); 
}

//listar registros
public function validar_envio($fecha_actual,$asunto){
	$sql="SELECT * FROM email_enviados WHERE fecha='$fecha_actual' AND asunto='$asunto'";
	return ejecutarConsulta($sql); 
}

//listar registros
public function listar_enviados(){
	$sql="SELECT * FROM email_enviados";
	return ejecutarConsulta($sql); 
}
public function afechadevolucion(){
	$sql="SELECT al.*, CONCAT(cli.nombre,' ',cli.apellidos) AS ncliente, (SELECT valor FROM op_vehiculo WHERE id=ve.marca) AS marca,(SELECT valor FROM op_vehiculo WHERE id=ve.modelo) AS modelo, ve.placa  FROM alquiler al INNER JOIN cliente cli ON al.cliente=cli.idcliente INNER JOIN vehiculo ve ON al.vehiculo=ve.id WHERE al.f_entrega_estimado =date_sub(curdate(), interval -1 DAY)";
	return ejecutarConsulta($sql);
}

public function afechainicio(){
	$sql="SELECT al.*, CONCAT(cli.nombre,' ',cli.apellidos) AS ncliente, (SELECT valor FROM op_vehiculo WHERE id=ve.marca) AS marca,(SELECT valor FROM op_vehiculo WHERE id=ve.modelo) AS modelo, ve.placa  FROM alquiler al INNER JOIN cliente cli ON al.cliente=cli.idcliente INNER JOIN vehiculo ve ON al.vehiculo=ve.id ORDER BY id DESC LIMIT 1";
	return ejecutarConsulta($sql);
}

public function afechamantenimiento(){
	$sql="SELECT * FROM vehiculo WHERE prox_mantenimiento=date_sub(curdate(), interval -1 DAY)";
	return ejecutarConsulta($sql);
}

public function guardar_email($fecha_actual,$asunto,$datos,$estado){
	$sql="INSERT INTO email_enviados (fecha,asunto,mensaje,estado) VALUES('$fecha_actual','$asunto','$datos','$estado')";
	return ejecutarConsulta($sql);
}
}

 ?>
