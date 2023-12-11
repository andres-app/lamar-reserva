<?php 
require_once "../modelos/Proveedor.php";

$proveedor=new Proveedor();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$nombres=isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$marca_vehiculo=isset($_POST["marca_vehiculo"])? limpiarCadena($_POST["marca_vehiculo"]):"";
$placa_vehiculo=isset($_POST["placa_vehiculo"])? limpiarCadena($_POST["placa_vehiculo"]):"";
$modelo_vehiculo=isset($_POST["modelo_vehiculo"])? limpiarCadena($_POST["modelo_vehiculo"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($id)) {
		$rspta=$proveedor->insertar($tipo_documento,$num_documento,$nombres,$email,$telefono,$marca_vehiculo,$placa_vehiculo,$modelo_vehiculo);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$proveedor->editar($id,$tipo_documento,$num_documento,$nombres,$email,$telefono,$marca_vehiculo,$placa_vehiculo,$modelo_vehiculo);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'eliminar':
		$rspta=$proveedor->eliminar($id);
		echo $rspta ? "Datos eliminados correctamente" : "No se pudo eliminar los datos";
		break;
	
	case 'mostrar':
		$rspta=$proveedor->mostrar($id);
		echo json_encode($rspta);
		break;

    case 'listarc':
		$rspta=$proveedor->listarc();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
			"0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg->id.')"><i class="fa fa-trash"></i></button>',
			"1"=>$reg->tipo_documento .' '.$reg->num_documento,
            "2"=>$reg->nombres,
            "3"=>$reg->email,
            "4"=>$reg->telefono,
            "5"=>$reg->placa_vehiculo,
			"6"=>$reg->modelo_vehiculo
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

	case 'selectProveedor':
			$rspta = $proveedor->listarc();
			echo '<option value="">Seleccione...</option>';
			while ($reg = $rspta->fetch_object()) {
				echo '<option value="'.$reg->id.'">'.$reg->nombres.'</option>';
			}
	break;
}
 ?>