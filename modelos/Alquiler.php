<?php 
//incluir la conexion de base de datos
//require "../config/Conexion.php";
require_once(dirname(__FILE__,2) . '/config/Conexion.php');
class Alquiler{

	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($tipo,$cliente,$vehiculo,$dias,$monto_dia,$f_registro,$f_inicio,$f_entrega_estimado,$h_entrega_empresa,$garantia,$total_pagado){
    $sw=true;
	$sql="INSERT INTO alquiler (tipo,cliente,vehiculo,dias,monto_dia,f_registro,f_inicio,f_entrega_estimado,h_entrega_empresa, garantia,total_pagado,estado) VALUES ('$tipo','$cliente','$vehiculo','$dias','$monto_dia','$f_registro','$f_inicio','$f_entrega_estimado','$h_entrega_empresa','$garantia','$total_pagado','0')";
    ejecutarConsulta($sql) or $sw=false;

    $sql_v="UPDATE vehiculo SET condicion='0' WHERE id='$vehiculo'";

    ejecutarConsulta($sql_v) or $sw=false; 
    
    return $sw;
}

public function editar($id,$tipo,$cliente,$vehiculo,$dias,$monto_dia,$f_inicio,$f_entrega_estimado,$h_entrega_empresa,$garantia,$total_pagado){
	$sql="UPDATE alquiler SET tipo='$tipo',cliente='$cliente',vehiculo='$vehiculo',dias='$dias',monto_dia='$monto_dia',f_inicio='$f_inicio', f_entrega_estimado='$f_entrega_estimado', h_entrega_empresa='$h_entrega_empresa', garantia='$garantia',total_pagado='$total_pagado'
	WHERE id='$id'";
	return ejecutarConsulta($sql);
}

public function devolucion($idalquiler,$idvehiculo,$f_entrega_real,$h_entrega_cliente,$observaciones){
    $sw=true;
	$sql="UPDATE alquiler SET f_entrega_real='$f_entrega_real',h_entrega_cliente='$h_entrega_cliente',observaciones='$observaciones',estado='1'
	WHERE id='$idalquiler'";
    ejecutarConsulta($sql) or $sw=false;

    $sql_v="UPDATE vehiculo SET condicion='1' WHERE id='$idvehiculo'";

    ejecutarConsulta($sql_v) or $sw=false; 
    
    return $sw;
}
public function dev_garantia($id){
	$sql="UPDATE alquiler SET dev_garantia='1' WHERE id='$id'";
	return ejecutarConsulta($sql);
}


public function mostrar($id){
	$sql="SELECT * FROM alquiler WHERE id='$id'";
	return ejecutarConsultaSimpleFila($sql);
}

public function mostrar_contrato($id){
	$sql="SELECT al.*, DATE_FORMAT(al.f_inicio,'%d/%m/%Y') AS fecha_inicial,DATE_FORMAT(al.f_entrega_estimado,'%d/%m/%Y') AS fecha_estimado, CONCAT(cli.nombre,' ',cli.apellidos) AS ncliente, (SELECT valor FROM op_vehiculo WHERE id=ve.marca) AS marca,(SELECT valor FROM op_vehiculo WHERE id=ve.modelo) AS modelo, ve.placa  FROM alquiler al INNER JOIN cliente cli ON al.cliente=cli.idcliente INNER JOIN vehiculo ve ON al.vehiculo=ve.id WHERE al.id='$id'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar_alquiler(){
	$sql="SELECT al.*, CONCAT(cli.nombre,' ',cli.apellidos) AS ncliente, (SELECT valor FROM op_vehiculo WHERE id=ve.marca) AS marca,(SELECT valor FROM op_vehiculo WHERE id=ve.modelo) AS modelo, ve.placa  FROM alquiler al INNER JOIN cliente cli ON al.cliente=cli.idcliente INNER JOIN vehiculo ve ON al.vehiculo=ve.id WHERE al.estado='0' ORDER BY al.id DESC";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar_dev(){
	$sql="SELECT al.*, CONCAT(cli.nombre,' ',cli.apellidos) AS ncliente, (SELECT valor FROM op_vehiculo WHERE id=ve.marca) AS marca,(SELECT valor FROM op_vehiculo WHERE id=ve.modelo) AS modelo, ve.placa  FROM alquiler al INNER JOIN cliente cli ON al.cliente=cli.idcliente INNER JOIN vehiculo ve ON al.vehiculo=ve.id WHERE al.estado='1' AND al.dev_garantia='1' ORDER BY al.id DESC";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar_garantia(){
	$sql="SELECT al.*, CONCAT(cli.nombre,' ',cli.apellidos) AS ncliente, (SELECT valor FROM op_vehiculo WHERE id=ve.marca) AS marca,(SELECT valor FROM op_vehiculo WHERE id=ve.modelo) AS modelo, ve.placa  FROM alquiler al INNER JOIN cliente cli ON al.cliente=cli.idcliente INNER JOIN vehiculo ve ON al.vehiculo=ve.id WHERE al.estado='1' AND al.dev_garantia='0' ORDER BY al.id DESC";
	return ejecutarConsulta($sql);
}
}

 ?>
