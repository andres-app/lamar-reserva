<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Comprobantes{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($nombre,$serie,$numero){
	$sql="INSERT INTO comprobantes (nombre,serie,numero,condicion) VALUES ('$nombre','$serie','$numero','1')";
	return ejecutarConsulta($sql);
}

public function editar($id_comp_pago,$nombre,$serie,$numero){
	$sql="UPDATE comprobantes SET nombre='$nombre',serie='$serie',numero='$numero' 
	WHERE id_comp_pago='$id_comp_pago'";
	return ejecutarConsulta($sql);
}
public function desactivar($id_comp_pago){
	$sql="UPDATE comprobantes SET condicion='0' WHERE id_comp_pago='$id_comp_pago'";
	return ejecutarConsulta($sql);
}
public function activar($id_comp_pago){
	$sql="UPDATE comprobantes SET condicion='1' WHERE id_comp_pago='$id_comp_pago'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id_comp_pago){
	$sql="SELECT * FROM comprobantes WHERE id_comp_pago='$id_comp_pago'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM comprobantes";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM comprobantes WHERE condicion=1";
	return ejecutarConsulta($sql);
}
public function mostrar_serie_ticket(){
	$sql="SELECT serie, numero FROM comprobantes WHERE nombre='Ticket'";
	return ejecutarConsulta($sql);
}
public function mostrar_numero_ticket(){
	$sql="SELECT numero FROM comprobantes WHERE nombre='Ticket'";
	return ejecutarConsulta($sql);
}
public function mostrar_serie_boleta(){
	$sql="SELECT serie, numero FROM comprobantes WHERE nombre='Boleta'";
	return ejecutarConsulta($sql);
}
public function mostrar_numero_boleta(){
	$sql="SELECT numero FROM comprobantes WHERE nombre='Boleta'";
	return ejecutarConsulta($sql);
}
public function mostrar_serie_factura(){
	$sql="SELECT serie, numero FROM comprobantes WHERE nombre='Factura'";
	return ejecutarConsulta($sql);
}
public function mostrar_numero_factura(){
	$sql="SELECT numero FROM comprobantes WHERE nombre='Factura'";
	return ejecutarConsulta($sql);
}
public function mostrar_serie_proforma(){
	$sql="SELECT serie, numero FROM comprobantes WHERE nombre='Proforma'";
	return ejecutarConsulta($sql);
}
public function mostrar_numero_proforma(){
	$sql="SELECT numero FROM comprobantes WHERE nombre='Proforma'";
	return ejecutarConsulta($sql);
}
}

 ?>
