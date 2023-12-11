<?php
//ob_end_clean();
//flush();
//ob_start();
//header("Content-type: application/pdf"); 
//ini_set ('display_errors', 1);
//activamos almacenamiento en el buffer
//ob_start();
if (strlen(session_id())<1) 
session_start();

if (!isset($_SESSION['nombre'])) {
echo "debe ingresar al sistema correctamente para visualizar el reporte";
}else{

if ($_SESSION['alquiler']==1) {

//require_once "../../modelos/Negocio.php";
require_once "../../modelos/Negocio.php";
require_once "../../modelos/Alquiler.php";
require_once "../../modelos/Vehiculo.php";
require_once "../../modelos/Cliente.php";

/*include_once(dirname(__FILE__,3) . '..\modelos\Negocio.php');
include_once(dirname(__FILE__,3) . '..\modelos\Alquiler.php');
include_once(dirname(__FILE__,3) . '..\modelos\Vehiculo.php');
include_once(dirname(__FILE__,3) . '..\modelos\Cliente.php');*/

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){


//require_once "../../modelos/Negocio.php";
$empresa = new Negocio();
$rsptan = $empresa->listar();
$regn=$rsptan->fetch_object();
$negocio = utf8_encode($regn->nombre);
$nombre_empresa=utf8_decode($negocio);
$tipo_documento = $regn->ndocumento;
$num_documento = $regn->documento;
$direccion = utf8_encode($regn->direccion);
$direccion_empresa=utf8_decode($direccion);
$telefono = $regn->telefono;  
$email = $regn->email;
$pais = $regn->pais;
$ciudad = $regn->ciudad;
$moneda = $regn->moneda;
$simbolo = $regn->simbolo;
$new_simbolo='';
$sim_euro='€';
$sim_yen='¥';
$sim_libra='£';
if ($simbolo==$sim_euro) {
$new_simbolo=EURO;
}elseif($simbolo==$sim_yen){
$new_simbolo=JPY;
}elseif ($simbolo==$sim_libra) {
$new_simbolo=GBP;
}else{
$new_simbolo=$simbolo;
}


//$logoe="../files/negocio/".$regn->logo."";
//$ext_logo="jpg";

//TRAEMOS LA INFORMACIÓN DEl ALQUILER
$alquiler= new Alquiler();
$rspta=$alquiler->mostrar_contrato($_GET["id"]);
//recorremos todos los valores que obtengamos
$rega=$rspta->fetch_object();

$idcliente=$rega->cliente;
$idvehiculo=$rega->vehiculo;
$km=$rega->km;
$km_entrega=$rega->km_entrega;
$por_dia=$rega->monto_dia;
$fecha_inicio=$rega->fecha_inicial;
$fecha_estimado=$rega->fecha_estimado;
$h_entrega=$rega->h_entrega_cliente;
$h_entrega_empresa=$rega->h_entrega_empresa;
$garantia=$rega->garantia;
$observaciones=$rega->observaciones;
$punto_entrega=$rega->punto_entrega;
$punto_recepcion=$rega->punto_recepcion;
$combustible_al=$rega->combustible_al;
$combustible_dev=$rega->combustible_dev;
//$firmaCliente=$rega->firma_cliente;
if(empty($rega->firma_cliente)){
$firmaCliente='default.png';
}else{
  $firmaCliente=$rega->firma_cliente; 
}


//aqui falta codigo de letras
require_once "Letras.php";
$letras = new EnLetras();

$total=$rega->garantia; 
$letras->substituir_un_mil_por_mil = true;

$con_letra=strtoupper($letras->ValorEnLetras($total," $moneda"));

//TRAEMOS LA INFORMACIÓN DEl CLIENTE
$cliente= new Cliente();
$rsptac=$cliente->mostrar_contrato($idcliente);
//recorremos todos los valores que obtengamos
$regc=$rsptac->fetch_object();

$ncliente=$regc->nombre.' '.$regc->apellidos;
$tipo_doc=$regc->tipo_documento;
$num_doc=$regc->num_documento;
$direc_cli=$regc->direccion;
$telf_cli=$regc->telefono;
$tipo_cliente=$regc->tipo_cliente;

//TRAEMOS LA INFORMACIÓN DEl VEHICULO
$vehiculo= new Vehiculo();
$rsptav=$vehiculo->mostrar_contrato($idvehiculo);
//recorremos todos los valores que obtengamos
$regv=$rsptav->fetch_object();

$vplaca=$regv->placa;
$vmarca=$regv->marca;
$vmodelo=$regv->modelo;
$vanio=$regv->anio;
$vcolor=$regv->color;
$vmotor=$regv->motor;
$combustible=$regv->combustible;

$idalquiler = $this->codigo;

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// set default header data
$PDF_HEADER_LOGO = "logo.jpg";//any image file. check correct path.
$PDF_HEADER_LOGO_WIDTH = "50";
$PDF_HEADER_TITLE = "www.lamarperu.com";
$PDF_HEADER_STRING = 'Telf: '.$telefono.' Direc: '.$direccion;
$pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);

$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.


$pdf->startPageGroup();

$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);
//$pdf->Header(true);
$pdf->AddPage();

