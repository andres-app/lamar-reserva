<?php
	header('Content-Type: text/plain');

	require ("src/autoload.php");

	$cliente = new \Sunat\Sunat();
	
	$ruc = ( isset($_REQUEST["nruc"]))? $_REQUEST["nruc"] : false;
	//$ruc="11756177945";
	echo $cliente->search( $ruc, true );
?>
