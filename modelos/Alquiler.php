<?php 
//incluir la conexion de base de datos
//require "../config/Conexion.php";
require_once(dirname(__FILE__,2) . '/config/Conexion.php');
class Alquiler{

	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($tipo,$cliente,$vehiculo,$dias,$monto_dia,$f_registro,$f_inicio,$f_entrega_estimado,$h_entrega_empresa,$garantia,$total_pagado,$observaciones_al,$km,$punto_entrega,$combustible_al,$id_accesorio,$accesorio_alquilado){
    $sw=true;
	$sql="INSERT INTO alquiler (tipo,cliente,vehiculo,dias,monto_dia,f_registro,f_inicio,f_entrega_estimado,h_entrega_empresa, garantia,total_pagado,estado,observaciones_al,km,punto_entrega,combustible_al) VALUES ('$tipo','$cliente','$vehiculo','$dias','$monto_dia','$f_registro','$f_inicio','$f_entrega_estimado','$h_entrega_empresa','$garantia','$total_pagado','0','$observaciones_al','$km','$punto_entrega','$combustible_al')";
	$idalquilernew=ejecutarConsulta_retornarID($sql);
	$num_elementos=0;
	while ($num_elementos < count($id_accesorio)) {
		//if($accesorio_alquilado[$num_elementos]=='1'){
		$sql_detalle="INSERT INTO accesorios_alquiler (idalquiler,idaccesorio,accesorio_alquilado) VALUES('$idalquilernew','$id_accesorio[$num_elementos]','$accesorio_alquilado[$num_elementos]')";

		ejecutarConsulta($sql_detalle) or $sw=false; 

		$num_elementos=$num_elementos+1;
		//}
	}
	if($sw==true){
		$sql_v="UPDATE vehiculo SET condicion='0' WHERE id='$vehiculo'";

		ejecutarConsulta($sql_v) or $sw=false; 
	};
	



    return $sw;
}

public function editar($id,$tipo_e,$cliente_e,$vehiculo_e,$dias_e,$monto_dia_e,$f_inicio_e,$f_entrega_estimado_e,$h_entrega_empresa_e,$garantia_e,$total_pagado_e,$observaciones_al_e,$km_e,$punto_entrega_e,$combustible_al_e){
	$sql="UPDATE alquiler SET tipo='$tipo_e',cliente='$cliente_e',vehiculo='$vehiculo_e', dias='$dias_e',monto_dia='$monto_dia_e',f_inicio='$f_inicio_e', f_entrega_estimado='$f_entrega_estimado_e', h_entrega_empresa='$h_entrega_empresa_e' , garantia='$garantia_e',total_pagado='$total_pagado_e',observaciones_al='$observaciones_al_e',km='$km_e', punto_entrega='$punto_entrega_e',combustible_al='$combustible_al_e'
	WHERE id='$id'";
	return ejecutarConsulta($sql);
}

public function devolucion($idalquiler,$idvehiculo,$dias_exedidos,$f_entrega_real,$h_entrega_cliente,$pago_exedido,$km_entrega,$observaciones,$punto_recepcion,$combustible_dev,$id_accesorio_dev,$accesorio_devuelto){
    $sw=true;
	$sql="UPDATE alquiler SET dias_exedidos='$dias_exedidos', f_entrega_real='$f_entrega_real',h_entrega_cliente='$h_entrega_cliente', pago_exedido='$pago_exedido', km_entrega='$km_entrega',observaciones='$observaciones',estado='1', punto_recepcion='$punto_recepcion',combustible_dev='$combustible_dev'
	WHERE id='$idalquiler'";
    ejecutarConsulta($sql) or $sw=false;

	$num_elementos=0;
	while ($num_elementos < count($id_accesorio_dev)) {
		//if($accesorio_devuelto[$num_elementos]=='1'){
		$sql_detalle="UPDATE accesorios_alquiler SET accesorio_devuelto='$accesorio_devuelto[$num_elementos]' WHERE idalquiler='$idalquiler' AND idaccesorio='$id_accesorio_dev[$num_elementos]'";
		ejecutarConsulta($sql_detalle) or $sw=false; 

		$num_elementos=$num_elementos+1;
		//}
	}

	if($sw==true){
		$sql_v="UPDATE vehiculo SET condicion='1' WHERE id='$idvehiculo'";

		ejecutarConsulta($sql_v) or $sw=false; 
	};

    
    return $sw;
}
public function dev_garantia($id){
	$sql="UPDATE alquiler SET dev_garantia='1' WHERE id='$id'";
	return ejecutarConsulta($sql);
}

public function agregar_firma($id,$firma_cliente){
	$sql="UPDATE alquiler SET firma_cliente='$firma_cliente' WHERE id='$id'";
	return ejecutarConsulta($sql);
}

public function agregar_dni_anv($idalquilerdnia,$dni_cliente_anv){
	$sql="UPDATE alquiler SET dni_cliente_anv='$dni_cliente_anv' WHERE id='$idalquilerdnia'";
	return ejecutarConsulta($sql);
}

public function agregar_dni_rev($idalquilerdnir,$dni_cliente_rev){
	$sql="UPDATE alquiler SET dni_cliente_rev='$dni_cliente_rev' WHERE id='$idalquilerdnir'";
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
	$sql="SELECT al.*, CONCAT(cli.nombre,' ',cli.apellidos) AS ncliente, (SELECT valor FROM op_vehiculo WHERE id=ve.marca) AS marca,(SELECT valor FROM op_vehiculo WHERE id=ve.modelo) AS modelo, ve.placa  FROM alquiler al INNER JOIN cliente cli ON al.cliente=cli.idcliente INNER JOIN vehiculo ve ON al.vehiculo=ve.id WHERE al.estado='1' ORDER BY al.id DESC";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar_garantia(){
	$sql="SELECT al.*, CONCAT(cli.nombre,' ',cli.apellidos) AS ncliente, (SELECT valor FROM op_vehiculo WHERE id=ve.marca) AS marca,(SELECT valor FROM op_vehiculo WHERE id=ve.modelo) AS modelo, ve.placa  FROM alquiler al INNER JOIN cliente cli ON al.cliente=cli.idcliente INNER JOIN vehiculo ve ON al.vehiculo=ve.id WHERE al.estado='1' AND al.dev_garantia='0' ORDER BY al.id DESC";
	return ejecutarConsulta($sql);
} 
public function lista_accesorios(){
	$sql="SELECT * FROM accesorios_vehiculo";
	return ejecutarConsulta($sql);
}

public function lista_accesorios_dev($id){
	$sql="SELECT ac.id,ac.idalquiler, ac.idaccesorio, av.nombre, ac.accesorio_alquilado,ac.accesorio_devuelto FROM accesorios_alquiler ac
	LEFT JOIN accesorios_vehiculo av ON ac.idaccesorio=av.id WHERE ac.idalquiler='$id'";
	return ejecutarConsulta($sql);
}

public function accesorio_alquiler($idalquiler){ 
	$sql="SELECT ac.id,ac.idalquiler, ac.idaccesorio, av.nombre, ac.accesorio_alquilado,ac.accesorio_devuelto FROM accesorios_alquiler ac
	LEFT JOIN accesorios_vehiculo av ON ac.idaccesorio=av.id WHERE ac.idalquiler='$idalquiler' ORDER BY id ASC LIMIT 10";
	return ejecutarConsulta($sql);
}


public function accesorio_alquilerdos($idalquiler){
	$sql="SELECT ac.id,ac.idalquiler, ac.idaccesorio, av.nombre, ac.accesorio_alquilado,ac.accesorio_devuelto FROM accesorios_alquiler ac
	LEFT JOIN accesorios_vehiculo av ON ac.idaccesorio=av.id WHERE ac.idalquiler='$idalquiler' AND av.id>10 AND av.id<=20";
	return ejecutarConsulta($sql);
}

public function accesorio_alquilertres($idalquiler){ 
	$sql="SELECT ac.id,ac.idalquiler, ac.idaccesorio, av.nombre, ac.accesorio_alquilado,ac.accesorio_devuelto FROM accesorios_alquiler ac
	LEFT JOIN accesorios_vehiculo av ON ac.idaccesorio=av.id WHERE ac.idalquiler='$idalquiler' AND av.id>20";
	return ejecutarConsulta($sql);
}
}

 ?>