// ---------------------------------------------------------
//$pdf->SetFont ("dejavusans", "", 10 , "", "default", true );
//$pdf->SetFont('dejavusans', '', 8, 20, false);
$bloque2 = <<<EOF
<div style="font-size:10px;">
<p align="center"><strong style="text-center"><u>CONTRATO DE ARRENDAMIENTO VEHICULAR</u></strong></p>
<p>Conste por el presente contrato de arrendamiento que celebran,
<ul>
<li>LAMAR PERU RENT A CAR con RUC 20548231184 y con domicilio en CALLE 2 DE MAYO #516
OF. 201 ZONA PABELLON B - MIRAFLORES; debidamente representado por su Gerente General
el Sr. Paul Rodrigo Pimentel Pimentel, con DNI N° 42325441 a quien en adelante se le
denominará <strong>EL ARRENDADOR.</strong></li><br>
<li> $ncliente con $tipo_doc N° $num_doc, con
domicilio en $direc_cli; a quien se
le denominará <strong>EL ARRENDATARIO</strong>, bajo las siguientes condiciones:</li>
</ul>
<strong>PRIMERO: EL ARRENDATARIO</strong> es una persona <strong> $tipo_cliente </strong> que alquila EL VEHICULO para uso particular.<br>
<strong>SEGUNDO: EL ARRENDADOR</strong> es una persona jurídica responsable de EL VEHICULO con las siguientes características:</p>
</div>
EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF
<table style="font-size:10px; padding:5px 10px;">
<tr>
<th style="border: 1px solid #666; width:110px; text-align:center">MARCA</th>
<th style="border: 1px solid #666; width:110px; text-align:center">MODELO</th>
<th style="border: 1px solid #666; width:110px; text-align:center">PLACA</th>
<th style="border: 1px solid #666; width:100px; text-align:center">AÑO</th>
<th style="border: 1px solid #666; width:100px; text-align:center">COLOR</th>
<th style="border: 1px solid #666; width:110px; text-align:center">MOTOR</th>
</tr>
<tr>
<td style="border: 1px solid #666; width:110px; text-align:center">$vmarca</td>
<td style="border: 1px solid #666; width:110px; text-align:center">$vmodelo</td>
<td style="border: 1px solid #666; width:110px; text-align:center">$vplaca</td>
<td style="border: 1px solid #666; width:100px; text-align:center">$vanio</td>
<td style="border: 1px solid #666; width:100px; text-align:center">$vcolor</td>
<td style="border: 1px solid #666; width:110px; text-align:center">$vmotor</td>
</tr>
</table>
EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------


