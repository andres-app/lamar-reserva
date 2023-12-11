<?php 
require_once "../modelos/Documentos.php";

$documentos=new Documentos();

$iddocumentos=isset($_POST["iddocumentos"])? limpiarCadena($_POST["iddocumentos"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
	if (empty($iddocumentos)) {
		$rspta=$documentos->insertar($nombre,$descripcion);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$documentos->editar($iddocumentos,$nombre,$descripcion);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'desactivar':
		$rspta=$documentos->desactivar($iddocumentos);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$documentos->activar($iddocumentos);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$documentos->mostrar($iddocumentos);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$documentos->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>($reg->condicion)?'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->iddocumentos.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-sm" onclick="desactivar('.$reg->iddocumentos.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->iddocumentos.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-sm" onclick="activar('.$reg->iddocumentos.')"><i class="fa fa-check"></i></button>',
            "1"=>$reg->nombre,
            "2"=>$reg->descripcion,
            "3"=>($reg->condicion)?'<small class="badge badge-success">Activado</small>':'<small class="badge badge-danger">Desactivado</small>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

	case 'selectDocumento':

			$rspta=$documentos->select();
			echo '<option value="0">seleccione...</option>';
			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->nombre.'>'.$reg->nombre.'</option>';
			}
	break;		
}
 ?>