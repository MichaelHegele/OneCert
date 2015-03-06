<?php
	require_once('funktionen.php');
	checklogin();
	
	$_path = $_POST["path"];
	$_domain = $_POST["domain"];

	downloadzip($_path, $_domain);
	  ?>