$bloque4 = <<<EOF
<br>
<br>
<table style="font-size:10px; padding:5px 10px;">
<tr>
<td style="text-align:justify">
EL VEHICULO se entrega en óptimas condiciones.<br><br>
<strong>TERCERO:</strong> Por el presente contrato <strong>EL ARRENDADOR</strong> se
obliga a ceder en uso de las descritas en la cláusula
precedente y a la que se denomina EL BIEN, a favor de <strong>EL
ARRENDATARIO</strong> a título de arrendamiento. Por su parte, <strong>EL
ARRENDATARIO</strong> se obliga a pagar a <strong>EL ARRENDADOR</strong> el
monto de la renta pactada en la cláusula siguiente, en la
forma y oportunidad convenidas.
Asimismo <strong>EL ARRENDADOR</strong> y <strong>EL ARRENDATARIO</strong>, acuerda
que los anexos que formaran parte del contrato podrán
incrementarse a la relación de EL BIEN mencionado en el
párrafo precedente, debiendo contar dichos anexos con el
visto y conformidad de las partes contratantes.<br><br>
<b>CUARTO:</b> Las partes acuerdan que el monto de la renta diaria
que pagará en calidad de contraprestación por el uso real de
EL BIEN, que asciende a $new_simbolo. $por_dia diarios.<br><br>
<b>QUINTO:</b> Las partes convienen fijar un plazo de duración
determinada para el siguiente contrato, por $rega->dias días, desde
el $fecha_inicio Y finaliza $fecha_estimado.
HORA DE ENTREGA: $h_entrega_empresa.
Para la devolución del vehículo se da una hora (60 minutos)
de tolerancia sobre la hora pactada. Pasada la hora se
cobrará un día adicional.<br><br>
<b>SEXTO:</b> El pago se realizará en efectivo y por adelantado.<br><br>
<b>SEPTIMO: EL ARRENDATARIO</b> deja la suma de $new_simbolo. $garantia
($con_letra) en calidad de GARANTIA para
verificar papeletas y /o fotopapeletas.<br>
(*)El monto será devuelto después de 7 días hábiles de terminado el contrato.<br>
(*) Si el monto de la papeleta supera el importe de la
garantía, <b>EL ARRENDATARIO</b> deberá cancelar la diferencia en
un plazo no mayor de 7 días de haber sido impuesta la(s)
papeleta(s)<br><br>
<b>OCTAVO:</b><br><br>
<b>EL ARRENDADOR</b> se obliga:
<ul>
<li>A entregar EL BIEN en la fecha de inicio del plazo
de contrato, ésta obligación se verificará con la
entrega física del mismo, la llave y la tarjeta de
propiedad.</li>
<li>A entregar EL BIEN con SOAT y con póliza del
seguro vehicular vigente. Se precisa que El BIEN
cuenta con seguro contra todo riesgo.</li>
</ul>
<b>EL ARRENDATARIO</b> se obliga:
<ul>
<li>A pagar puntualmente el monto de la renta, en la
forma y oportunidad pactada, con sujeción a lo
convenido en las clausulas cuarta y sexta.</li>
<li>El kilometraje diario es de 200 km, el excedente será
asumido como cargo extra (S/.1.00) por kilómetro.</li>
<li>A destinar EL BIEN arrendado única y exclusivamente
para el uso PARTICULAR. Asimismo <b>EL ARRENDATARIO</b>
se obliga a conducir EL BIEN portando su licencia. En
consecuencia, queda establecido que 
<b>EL ARRENDATARIO</b> es la única persona autorizada para
conducir EL BIEN, NO PUDIENDO SUB-ARRENDAR EL BIEN,
así como proveer del combustible necesario para su
funcionamiento. <b>*PENALIDAD:</b> AL INCUMPLIMIENTO DE
ESTA CLAÚSULA EL ARRENDADOR DA POR CONCLUIDO EL
CONTRATO SIN LUGAR A DEVOLUCIÓN DE DINERO POR
CONCEPTO DE ARRENDAMIENTO Y/O GARANTÍA.</li>
<li>A devolver EL BIEN en la fecha de vencimiento del plazo
estipulado en la cláusula quinta de este contrato, en las
mismas condiciones con las que le fue arrendado salvo
el desgaste producido por el uso normal del mismo.
Serán de cuenta y cargo de <b>EL ARRENDATARIO</b> todo
desperfecto mecánico y daños que afecten el normal
funcionamiento de EL BIEN, por negligencia del manejo
y tratamiento del mismo.</li>
<li>Queda prohibido de introducir mejoras, cambios o
alteraciones internas y externas en los bienes y sus
accesorios, sin el consentimiento expreso y escrito de
<b>EL ARRENDADOR</b>.</li>
<li>Además, <b>EL ARRENDATARIO</b> está obligado a no
conducir EL BIEN en estos casos:<br>
1. En estado de ebriedad o bajo efectos de
calmantes,tranquilizantes o estados similares.<br>
2. Sin licencia de conducir válida o expedida por las
autoridades competentes.<br>
3. En violación de las reglas de tránsito respectivo.<br>
4. Fuera de las fronteras de la República del Perú.</li>
</ul>

