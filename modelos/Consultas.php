<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php"; 
class Consultas{


	//implementamos nuestro constructor
public function __construct(){

} 

public function totalalquiler(){  
	$sql="SELECT SUM(total_pagado+pago_exedido) AS total_alquiler FROM alquiler WHERE MONTH(f_registro) = MONTH(CURRENT_DATE())";
	return ejecutarConsulta($sql);
}

public function totaldisponibles(){  
	$sql="SELECT COUNT(id) as total_disponibles FROM vehiculo WHERE condicion='1'";
	return ejecutarConsulta($sql);
}

public function totalalquilados(){
	$sql="SELECT COUNT(id) as total_alquilados FROM vehiculo WHERE condicion='0'";
	return ejecutarConsulta($sql);
}

public function totalalclientes(){
	$sql="SELECT COUNT(idcliente) as total_clientes FROM cliente WHERE estado='1'";
	return ejecutarConsulta($sql);
}

public function alquilerultimos_10dias(){
	$sql="SELECT CONCAT(DAY(f_registro),'-',MONTH(f_registro)) AS fecha, SUM(total_pagado+pago_exedido) AS total FROM alquiler GROUP BY f_registro ORDER BY f_registro DESC LIMIT 0,10";
	return ejecutarConsulta($sql); 
}

public function alquilerultimos_12meses(){
	$sql="SELECT DATE_FORMAT(f_registro,'%M') AS fecha, SUM(total_pagado+pago_exedido) AS total FROM alquiler GROUP BY MONTH(f_registro) ORDER BY f_registro DESC LIMIT 0,12";
	return ejecutarConsulta($sql);
}

//listar registros
/*public function comprasfecha($fecha_inicio,$fecha_fin){
	$sql="SELECT DATE(i.fecha_hora) as fecha, u.nombre as usuario, p.nombre as proveedor, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN proveedor p ON i.idproveedor=p.idproveedor INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
	return ejecutarConsulta($sql);
}


public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente){
	$sql="SELECT DATE(v.fecha_hora) as fecha, u.nombre as usuario, p.nombre as cliente, v.tipo_comprobante,v.serie_comprobante, v.num_comprobante , v.total_venta, v.impuesto, v.estado FROM venta v INNER JOIN cliente p ON v.idcliente=p.idcliente INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
	return ejecutarConsulta($sql);
}*/


}

 ?>
