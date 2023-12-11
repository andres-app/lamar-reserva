<?php 
require_once "../modelos/Op_vehiculo.php";

$op_vehiculo=new Op_vehiculo();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$item=isset($_POST["item"])? limpiarCadena($_POST["item"]):"";
$valor=isset($_POST["valor"])? limpiarCadena($_POST["valor"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($id)) {
		$rspta=$op_vehiculo->insertar($item,$valor);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$op_vehiculo->editar($id,$valor);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	
	case 'eliminar':
		$rspta=$op_vehiculo->eliminar($id);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo eliminar los datos";
		break;
	
	case 'mostrar':
		$rspta=$op_vehiculo->mostrar($id);
		echo json_encode($rspta);
		break;

	case 'listartipo':
		$item='Tipo';
		$rspta=$op_vehiculo->listar($item);
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg->id.')"><i class="fa fa-close"></i></button>',
            "1"=>$reg->valor
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

	case 'listarmarca':
		$item='Marca';
		$rspta=$op_vehiculo->listar($item);
		$data=Array();
	
		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
			"0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg->id.')"><i class="fa fa-close"></i></button>',
			"1"=>$reg->valor
			  );
		}
		$results=array(
			 "sEcho"=>1,//info para datatables
			 "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
			 "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
			 "aaData"=>$data); 
		echo json_encode($results);   
	break;

	case 'listarmodelo':
		$item='Modelo';
		$rspta=$op_vehiculo->listar($item);
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
			"0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg->id.')"><i class="fa fa-close"></i></button>',
			"1"=>$reg->valor
			  );
		}
		$results=array(
			 "sEcho"=>1,//info para datatables
			 "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
			 "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
			 "aaData"=>$data); 
		echo json_encode($results);   
	break; 

	case 'selectMarca':
		$item='Marca';
		$rspta=$op_vehiculo->select($item); 
		echo '<option value="0">seleccione...</option>';
		while ($reg=$rspta->fetch_object()) {
			echo '<option value=' . $reg->id.'>'.$reg->valor.'</option>';
			}
	break;

	case 'selectTipo':
		$item='Tipo';
		$rspta=$op_vehiculo->select($item); 
		echo '<option value="0">seleccione...</option>';
		while ($reg=$rspta->fetch_object()) {
			echo '<option value=' . $reg->id.'>'.$reg->valor.'</option>';
			}
	break;

	case 'selectModelo':
		$item='Modelo';
		$rspta=$op_vehiculo->select($item); 
		echo '<option value="0">seleccione...</option>';
		while ($reg=$rspta->fetch_object()) {
			echo '<option value=' . $reg->id.'>'.$reg->valor.'</option>';
			}
	break;

}
 ?>