<b>NOVENO:</b> Si <b>EL ARRENDATARIO</b> desea renovar el contrato,
se deberá comunicar por lo menos con 2 días calendario de
anticipación con una comunicación escrita de la otra parte.<br><br>
<b>DECIMO:</b> Las partes acuerdan que en caso de robo,
destrucción parcial o total, daños o pérdida de los bienes
materiales del presente contrato por caso imputable a <b>EL
ARRENDADOR</b>, será <b>EL ARRENDATARIO</b> quien asuma el
riesgo de tales acontecimientos dejando exentos de toda
responsabilidad a <b>EL ARRENDADOR</b>.<br>
El vehículo cuenta con una póliza de seguro contratada. <b>EL
ARRENDATARIO</b> se obliga a pagar los siniestros que no
fueren cubiertos por la aseguradora.<br>
En caso de siniestro, <b>EL ARRENDATARIO</b> pagará la
franquicia, el costo de los repuestos y/o accesorios que
deban adquirirse y el costo de la renta diaria por el plazo que
dure la reparación del vehículo. Si este fuese robado, pagará
la renta diaria hasta que la aseguradora pague el precio del
vehículo o lo reponga.<br><br>
<b>DECIMO PRIMERO:</b> Para efecto de cualquier controversia
que se genere con motivo de la celebración y ejecución de
este contrato, las partes se cometen a la competencia
territorial de los jueces y tribunal de la ciudad de Lima.<br><br>
<b>DECIMO SEGUNDO:</b> En lo no previsto por las partes en el
presente contrato, ambas partes se someten a lo establecido
por las normas de código civil y además de sistema jurídico
nacional que resulten aplicables.<br><br>
<b>DECIMO TERCERO:</b> En caso el arrendatario incumpla con las
cláusulas descritas en el presente contrato, <b>EL
ARRENDADOR</b> podrá bloquear o apagar la unidad vehicular
sin previo aviso.<br><br>
<b>DECIMO CUARTO:</b> Toda reparación de la unidad vehicular
será realizada en los talleres autorizados por la empresa.<br><br>
<b>DECIMO QUINTO:</b> En caso el "GPS" arrojará alertas por
exceso de velocidad la garantía será retenida hasta que la
multa figure en el sistema.
</td>
</tr>
</table>
EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

date_default_timezone_set('America/Lima');
//$fecha_hoy = date("Y-m-d");

$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
$months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");  
$year_now = date ("Y");  
$month_now = date ("n");  
$day_now = date ("j");  
$week_day_now = date ("w");  
$fecha_hoy = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;  


$bloque5 = <<<EOF
<br><br><p style="font-size:11px;">En señal de conformidad, las partes suscriben este documento, por duplicado en la ciudad de $ciudad con fecha $fecha_hoy.</p>

EOF;
//$pdf->SetXY(0, 250);
$pdf->writeHTML($bloque5, false, false, false, false, '');

$bloque6 = <<<EOF
<table border="0" align="center" style="text-center">
<tr>
<td><img src="images/firma.jpg" width="200" height="100"><br>
<b>EL ARRENDADOR</b><br>
PAUL RODRIGO PIMENTEL PIMENTEL 
</td>
<td>
<img src="../../files/firmas/$firmaCliente" width="200" height="100"><br>
<b>EL ARRENDATARIO</b><br>
$ncliente
</td>
</tr>
</table>
EOF;
$pdf->SetXY(20, 180);
$pdf->writeHTML($bloque6, false, false, false, false, '');


