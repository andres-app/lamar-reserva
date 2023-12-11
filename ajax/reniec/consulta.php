<?php
		$ruc=(isset($_REQUEST["nruc"]))? $_REQUEST["nruc"] : false;

		$my_url = urlencode($ruc);
		$data = file_get_contents("https://dni.optimizeperu.com/api/persons/".$my_url."?format=json");
		$info = json_decode($data, true);
		echo ($data);
