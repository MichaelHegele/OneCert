<?php
	// Diese Seite dient für die Logout Funktion -> Session zurücksetzen und Weiterleitung auf login.php
	session_start();	
	$_SESSION["onecert"] = false;
	session_destroy();
	
	$_host  = $_SERVER["HTTP_HOST"];
	$_uri   = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
	$_extra = "login.php";
	header("Location: http://$_host$_uri/$_extra");
	exit;
?>