$pdf->AddPage();

$bloque7 = <<<EOF
<table border="0">
<br>
<tr>
<td><strong style="text-align: center; fon-size:12px;"><u>INVENTARIO VEHICULAR DE <i style="color:red;">ENTREGA</i></u></strong>
<p style="font-size:11px;">
Lima $fecha_hoy.<br>
Nombre o Razón Social: $nombre_empresa <br>
Punto de Entrega: $punto_entrega <br>
Hora de Entrega: $h_entrega_empresa<br>
N° de Placa: $vplaca <br>
KM: $km <br>
TIPO DE COMBUSTIBLE: $combustible <br><br><br>
Características del Vehículo puesto a su disposición:
</p>
</td>
<td style="text-align: center; fon-size:12px;"><img src="images/dash2.jpg" width="200" height="190"><br>
</td>
</tr>
</table>
EOF;
//$pdf->SetXY(20, 180);
//$pdf->writeHTML($bloque7, false, false, false, false, '');
//$pdf->setPage(2);
$pdf->writeHTML($bloque7, false, false, false, false, '');

// Arrows
//$pdf->Text(128, 25, 'Tanque de combustible');
$style5 = array('width' => 0.55, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(91, 88,88));
$pdf->SetLineStyle($style5);
$pdf->SetFillColor(255, 0, 0);
if($combustible_al==1){
$pdf->Arrow(149, 62, 140, 42, 3, 6, 15);
}elseif($combustible_al==2){
$pdf->Arrow(149, 62, 150, 40, 3, 6, 15);
}elseif($combustible_al==3){
$pdf->Arrow(149, 62, 159, 42, 3, 6, 15);
}elseif($combustible_al==4){
$pdf->Arrow(149, 62, 166, 48, 3, 6, 15);
}

$bloque8 = <<<EOF
<table style="font-size:10px; padding:5px 10px;">
<tr>
<th style="border: 1px solid #666; width:110px; text-align:center">MARCA</th>
<th style="border: 1px solid #666; width:110px; text-align:center">MODELO</th>
<th style="border: 1px solid #666; width:110px; text-align:center">PLACA</th>
<th style="border: 1px solid #666; width:100px; text-align:center">AÑO</th>
<th style="border: 1px solid #666; width:100px; text-align:center">COLOR</th>
<th style="border: 1px solid #666; width:110px; text-align:center">MOTOR</th>
</tr>
<tr>
<td style="border: 1px solid #666; width:110px; text-align:center">$vmarca</td>
<td style="border: 1px solid #666; width:110px; text-align:center">$vmodelo</td>
<td style="border: 1px solid #666; width:110px; text-align:center">$vplaca</td>
<td style="border: 1px solid #666; width:100px; text-align:center">$vanio</td>
<td style="border: 1px solid #666; width:100px; text-align:center">$vcolor</td>
<td style="border: 1px solid #666; width:110px; text-align:center">$vmotor</td>
</tr>
</table>
EOF;
$pdf->SetXY(15, 75);
$pdf->writeHTML($bloque8, false, false, false, false, '');



