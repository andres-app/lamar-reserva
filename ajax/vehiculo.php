<?php 
require_once "../modelos/Vehiculo.php";

$vehiculo = new Vehiculo();
 
$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$placa=isset($_POST["placa"])? limpiarCadena($_POST["placa"]):"";
$marca=isset($_POST["marca"])? limpiarCadena($_POST["marca"]):"";
$modelo=isset($_POST["modelo"])? limpiarCadena($_POST["modelo"]):"";
$anio=isset($_POST["anio"])? limpiarCadena($_POST["anio"]):"";
$color=isset($_POST["color"])? limpiarCadena($_POST["color"]):"";
$motor=isset($_POST["motor"])? limpiarCadena($_POST["motor"]):"";
$combustible=isset($_POST["combustible"])? limpiarCadena($_POST["combustible"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$poliza=isset($_POST["poliza"])? limpiarCadena($_POST["poliza"]):"";
$condicion=isset($_POST["condicion"])? limpiarCadena($_POST["condicion"]):"";
$ult_mantenimiento=isset($_POST["ult_mantenimiento"])? limpiarCadena($_POST["ult_mantenimiento"]):"";
$prox_mantenimiento=isset($_POST["prox_mantenimiento"])? limpiarCadena($_POST["prox_mantenimiento"]):"";



switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($id)) {
			$rspta=$vehiculo->insertar($placa,$marca,$modelo,$anio,$color,$motor,$combustible,$tipo,$poliza,$ult_mantenimiento,$prox_mantenimiento);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		}else{
			 $rspta=$vehiculo->editar($id,$placa,$marca,$modelo,$anio,$color,$motor,$combustible,$tipo,$poliza,$ult_mantenimiento,$prox_mantenimiento);
			echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		}
	break;

	case 'desactivar':
		$rspta=$vehiculo->desactivar($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar el dato";
	break;
	
	case 'activar':
		$rspta=$vehiculo->activar($id);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar el dato";
	break;

	case 'mostrar':
		$rspta=$vehiculo->mostrar($id);
		echo json_encode($rspta);
	break;

    case 'listar':
		$rspta=$vehiculo->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>($reg->estado)?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->id.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-sm" onclick="activar('.$reg->id.')"><i class="fa fa-check"></i></button>',
            "1"=>$reg->placa,
            "2"=>$reg->marca,
            "3"=>$reg->modelo,
            "4"=>$reg->anio,
            "5"=>$reg->color,
			"6"=>$reg->motor,
			"7"=>$reg->combustible,
			"8"=>$reg->tipo,
			"9"=>$reg->poliza,
			"10"=>$reg->ult_mantenimiento,
			"11"=>$reg->prox_mantenimiento,
			"12"=>($reg->condicion)?'<span class="badge badge-success">Disponible</span>':'<span class="badge badge-warning">Alquilado</span>',
            "13"=>($reg->estado)?'<span class="badge badge-success">Activado</span>':'<span class="badge badge-danger">Desactivado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
		echo json_encode($results);
		break; 

	case 'select_disponibles':
		$rspta = $vehiculo->select_disponibles();
		echo '<option value="">Seleccione...</option>';
		while ($reg = $rspta->fetch_object()) {
			echo '<option value="'.$reg->id.'">'.$reg->placa.' '.$reg->modelo_v.'</option>';
		}
	break;
	case 'select_e':
		$id_e=$_REQUEST["id_e"];
		$rspta = $vehiculo->select_e($id_e);
		while ($reg = $rspta->fetch_object()) {
			echo '<option value="'.$reg->id.'">'.$reg->placa.' '.$reg->modelo_v.'</option>';
		}
	break; 
}
 ?>