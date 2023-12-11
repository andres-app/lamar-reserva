<?php 
require_once "../modelos/Alquiler.php";

$alquiler = new Alquiler();
//date_default_timezone_get('America/Lima');

date_default_timezone_set('America/Lima');

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$idvehiculo=isset($_POST["idv"])? limpiarCadena($_POST["idv"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$cliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$vehiculo=isset($_POST["idvehiculo"])? limpiarCadena($_POST["idvehiculo"]):"";
$dias=isset($_POST["dias"])? limpiarCadena($_POST["dias"]):"";
$monto_dia=isset($_POST["monto_dia"])? limpiarCadena($_POST["monto_dia"]):"";
$f_registro=date("Y-m-d");
$f_inicio=isset($_POST["f_inicio"])? limpiarCadena($_POST["f_inicio"]):"";
$f_entrega_estimado=isset($_POST["f_entrega_estimado"])? limpiarCadena($_POST["f_entrega_estimado"]):"";
$h_entrega_empresa=isset($_POST["h_entrega_empresa"])? limpiarCadena($_POST["h_entrega_empresa"]):"";
$garantia=isset($_POST["garantia"])? limpiarCadena($_POST["garantia"]):"";
$total_pagado=isset($_POST["total_pagado"])? limpiarCadena($_POST["total_pagado"]):"";

$idalquiler=isset($_POST["idalquiler"])? limpiarCadena($_POST["idalquiler"]):"";
$f_entrega_real=isset($_POST["f_entrega_real"])? limpiarCadena($_POST["f_entrega_real"]):"";
$h_entrega_cliente=isset($_POST["h_entrega_cliente"])? limpiarCadena($_POST["h_entrega_cliente"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";



switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($id)) {
			$rspta=$alquiler->insertar($tipo,$cliente,$vehiculo,$dias,$monto_dia,$f_registro,$f_inicio,$f_entrega_estimado,$h_entrega_empresa,$garantia,$total_pagado);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		}else{
			 $rspta=$alquiler->editar($id,$tipo,$cliente,$vehiculo,$dias,$monto_dia,$f_inicio,$f_entrega_estimado,$h_entrega_empresa,$garantia,$total_pagado);
			echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		}
	break;

	case 'devolucion':
		$rspta=$alquiler->devolucion($idalquiler,$idvehiculo,$f_entrega_real,$h_entrega_cliente,$observaciones);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	break;
	
	case 'dev_garantia':
		$rspta=$alquiler->dev_garantia($id);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	break;

	case 'mostrar':
		$rspta=$alquiler->mostrar($id);
		echo json_encode($rspta);
	break;

    case 'listar_alquiler':
		$rspta=$alquiler->listar_alquiler();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
            $url='../tcpdf/pdf/contrato.php?id=';

			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-success btn-sm" onclick="mostrar_entrega('.$reg->id.')"><i class="fa fa-check"></i></button>'.' '.'<a target="_blank" href="'.$url.$reg->id.'"> <button class="btn btn-info btn-sm"><i class="fa fa-file"></i></button></a>',
            "1"=>$reg->ncliente,
            "2"=>$reg->marca.' '.$reg->modelo,
            "3"=>$reg->placa,
            "4"=>$reg->dias,
            "5"=>$reg->monto_dia,
			"6"=>$reg->f_inicio,
			"7"=>$reg->f_entrega_estimado,
			"8"=>$reg->h_entrega_empresa,
			"9"=>$reg->garantia,
			"10"=>$reg->total_pagado,
			"11"=>($reg->estado)?'<span class="badge badge-warning">Devuelto</span>':'<span class="badge badge-success">Alquilado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
		echo json_encode($results);
	break;

    case 'listar_garantia':
		$rspta=$alquiler->listar_garantia();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {

			$data[]=array(
            "0"=>'<button class="btn btn-success btn-sm" onclick="devolver_garantia('.$reg->id.')"><i class="fa fa-check"></i> Devolver</button>',
            "1"=>$reg->ncliente,
            "2"=>$reg->marca.' '.$reg->modelo,
            "3"=>$reg->placa,
            "4"=>$reg->dias,
            "5"=>$reg->monto_dia,
			"6"=>$reg->f_inicio,
			"7"=>$reg->f_entrega_estimado,
			"8"=>$reg->h_entrega_empresa,
			"9"=>$reg->garantia,
			"10"=>$reg->total_pagado,
			"11"=>($reg->estado)?'<span class="badge badge-warning">Devuelto</span>':'<span class="badge badge-success">Alquilado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
		echo json_encode($results);
    break;

    case 'listar_dev':
		$rspta=$alquiler->listar_dev();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
            $url='../tcpdf/pdf/contrato.php?id=';

			$data[]=array(
            "0"=>'<a target="_blank" href="'.$url.$reg->id.'"> <button class="btn btn-info btn-sm"><i class="fa fa-file"></i></button></a>',
            "1"=>($reg->tipo)?'<span class="badge badge-warning">Credito</span>':'<span class="badge badge-success">Normal</span>',
            "2"=>$reg->ncliente,
            "3"=>$reg->marca.' '.$reg->modelo,
            "4"=>$reg->placa,
            "5"=>$reg->dias,
            "6"=>$reg->monto_dia,
			"7"=>$reg->f_inicio,
            "8"=>$reg->f_entrega_estimado,
            "9"=>$reg->f_entrega_real,
            "10"=>$reg->h_entrega_empresa,
            "11"=>$reg->h_entrega_cliente,
            "12"=>$reg->garantia,
            "13"=>($reg->dev_garantia)?'<span class="badge badge-success">Devuelto</span>':'<span class="badge badge-warning">Alquilado</span>',
			"14"=>$reg->total_pagado,
            "15"=>($reg->estado)?'<span class="badge badge-success">Devuelto</span>':'<span class="badge badge-warning">Alquilado</span>',
            "16"=>$reg->observaciones,
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
		echo json_encode($results);
	break;
}
 ?>