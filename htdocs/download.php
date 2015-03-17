<?php
	// Einbinden der Datei funktionen.php 
	require_once('funktionen.php');
	checklogin();
	
	// Funktion um den Dateidownload zu ermöglichen -> Übergabe Pfad und Domainname
	
	$_path = $_POST["path"];
	$_domain = $_POST["domain"];

	downloadzip($_path, $_domain);
	  ?>