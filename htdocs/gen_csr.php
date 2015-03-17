<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <title>OneCert CSR-Generator</title>
  </head>
   <body text="#202040" bgcolor="#C0C0C0">

<?php
	// Diese Seite dient dem Generieren der angegebenen CSR Datei
	
	// Einbinden der Datei funktionen.php 
	require_once('funktionen.php');
	checklogin();	
	
	//Übergabe Username zum Zugriff auf die entsprechenden Verzeichnisse
	$_username = $_SESSION['username'];
	$path = "C:/kunden/csr/$_username";
	
	  //Übergabe der POST Variablen
	  $cdomain = $_POST["cdomain"];
	  $corganisation = $_POST["corganisation"];
	  $cabteilung = $_POST["cabteilung"];
	  $cprovinz = $_POST["cprovinz"];
	  $cland = $_POST["cland"];
	  $cort = $_POST["cort"];
	  $ckey = $_POST["ckey"];
	  $cmail = $_POST["cmail"];
	 /* $san1 = $_POST["dns1"];
	  $san2 = $_POST["dns2"];
	  $san3 = $_POST["dns3"];
	  $san4 = $_POST["ip1"];
	  $san5 = $_POST["ip2"];
	  $san6 = $_POST["ip3"]; */
	  
	  $cdomainurl=str_replace("*","", $cdomain); 
	  
	// Kundenordner anlegen, falls noch nicht vorhanden
	if (!file_exists($path))
	  {
		mkdir($path, 0700);		 
	  }
	
		// Angegebene Daten in einer Musterconfig ändern und in eine neue Config im Kundenordner ablegen
		$fp = fopen("$path/$cdomainurl.cnf", 'a+');
		$config = file("C:/Onecert/intermediate/client.cnf");
		$config[150] = "commonName_default = $cdomain \n";
		$config[139] = "0.organizationName_default	= $corganisation \n";
		$config[146] = "organizationalUnitName_default	= $cabteilung \n";
		$config[134] = "stateOrProvinceName_default	= $cprovinz \n";
		$config[129] = "countryName_default		= $cland \n";
		$config[137] = "localityName_default		= $cort \n";
		$config[106] = "default_bits		= $ckey \n";
		$config[152] = "emailAddress			= $cmail \n";
		
		/*
		if (isset($san1) && $san1 != '')
				{
					$config[356] = "DNS.1 = $san1 \n";
				}
		if (isset($san2) && $san2 != '')
				{
					$config[357] = "DNS.2 = $san2 \n";
				}
		if (isset($san3) && $san3 != '')
				{
					$config[358] = "DNS.3 = $san3 \n";
				}
		if (isset($san4) && $san4 != '')
				{
					$config[359] = "DNS.4 = $san4 \n";
				}
		if (isset($san5) && $san5 != '')
				{
					$config[360] = "DNS.5 = $san5 \n";
				}
		if (isset($san6) && $san6 != '')
				{
					$config[361] = "DNS.6 = $san6 \n";
				}		
*/
		fwrite($fp, implode($config));
		
		// Schlüsselpaar erzeugen
		System("cmd /c openssl genrsa -out $path/$cdomainurl.key $ckey");
		
		// CSR erzeugen
		System("cmd /c openssl req -new -key $path/$cdomainurl.key -out $path/$cdomainurl.csr -config $path/$cdomainurl.cnf -sha256 -batch");
		

	//Private Key in Textfeld ausgeben
   
		echo "<h2>CSR erfolgreich generiert:</h2>
			<fieldset>                              
        <legend><h3>Ihr Private-Key: (bitte sorgf&auml;ltig aufbewahren)</h3></legend>";		
		echo "<textarea wrap=\"off\" type=\"text\" cols=\"65\" rows=\"10\" name=\"RSA-Key Ausgabe\">"; 
		echo System("cmd /c openssl rsa -in $path/$cdomainurl.key");
		echo "</textarea></fieldset>";

	// CSR in Textfeld ausgeben
	
		echo "<fieldset>                              
        <legend><h3>Ihre CSR-Datei: </h3></legend>";		
		echo "<textarea wrap=\"off\" type=\"text\" cols=\"65\" rows=\"10\" name=\"CSR Ausgabe\">"; 
		echo System("cmd /c openssl req -in $path/$cdomainurl.csr");
		echo "</textarea></fieldset>";		
		

		
	// Code zum selbst generieren
	
		echo "<fieldset>                              
        <legend><h3>Oder Keys und CSR selbst generieren:</h3></legend>";		
		echo "<textarea wrap=\"off\" type=\"text\" cols=\"65\" rows=\"10\" name=\"CSR Ausgabe\">"; 
		echo "Code um Schl&uuml;sselpaar zu generieren: \n";
		echo "openssl genrsa -out $cdomainurl.key $ckey \n\n";
		echo "Code um CSR zu generieren: \n";
		echo "openssl req -new -key $cdomainurl.key -out $cdomainurl.csr -config openssl.cnf -sha256 \n\n";		
		echo "</textarea></fieldset>";		
		
		echo "<fieldset> </fieldset>";
		
		//.key Datei vom Server löschen
		unlink("$path/$cdomainurl.key");
		
		
		
		// CSR anzeigen lassen
		//System("cmd /c openssl req -in $path/$cdomainurl.csr -noout -text");
		
		// Zertifikat erstellen
		//System("cmd /c openssl ca -config $path/$cdomainurl.cnf -in $path/$cdomainurl.csr -out $path/$cdomainurl.crt -batch");
		
		// Zertifikat anzeigen lassen
		//System("cmd /c openssl x509 -in $path/$cdomainurl.crt -noout -text");
		
		echo '<fieldset>                          
			<a href="uebersicht.php">Zur&uuml;ck zur &Uuml;bersicht </a>
			<a href="logout.php">Logout</a>
      </fieldset>';
		
?>
  
  </body>  
</html>