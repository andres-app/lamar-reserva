<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../email/Exception.php';
require '../email/PHPMailer.php';
require '../email/SMTP.php'; 
require_once "../modelos/Email.php";

$email=new Email(); 

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$host=isset($_POST["host"])? limpiarCadena($_POST["host"]):"";
$usuario=isset($_POST["usuario"])? limpiarCadena($_POST["usuario"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$puerto=isset($_POST["puerto"])? limpiarCadena($_POST["puerto"]):"";
$receptor=isset($_POST["receptor"])? limpiarCadena($_POST["receptor"]):"";
	date_default_timezone_set('America/Lima');
      $fecha_actual = date("Y-m-d");
			$hora = date("H:i:s");

switch ($_GET["op"]) {
	case 'guardaryeditar':
         $rspta=$email->editar($id,$host,$usuario,$clave,$puerto,$receptor);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		break;
	

	
	case 'mostrar':
		$rspta=$email->mostrar($id);
		echo json_encode($rspta);
		break;

	case 'validar_envio':
  $asunto=$_REQUEST["asunto"];
		$rspta=$email->validar_envio($fecha_actual,$asunto);
            		while ($reg=$rspta->fetch_object()) {
            $var= $reg->id;
            echo $var;
		}
		break;

	case 'eliminar':
		$rspta=$email->eliminar($id);
		echo $rspta ? "Datos eliminados correctamente" : "No se pudo eliminar los datos";
		break;

    case 'listar':
		$rspta=$email->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-warning btn-sm" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>',
            "1"=>$reg->host,
            "2"=>$reg->usuario,
            "3"=>$reg->puerto,
            "4"=>$reg->receptor
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

    case 'listar_enviados':
		$rspta=$email->listar_enviados();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>'<button class="btn btn-danger btn-sm" onclick="eliminar('.$reg->id.')"><i class="fa fa-trash"></i></button>',
            "1"=>$reg->fecha,
            "2"=>$reg->asunto,
            "3"=>$reg->mensaje,
            "4"=>($reg->estado)?'<span class="badge badge-success">Enviado</span>':'<span class="badge badge-danger">No enviado</span>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);   
		break;

	case 'afechadevolucion': 
		$rspta=$email->afechadevolucion();
        		while ($reg=$rspta->fetch_object()) {
            $var= '<li><strong>Cliente: </strong>'.$reg->ncliente. ',<br> <strong>Placa: </strong>'.$reg->placa.' '.$reg->modelo.',<br> <strong> Fecha de entrega: </strong>'.$reg->f_entrega_estimado.'</li>';
            echo $var;
		}
		break;

 	case 'afechainicio':
		$rspta=$email->afechainicio();
        		while ($reg=$rspta->fetch_object()) {
            $var= '<li><strong>Cliente: </strong>'.$reg->ncliente. ',<br> <strong>Placa: </strong>'.$reg->placa.' '.$reg->modelo.',<br> <strong> Fecha de alquiler: </strong>'.$reg->f_inicio.'</li>';
            echo $var;
		}
		break;

	case 'afechamantenimiento':
		$rspta=$email->afechamantenimiento();
                		while ($reg=$rspta->fetch_object()) {
            $var= '<li><strong>Marca: </strong>'.$reg->marca. ',<br> <strong>Placa: </strong>'.$reg->placa.' '.$reg->modelo.',<br> <strong> Fecha de manteminiento: </strong>'.$reg->prox_mantenimiento.'</li>';
            echo $var;
		}
		break; 

	case 'enviar_alerta':
        $datos=$_REQUEST["datos"];
        $asunto=$_REQUEST["asunto"];

        require_once "../modelos/Email.php";
        $email = new Email();
        $rsptan = $email->listar();
        if (empty($rsptan)) {
            $host='Agregar host';
            $usuario='Agregar usuario';
            $clave='*****';
            $puerto='000';
            $receptor='Agregar receptor';
        }else{
            $regn=$rsptan->fetch_object();
            $host=$regn->host;
            $usuario=$regn->usuario;
            $clave=$regn->clave;
            $puerto=$regn->puerto;
            $receptor=$regn->receptor;
        };


        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                       // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = $host;                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $usuario;                     // SMTP username
            $mail->Password   = $clave;                               // SMTP password
            $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = $puerto;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom($usuario, 'LAMAR PERU');
            $mail->addAddress($receptor, 'Joe User');     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = '<ul>'.$datos.'</ul>';
           // $mail->AltBody = 'Este es el cuerpo en texto sin formato para clientes de correo que no son HTML';

            $mail->send();
            echo 'El mensaje ha sido enviado';
            $estado='1';
            $rspta=$email->guardar_email($fecha_actual,$asunto,$datos,$estado);
            } catch (Exception $e) {
                echo "No se pudo enviar el mensaje. Error de envío: {$mail->ErrorInfo}";
            }

		break;

}
 ?>