$bloque9 = <<<EOF
<table style="font-size:8px; padding:5px 10px;"> 
<tr>
<th style="border: 1px solid #666; width:143px; text-align:center">ACCESORIOS</th>
<th style="border: 1px solid #666; width:35px; text-align:center">SI</th>
<th style="border: 1px solid #666; width:35px; text-align:center">NO</th>
<th style="border: 1px solid #666; width:143px; text-align:center">ACCESORIOS</th>
<th style="border: 1px solid #666; width:35px; text-align:center">SI</th>
<th style="border: 1px solid #666; width:35px; text-align:center">NO</th>
<th style="border: 1px solid #666; width:144px; text-align:center">ACCESORIOS</th>
<th style="border: 1px solid #666; width:35px; text-align:center">SI</th>
<th style="border: 1px solid #666; width:35px; text-align:center">NO</th>
</tr>
</table>
EOF;
$pdf->SetXY(15, 90);
$pdf->writeHTML($bloque9, false, false, false, false, '');
$pdf->SetXY(15, 96);
//TRAEMOS LA INFORMACIÓN DEl ALQUILER
$rsptacc=$alquiler->accesorio_alquiler($_GET["id"]);
while ($regacc=$rsptacc->fetch_object()) {
if($regacc->accesorio_alquilado==1){
$item='<th style="border: 1px solid #666; width:35px; text-align:center">X</th>
<th style="border: 1px solid #666; width:35px; text-align:center"></th>';
}else{
$item='<th style="border: 1px solid #666; width:35px; text-align:center"></th>
<th style="border: 1px solid #666; width:35px; text-align:center">X</th>';
}
$accesorios = <<<EOF
<table style="font-size:8px; padding:2px" border="0"> 
<tr> 
<th style="border: 1px solid #666; width:143px;"> $regacc->nombre </th>
$item
</tr> 
</table><br>
EOF;
$pdf->writeHTML($accesorios, false, false, false, false, '');
}
$pdf->SetXY(75, 96);
//TRAEMOS LA INFORMACIÓN DEl ALQUILER
$rsptac1=$alquiler->accesorio_alquilerdos($_GET["id"]);
while ($regac1=$rsptac1->fetch_object()) {
if($regac1->accesorio_alquilado==1){
$item1='<th style="border: 1px solid #666; width:35px; text-align:center">X</th>
<th style="border: 1px solid #666; width:35px; text-align:center"></th>';
}else{
$item1='<th style="border: 1px solid #666; width:35px; text-align:center"></th>
<th style="border: 1px solid #666; width:35px; text-align:center">X</th>';
}
$accesorios1 = <<<EOF
<table style="font-size:8px; padding:2px"> 
<tr> 
<th style="border: 1px solid #666; width:143px;"> $regac1->nombre </th>
$item1 
</tr>
</table>
EOF;
$pdf->writeHTML($accesorios1, false, false, false, false, '');
}
$pdf->SetXY(135, 96);
//TRAEMOS LA INFORMACIÓN DEl ALQUILER
$rsptac2=$alquiler->accesorio_alquilertres($_GET["id"]);
while ($regac2=$rsptac2->fetch_object()) {
if($regac2->accesorio_alquilado==1){
$item2='<th style="border: 1px solid #666; width:35px; text-align:center">X</th>
<th style="border: 1px solid #666; width:35px; text-align:center"></th>';
}else{
$item2='<th style="border: 1px solid #666; width:35px; text-align:center"></th>
<th style="border: 1px solid #666; width:35px; text-align:center">X</th>';
}
$accesorios2 = <<<EOF
<table style="font-size:8px; padding:2px"> 
<tr> 
<th style="border: 1px solid #666; width:145px;"> $regac2->nombre </th>
$item2 
</tr>
</table>
EOF;
$pdf->writeHTML($accesorios2, false, false, false, false, '');
}
$bloque10 = <<<EOF
<table>
<td style="text-align: center; fon-size:12px;"><img src="images/carros.jpg" width="950" height="350"><br>
</td>
</table>
EOF;
$pdf->SetXY(15, 145);
$pdf->writeHTML($bloque10, false, false, false, false, '');

$bloque11 = <<<EOF
<table border="0">
<tr>
<td>
Observaciones: $observaciones<br>
</td>
</tr>
<tr>
<td style=" width:210px;">
<img src="../../files/firmas/$firmaCliente" width="200" height="100"><br>ARRENDATARIO</td>
<td style=" width:210px; text-align:center">
<br><img src="images/firma.jpg" width="200" height="100"><br>
LAMAR PERU  
</td>
<td><img src="images/leyenda.jpg" width="250" height="120"><br>
</td>
</tr>

</table>
EOF;
$pdf->SetXY(15, 220);
$pdf->writeHTML($bloque11, false, false, false, false, '');


$pdf->AddPage();
$bloque12 = <<<EOF

