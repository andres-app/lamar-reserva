<?php 
require_once "../modelos/Alquiler.php";

$alquiler = new Alquiler();
//date_default_timezone_get('America/Lima');

date_default_timezone_set('America/Lima');

//AGREGAR
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$cliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$vehiculo=isset($_POST["idvehiculo"])? limpiarCadena($_POST["idvehiculo"]):"";
$km=isset($_POST["km"])? limpiarCadena($_POST["km"]):"";
$dias=isset($_POST["dias"])? limpiarCadena($_POST["dias"]):"";
$monto_dia=isset($_POST["monto_dia"])? limpiarCadena($_POST["monto_dia"]):"";
$f_registro=date("Y-m-d");
$f_inicio=isset($_POST["f_inicio"])? limpiarCadena($_POST["f_inicio"]):"";
$f_entrega_estimado=isset($_POST["f_entrega_estimado"])? limpiarCadena($_POST["f_entrega_estimado"]):"";
$h_entrega_empresa=isset($_POST["h_entrega_empresa"])? limpiarCadena($_POST["h_entrega_empresa"]):"";
$garantia=isset($_POST["garantia"])? limpiarCadena($_POST["garantia"]):"";
$punto_entrega=isset($_POST["punto_entrega"])? limpiarCadena($_POST["punto_entrega"]):"";
$total_pagado=isset($_POST["total_pagado"])? limpiarCadena($_POST["total_pagado"]):"";
$observaciones_al=isset($_POST["observaciones_al"])? limpiarCadena($_POST["observaciones_al"]):"";
$combustible_al=isset($_POST["combustible_al"])? limpiarCadena($_POST["combustible_al"]):"";

//EDITAR
$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$tipo_e=isset($_POST["tipo_e"])? limpiarCadena($_POST["tipo_e"]):"";
$cliente_e=isset($_POST["idcliente_e"])? limpiarCadena($_POST["idcliente_e"]):"";
$vehiculo_e=isset($_POST["idvehiculo_e"])? limpiarCadena($_POST["idvehiculo_e"]):"";
$km_e=isset($_POST["km_e"])? limpiarCadena($_POST["km_e"]):"";
$dias_e=isset($_POST["dias_e"])? limpiarCadena($_POST["dias_e"]):"";
$monto_dia_e=isset($_POST["monto_dia_e"])? limpiarCadena($_POST["monto_dia_e"]):"";
$f_inicio_e=isset($_POST["f_inicio_e"])? limpiarCadena($_POST["f_inicio_e"]):"";
$f_entrega_estimado_e=isset($_POST["f_entrega_estimado_e"])? limpiarCadena($_POST["f_entrega_estimado_e"]):"";
$h_entrega_empresa_e=isset($_POST["h_entrega_empresa_e"])? limpiarCadena($_POST["h_entrega_empresa_e"]):"";
$garantia_e=isset($_POST["garantia_e"])? limpiarCadena($_POST["garantia_e"]):"";
$punto_entrega_e=isset($_POST["punto_entrega_e"])? limpiarCadena($_POST["punto_entrega_e"]):"";
$total_pagado_e=isset($_POST["total_pagado_e"])? limpiarCadena($_POST["total_pagado_e"]):"";
$observaciones_al_e=isset($_POST["observaciones_al_e"])? limpiarCadena($_POST["observaciones_al_e"]):"";
$combustible_al_e=isset($_POST["combustible_al_e"])? limpiarCadena($_POST["combustible_al_e"]):"";

//AGREGAR FOTO DE DNI
$idalquilerdnia=isset($_POST["idalquilerdnia"])? limpiarCadena($_POST["idalquilerdnia"]):"";
$idalquilerdnir=isset($_POST["idalquilerdnir"])? limpiarCadena($_POST["idalquilerdnir"]):"";
$dni_cliente_anv=isset($_POST["dni_cliente_anv"])? limpiarCadena($_POST["dni_cliente_anv"]):"";
$dni_cliente_rev=isset($_POST["dni_cliente_rev"])? limpiarCadena($_POST["dni_cliente_rev"]):"";

