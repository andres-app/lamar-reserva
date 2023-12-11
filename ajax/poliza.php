<?php 
require_once "../modelos/Poliza.php";

$poliza=new Poliza();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$contacto=isset($_POST["contacto"])? limpiarCadena($_POST["contacto"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($id)) {
		$rspta=$poliza->insertar($nombre,$contacto);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$poliza->editar($id,$nombre,$contacto);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	
	case 'eliminar':
		$rspta=$poliza->eliminar($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo eliminar los datos";
		break;
	
	case 'mostrar':
		$rspta=$poliza->mostrar($id);
		echo json_encode($rspta);
		break;




	case 'listar':
		$rspta=$poliza->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg->id.')"><i class="fa fa-close"></i></button>',
            "1"=>$reg->nombre,
			"2"=>$reg->contacto
			  );
		}
		$results=array(
			 "sEcho"=>1,//info para datatables
			 "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
			 "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
			 "aaData"=>$data); 
		echo json_encode($results);   
	break; 

	case 'selectPoliza':
		$rspta=$poliza->select(); 
		echo '<option value="0">seleccione...</option>';
		while ($reg=$rspta->fetch_object()) {
			echo '<option value=' . $reg->id.'>'.$reg->nombre.'</option>';
			}
	break;
}
 ?>