<table border="0">
<tr>
<td><strong style="text-align: center; fon-size:12px;"><u>INVENTARIO VEHICULAR DE <i style="color:red;">RECEPCION</i></u></strong>
<p style="font-size:11px;">
Lima $fecha_hoy.<br>
Nombre o Razón Social: $nombre_empresa<br>
Punto de Entrega: $punto_recepcion<br>
Hora de Entrega: $h_entrega <br>
N° de Placa: $vplaca <br>
KM: $km_entrega <br>
TIPO DE COMBUSTIBLE: $combustible <br><br><br>
Características del Vehículo puesto a su disposición:
</p>
</td>
<td style="text-align: center; fon-size:12px;"><img src="images/dash2.jpg" width="200" height="190"><br>
</td>
</tr>
</table>
EOF;
//$pdf->SetXY(15, 220);
//$pdf->writeHTML($bloque12, false, false, false, false, '');
//$pdf->setPage(2);
$pdf->writeHTML($bloque12, false, false, false, false, '');

// Arrows
//$pdf->Text(128, 25, 'Tanque de combustible');
$style5 = array('width' => 0.55, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(91, 88,88));
$pdf->SetLineStyle($style5);
$pdf->SetFillColor(255, 0, 0);
if($combustible_dev==1){
$pdf->Arrow(149, 62, 140, 42, 3, 6, 15);
}elseif($combustible_dev==2){
$pdf->Arrow(149, 62, 150, 40, 3, 6, 15);
}elseif($combustible_dev==3){
$pdf->Arrow(149, 62, 159, 42, 3, 6, 15);
}elseif($combustible_dev==4){
$pdf->Arrow(149, 62, 166, 48, 3, 6, 15);
}

$bloque13 = <<<EOF
<table style="font-size:10px; padding:5px 10px;">
<tr>
<th style="border: 1px solid #666; width:110px; text-align:center">MARCA</th>
<th style="border: 1px solid #666; width:110px; text-align:center">MODELO</th>
<th style="border: 1px solid #666; width:110px; text-align:center">PLACA</th>
<th style="border: 1px solid #666; width:100px; text-align:center">AÑO</th>
<th style="border: 1px solid #666; width:100px; text-align:center">COLOR</th>
<th style="border: 1px solid #666; width:110px; text-align:center">MOTOR</th>
</tr>
<tr>
<td style="border: 1px solid #666; width:110px; text-align:center">$vmarca</td>
<td style="border: 1px solid #666; width:110px; text-align:center">$vmodelo</td>
<td style="border: 1px solid #666; width:110px; text-align:center">$vplaca</td>
<td style="border: 1px solid #666; width:100px; text-align:center">$vanio</td>
<td style="border: 1px solid #666; width:100px; text-align:center">$vcolor</td>
<td style="border: 1px solid #666; width:110px; text-align:center">$vmotor</td>
</tr>
</table>
EOF;
$pdf->SetXY(15, 75 );
$pdf->writeHTML($bloque13, false, false, false, false, ''); 





$bloque14 = <<<EOF
<table style="font-size:8px; padding:5px 10px;"> 
<tr>
<th style="border: 1px solid #666; width:143px; text-align:center">ACCESORIOS</th>
<th style="border: 1px solid #666; width:35px; text-align:center">SI</th>
<th style="border: 1px solid #666; width:35px; text-align:center">NO</th>
<th style="border: 1px solid #666; width:143px; text-align:center">ACCESORIOS</th>
<th style="border: 1px solid #666; width:35px; text-align:center">SI</th>
<th style="border: 1px solid #666; width:35px; text-align:center">NO</th>
<th style="border: 1px solid #666; width:144px; text-align:center">ACCESORIOS</th>
<th style="border: 1px solid #666; width:35px; text-align:center">SI</th>
<th style="border: 1px solid #666; width:35px; text-align:center">NO</th>
</tr>
</table>
EOF;
$pdf->SetXY(15, 90);
$pdf->writeHTML($bloque14, false, false, false, false, '');