//DEVOLUCION
$idvehiculo=isset($_POST["idv"])? limpiarCadena($_POST["idv"]):"";
$idalquiler=isset($_POST["idalquiler"])? limpiarCadena($_POST["idalquiler"]):"";
$f_entrega_real=isset($_POST["f_entrega_real"])? limpiarCadena($_POST["f_entrega_real"]):"";
$km_entrega=isset($_POST["km_entrega"])? limpiarCadena($_POST["km_entrega"]):"";
$h_entrega_cliente=isset($_POST["h_entrega_cliente"])? limpiarCadena($_POST["h_entrega_cliente"]):"";
$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";
$punto_recepcion=isset($_POST["punto_recepcion"])? limpiarCadena($_POST["punto_recepcion"]):"";
$dias_exedidos=isset($_POST["dias_exedidos"])? limpiarCadena($_POST["dias_exedidos"]):"";
$pago_exedido=isset($_POST["pago_exedido"])? limpiarCadena($_POST["pago_exedido"]):"";
$combustible_dev=isset($_POST["combustible_dev"])? limpiarCadena($_POST["combustible_dev"]):"";



switch ($_GET["op"]) {
	case 'guardar':
			$rspta=$alquiler->insertar($tipo,$cliente,$vehiculo,$dias,$monto_dia,$f_registro,$f_inicio,$f_entrega_estimado,$h_entrega_empresa,$garantia,$total_pagado,$observaciones_al,$km,$punto_entrega,$combustible_al,$_POST["id_accesorio"],$_POST["accesorio_alqulado"]);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	break;

	case 'editar':

			 $rspta=$alquiler->editar($id,$tipo_e,$cliente_e,$vehiculo_e,$dias_e,$monto_dia_e,$f_inicio_e,$f_entrega_estimado_e,$h_entrega_empresa_e,$garantia_e,$total_pagado_e,$observaciones_al_e,$km_e,$punto_entrega_e,$combustible_al_e); 
			echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";

	break;

	case 'devolucion':
		$rspta=$alquiler->devolucion($idalquiler,$idvehiculo,$dias_exedidos,$f_entrega_real,$h_entrega_cliente,$pago_exedido,$km_entrega,$observaciones,$punto_recepcion,$combustible_dev,$_POST["id_accesorio_dev"],$_POST["accesorio_devuelto"]);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	break;
	
	case 'dev_garantia':
		$rspta=$alquiler->dev_garantia($id);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	break;

	case 'mostrar_firma':
		$id = $_REQUEST["idalquiler"];
		$data_uri = $_REQUEST["firma"];
		$encoded_image = explode(",", $data_uri)[1];
		$decoded_image = base64_decode($encoded_image);
		$imagen = round(microtime(true));
		$ext=".png";
		$firma_cliente=$imagen.$ext;
		$ruta="../files/firmas/".$imagen.$ext;
		file_put_contents($ruta,$decoded_image);

		$nuevoAncho = 450;
		$nuevoAlto = 350;
		list($ancho, $alto) = getimagesize($ruta);
		$origen = imagecreatefrompng($ruta);						
		$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
		imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
		imagepng($destino, $ruta);

		$rspta=$alquiler->agregar_firma($id,$firma_cliente);
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
            $url='../tcpdf/pdf/contrato_al.php?id=';

			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->id.','.$reg->vehiculo.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-success btn-sm" onclick="mostrar_entrega('.$reg->id.')"><i class="fa fa-check"></i></button>'.' '.'<a target="_blank" href="'.$url.$reg->id.'"> <button class="btn btn-info btn-sm"><i class="fa fa-file"></i></button></a>',
            "1"=>$reg->ncliente,
            "2"=>$reg->marca.' '.$reg->modelo,
            "3"=>$reg->placa,
			"4"=>$reg->dias,
            "5"=>$reg->monto_dia,
			"6"=>$reg->f_inicio,
			"7"=>$reg->f_entrega_estimado,
			"8"=>$reg->h_entrega_empresa,
			"9"=>$reg->punto_entrega,
			"10"=>$reg->garantia,
			"11"=>$reg->total_pagado,
			"12"=>($reg->firma_cliente)?'<span class="badge badge-success">Agregado</span>':'<button class="btn btn-warning btn-sm" onclick="mostrar_modal_firma('.$reg->id.')"><i class="fa fa-check"></i> Agregar</button>',
			"13"=>($reg->dni_cliente_anv)?'<button class="btn btn-success btn-sm" onclick="ver_dni('.$reg->id.')"><i class="fa fa-eye"></i> Ver</button>':'<button class="btn btn-warning btn-sm" onclick="mostrar_modal_dnia('.$reg->id.')"><i class="fa fa-check"></i> Agregar</button>',
			"14"=>($reg->dni_cliente_rev)?'<button class="btn btn-success btn-sm" onclick="ver_dni('.$reg->id.')"><i class="fa fa-eye"></i> Ver</button>':'<button class="btn btn-warning btn-sm" onclick="mostrar_modal_dnir('.$reg->id.')"><i class="fa fa-check"></i> Agregar</button>',
			"15"=>($reg->estado)?'<span class="badge badge-warning">Devuelto</span>':'<span class="badge badge-success">Alquilado</span>'
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
			"8"=>$reg->f_entrega_real,
			"9"=>$reg->h_entrega_empresa,
			"10"=>$reg->h_entrega_cliente, 
			"11"=>$reg->garantia,
			"12"=>$reg->dias_exedidos,
			"13"=>$reg->total_pagado,
			"14"=>($reg->estado)?'<span class="badge badge-warning">Devuelto</span>':'<span class="badge badge-success">Alquilado</span>'
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
            $url='../tcpdf/pdf/contrato_dev.php?id=';

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
			"12"=>$reg->punto_entrega,
			"13"=>$reg->punto_recepcion,
			"14"=>$reg->garantia,
			"15"=>$reg->dias_exedidos,
			"16"=>$reg->pago_exedido,
			"17"=>$reg->total_pagado,
			"18"=>number_format($reg->pago_exedido+$reg->total_pagado, 2, '.', ''),
            "19"=>($reg->dev_garantia)?'<span class="badge badge-success">Devuelto</span>':'<span class="badge badge-warning">Por entregar</span>',
            "20"=>($reg->estado)?'<span class="badge badge-success">Devuelto</span>':'<span class="badge badge-warning">Alquilado</span>',
            "21"=>$reg->observaciones,
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
		echo json_encode($results);
	break;

	case 'lista_accesorios':
		$rspta=$alquiler->lista_accesorios();
		while ($reg=$rspta->fetch_object()) {
			echo '
			<div class="form-group col-lg-3 col-md-3 col-xs-12">
			<input type="hidden" name="id_accesorio[]" value="'.$reg->id.'">
			<div class="icheck-success d-inline">
			<input type="checkbox" checked name="accesorio_alqulado[]" id="accesorio_alqulado'.$reg->id.'" onclick="calcular('.$reg->id.')" value="1">
							  <label for="accesorio_alqulado'.$reg->id.'">'.$reg->nombre.'
							  </label>
			</div>
			<input type="hidden" name="accesorio_alqulado[]" id="'.$reg->id.'" disabled value="1"> 
		
			</div>';
		};

	break;
	case 'lista_accesorios_dev': 
		$id=$_REQUEST["id"];
		$rspta=$alquiler->lista_accesorios_dev($id);
		while ($reg=$rspta->fetch_object()) {
			$sw=$reg->accesorio_alquilado?'checked':'';
			$in=$reg->accesorio_alquilado?'disabled':'';
			$val=$reg->accesorio_alquilado?'1':'0';
			echo '
			<div class="form-group col-lg-3 col-md-3 col-xs-12">
			<input type="hidden" name="id_accesorio_dev[]" value="'.$reg->idaccesorio.'">
			<div class="icheck-success d-inline">
			<input type="checkbox" '.$sw.' name="accesorio_devuelto[]" id="accesorio_devuelto'.$reg->id.'" onclick="calcular_dev('.$reg->id.')" value="1">
							  <label for="accesorio_devuelto'.$reg->id.'">'.$reg->nombre.'
							  </label>
			</div>
			<input type="hidden" name="accesorio_devuelto[]" id="'.$reg->id.'" '.$in.' value="'.$val.'"> 
				  </div>';
		};
	break;

	case 'guardar_dni_anv':

		$exta=explode(".", $_FILES["dni_cliente_anv"]["name"]);
		if ($_FILES['dni_cliente_anv']['type'] == "image/jpg" || $_FILES['dni_cliente_anv']['type'] == "image/jpeg" || $_FILES['dni_cliente_anv']['type'] == "image/png")
		{
		$dni_cliente_anv = round(microtime(true)).'.'. end($exta);
			move_uploaded_file($_FILES["dni_cliente_anv"]["tmp_name"], "../files/documentos/" . $dni_cliente_anv);
		}

		$rspta=$alquiler->agregar_dni_anv($idalquilerdnia,$dni_cliente_anv);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";

	break;
	case 'guardar_dni_rev':

		$extr=explode(".", $_FILES["dni_cliente_rev"]["name"]);
		if ($_FILES['dni_cliente_rev']['type'] == "image/jpg" || $_FILES['dni_cliente_rev']['type'] == "image/jpeg" || $_FILES['dni_cliente_rev']['type'] == "image/png")
		{
		$dni_cliente_rev = round(microtime(true)).'.'. end($extr);
			move_uploaded_file($_FILES["dni_cliente_rev"]["tmp_name"], "../files/documentos/" . $dni_cliente_rev);
		}

		$rspta=$alquiler->agregar_dni_rev($idalquilerdnir,$dni_cliente_rev);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";

	break;
}
 ?>