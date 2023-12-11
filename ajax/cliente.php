<?php 
require_once "../modelos/Cliente.php";

$cliente=new Cliente();

$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellidos=isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$licencia=isset($_POST["licencia"])? limpiarCadena($_POST["licencia"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($idcliente)) {
		$rspta=$cliente->insertar($nombre,$apellidos,$tipo_documento,$num_documento,$direccion,$telefono,$email,$licencia);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$cliente->editar($idcliente,$nombre,$apellidos,$tipo_documento,$num_documento,$direccion,$telefono,$email,$licencia);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'eliminar':
		$rspta=$cliente->eliminar($idcliente);
		echo $rspta ? "Datos eliminados correctamente" : "No se pudo eliminar los datos";
		break;
	
	case 'mostrar':
		$rspta=$cliente->mostrar($idcliente);
		echo json_encode($rspta);
		break;

    case 'listarc':
		$rspta=$cliente->listarc();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->idcliente.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg->idcliente.')"><i class="fa fa-trash"></i></button>',
            "1"=>$reg->nombre.' '.$reg->apellidos,
            "2"=>$reg->tipo_documento,
            "3"=>$reg->num_documento,
            "4"=>$reg->telefono,
			"5"=>$reg->email,
			"6"=>$reg->licencia
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

	case 'selectCliente':
			$rspta = $cliente->listarc();
			echo '<option value="">Seleccione...</option>';
			while ($reg = $rspta->fetch_object()) {
				echo '<option value="'.$reg->idcliente.'">'.$reg->nombre.' '.$reg->apellidos.'</option>';
			}
	break;
}
 ?>