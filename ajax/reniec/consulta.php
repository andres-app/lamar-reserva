<?php

	$ruc=(isset($_REQUEST["nruc"]))? $_REQUEST["nruc"] : false;
	$my_url = urlencode($ruc);
	$url="https://dni.optimizeperu.com/api/persons/".$my_url."?format=json";
    function curl($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); 
        $info = curl_exec($ch); 
        curl_close($ch); 
        return $info; 
    }

    $sitioweb = curl($url);
	echo ($sitioweb);
