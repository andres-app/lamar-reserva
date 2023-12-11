<?php 
//incluir la conexion de base de datos
//require "../config/Conexion.php";
require_once(dirname(__FILE__,2) . '/config/Conexion.php');
class Vehiculo{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($placa,$marca,$modelo,$anio,$color,$motor,$tipo,$poliza,$ult_mantenimiento,$prox_mantenimiento){
	$sql="INSERT INTO vehiculo (placa,marca,modelo,anio,color,motor,tipo,poliza,condicion,ult_mantenimiento, prox_mantenimiento) VALUES ('$placa','$marca','$modelo','$anio','$color','$motor','$tipo','$poliza','1','$ult_mantenimiento','$prox_mantenimiento')";
	return ejecutarConsulta($sql);
}

public function editar($id,$placa,$marca,$modelo,$anio,$color,$motor,$tipo,$poliza,$ult_mantenimiento,$prox_mantenimiento){
	$sql="UPDATE vehiculo SET placa='$placa',marca='$marca',modelo='$modelo',anio='$anio',color='$color',motor='$motor',tipo='$tipo', poliza='$poliza', ult_mantenimiento='$ult_mantenimiento', prox_mantenimiento='$prox_mantenimiento'
	WHERE id='$id'";
	return ejecutarConsulta($sql);
}

public function desactivar($id){
	$sql="UPDATE vehiculo SET estado='0' WHERE id='$id'";
	return ejecutarConsulta($sql);
}

public function activar($id){
	$sql="UPDATE vehiculo SET estado='1' WHERE id='$id'";
	return ejecutarConsulta($sql);
}

public function mostrar($id){
	$sql="SELECT * FROM vehiculo WHERE id='$id'";
	return ejecutarConsultaSimpleFila($sql);
}

public function mostrar_contrato($id){
	$sql="SELECT v.id, v.placa, v.anio, v.color,v.motor,(SELECT valor FROM op_vehiculo op WHERE op.id=v.marca) AS marca,(SELECT valor FROM op_vehiculo op WHERE op.id=v.modelo) AS modelo, (SELECT valor FROM op_vehiculo op WHERE op.id=v.tipo) AS tipo, (SELECT nombre FROM poliza op WHERE op.id=v.poliza) AS poliza ,DATE(v.ult_mantenimiento) as ult_mantenimiento,DATE(v.prox_mantenimiento) as prox_mantenimiento,v.condicion,v.estado FROM vehiculo v  WHERE v.id='$id'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT v.id, v.placa, v.anio, v.color,v.motor,(SELECT valor FROM op_vehiculo op WHERE op.id=v.marca) AS marca,(SELECT valor FROM op_vehiculo op WHERE op.id=v.modelo) AS modelo, (SELECT valor FROM op_vehiculo op WHERE op.id=v.tipo) AS tipo, (SELECT nombre FROM poliza op WHERE op.id=v.poliza) AS poliza ,DATE(v.ult_mantenimiento) as ult_mantenimiento,DATE(v.prox_mantenimiento) as prox_mantenimiento,v.condicion,v.estado FROM vehiculo v  ORDER BY v.id DESC";
	return ejecutarConsulta($sql);
}

public function select_disponibles(){
	$sql="SELECT * FROM vehiculo WHERE condicion='1'";
	return ejecutarConsulta($sql);
}

}

 ?>