$pdf->SetXY(15, 96);
//TRAEMOS LA INFORMACIÓN DEl ALQUILER
$rsptacd=$alquiler->accesorio_alquiler($_GET["id"]);
while ($regacd=$rsptacd->fetch_object()) {
if($regacd->accesorio_devuelto==1){
$item='<th style="border: 1px solid #666; width:35px; text-align:center">X</th>
<th style="border: 1px solid #666; width:35px; text-align:center"></th>';
}else{
$item='<th style="border: 1px solid #666; width:35px; text-align:center"></th>
<th style="border: 1px solid #666; width:35px; text-align:center">X</th>';
}
$accesoriosd = <<<EOF
<table style="font-size:8px; padding:2px" border="0"> 
<tr> 
<th style="border: 1px solid #666; width:143px;"> $regacd->nombre </th>
$item
</tr> 
</table><br>
EOF;
$pdf->writeHTML($accesoriosd, false, false, false, false, '');
}
$pdf->SetXY(75, 96);
//TRAEMOS LA INFORMACIÓN DEl ALQUILER
$rsptac1d=$alquiler->accesorio_alquilerdos($_GET["id"]);
while ($regac1d=$rsptac1d->fetch_object()) {
if($regac1d->accesorio_devuelto==1){
$item1='<th style="border: 1px solid #666; width:35px; text-align:center">X</th>
<th style="border: 1px solid #666; width:35px; text-align:center"></th>';
}else{
$item1='<th style="border: 1px solid #666; width:35px; text-align:center"></th>
<th style="border: 1px solid #666; width:35px; text-align:center">X</th>';
}
$accesorios1d = <<<EOF
<table style="font-size:8px; padding:2px"> 
<tr> 
<th style="border: 1px solid #666; width:143px;"> $regac1d->nombre </th>
$item1 
</tr>
</table>
EOF;
$pdf->writeHTML($accesorios1d, false, false, false, false, '');
}
$pdf->SetXY(135, 96);
//TRAEMOS LA INFORMACIÓN DEl ALQUILER
$rsptac2d=$alquiler->accesorio_alquilertres($_GET["id"]);
while ($regac2d=$rsptac2d->fetch_object()) {
if($regac2d->accesorio_devuelto==1){
$item2='<th style="border: 1px solid #666; width:35px; text-align:center">X</th>
<th style="border: 1px solid #666; width:35px; text-align:center"></th>';
}else{
$item2='<th style="border: 1px solid #666; width:35px; text-align:center"></th>
<th style="border: 1px solid #666; width:35px; text-align:center">X</th>';
}
$accesorios2d = <<<EOF
<table style="font-size:8px; padding:2px"> 
<tr> 
<th style="border: 1px solid #666; width:145px;"> $regac2d->nombre </th>
$item2 
</tr>
</table>
EOF;
$pdf->writeHTML($accesorios2d, false, false, false, false, '');
}


$bloque15 = <<<EOF
<table>
<td style="text-align: center; fon-size:12px;"><img src="images/carros.jpg" width="950" height="350"><br>
</td>
</table>
EOF;
$pdf->SetXY(15, 145);
$pdf->writeHTML($bloque15, false, false, false, false, '');

$bloque16 = <<<EOF
<table border="0">
<tr>
<td>
Observaciones: $observaciones<br>
</td>
</tr>
<tr>
<td style=" width:210px;">
<br>
<img src="../../files/firmas/$firmaCliente" width="200" height="100"><br>ARRENDATARIO</td>
<td style=" width:210px; text-align:center">
<br><img src="images/firma.jpg" width="200" height="100"><br>
LAMAR PERU  
</td>
<td><img src="images/leyenda.jpg" width="250" height="120"><br>
</td>
</tr>

</table>
EOF;
$pdf->SetXY(15, 220);
$pdf->writeHTML($bloque16, false, false, false, false, '');
// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 


ob_end_clean();
$pdf->Output('contrato.pdf', 'I');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["id"];
$factura -> traerImpresionFactura();

}else{
echo "No tiene permiso para visualizar el reporte";
}

}

ob_end_flush();
?>