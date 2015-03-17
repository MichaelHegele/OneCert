<?php
	//Funktion um Verbindung zur Datenbank herzustellen
	function DBQuery($_sql)
    {
		// File mit Verbindungsdaten zur MYSQL Datenbank
        require_once ('konfiguration.php');
        $_db = mysqli_connect ( MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT, MYSQL_DATENBANK );
        if(!$_db)
        {
            echo '<p>Verbindung zur Datenbank nicht m&oumlglich!</p>';
        }
        else
        {
            $_erg = mysqli_query($_db, $_sql);
            if(!$_erg)
            {
                echo '<p>Fehler in der Abfrage. Die Abfrage konnte nicht ausgef&uumlhrt werden!</p>';
            }
            else
            {  
                return $_erg;
            }
            mysqli_close($_db);
        }
    }
	
	// Prüfen ob ein User eingeloggt ist, wenn nicht auf login.php bleiben
	function checklogin()
	{
		session_start();
		if($_SESSION["onecert"] != true)
		{	
			$_host  = $_SERVER["HTTP_HOST"];
			$_uri   = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
			$_extra = "login.php";
			header("Location: http://$_host$_uri/$_extra");
			exit;
		}
	}
	// Funktion für den Download der gebundenen Zip-Dateien
	
	/*Funktion würde den direkten Download der .crt Datei ermöglichen
	function download($_path, $_domain)
	{
		$downloadfile = $_path . $_domain . ".crt";
		$filename = $_domain . ".crt";
		$filesize = filesize($downloadfile);
		
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: text/plain");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=" . $filename); 
		header("Content-Length: " . $filesize);
		header("Content-Transfer-Encoding: binary");

		readfile($downloadfile);
		exit;

	}*/
	
	function downloadzip($_path, $_domain)
	{
		$downloadfile = $_path . $_domain . ".zip";
		$filename = $_domain . ".zip";
		$filesize = filesize($downloadfile);
		
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/zip");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=" . $filename); 
		header("Content-Length: " . $filesize);
		header("Content-Transfer-Encoding: binary");

		readfile($downloadfile);
		exit;

	}
?>