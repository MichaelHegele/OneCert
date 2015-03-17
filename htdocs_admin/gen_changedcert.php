<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Zertifikat generiert.</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="F0F8FF">
  
  <?php
    // Einbinden der Datei funktionen.php 
	require_once('funktionen.php');
	checklogin();
  
    echo '<h2>Zertifikat erfolgreich generiert.</h2>
	  <fieldset>';                          
		
		$path = $_GET["path"];
		$file = $_GET["file"];
		$csrpath = $path.$file;
		$domainname = $_GET["cn"];
		
		// bestellte Laufzeit auslesen
		$file1 = substr($file,0,-4);
		$laufzeit = file("$path$file1.lz");
		$_zdays = $laufzeit[0];
				
		// Das Array mit dem Pfad mit Trennzeichen / auftrennen um den Besteller zu bekommen
		$_array = explode( '/', $path );
		$username = $_array[3];
		
		// Config-Datei mit dem neuen CSR-Subject auslesen
			$subject = file("$path/$domainname.cfg");
			// CSR Subject lokalen Variablen zuweisen und letztes Zeichen (Leerzeichen) abschneiden
			$ztype = substr($subject[0],0,-1);
			$CN = substr($subject[1],0,-2);
			$CNst = substr($subject[1],0,-2);
			$O = substr($subject[2],0,-2);
			$OU = substr($subject[3],0,-2);
			$C = substr($subject[4],0,-2);
			$L = substr($subject[5],0,-2);
			$ST = substr($subject[6],0,-2);
		

		// Prüfen ob San, Standard oder Wild
			if (strpos($csrpath,'typ_standard') !== false) 
			{
				$ztype = "Standard-Zertifikat";
				$typ = "standard";
				$_typ = "typ_standard";
			}
			if (strpos($csrpath,'typ_wildcard') !== false) {
				$ztype = "Wildcard-Zertifikat";
				$typ = "wildcard";
				$_typ = "typ_wildcard";
				$CN=str_replace("*","", $CN);
				$domainname=str_replace("*","", $domainname);
			}		
			if (strpos($csrpath,'typ_san') !== false) {
				$ztype = "SAN-Zertifikat";
				$typ = "san";
				$_typ = "typ_san";
			}					

			
			// Hier kommt der Code zum generieren des Zertifikats
			// Zusätzlich bei Erfolgreich CSR löschen
			// Anschließend Daten des generierten Zertifikats anzeigen
			
			$interconf = "../../Onecert/intermediate/intermediate.cnf";
			
			if(strpos($ztype,'SAN') !== false)
			{
			System("cmd /c openssl ca -days $_zdays -config $interconf -in $csrpath -out $path/$CN.crt -subj \"/CN=$CNst/O=$O/OU=$OU/L=$L/C=$C/ST=$ST\" -extfile $path/ext_$domainname.cfg -batch");
			}
			else
			{
			System("cmd /c openssl ca -days $_zdays -config $interconf -in $csrpath -out $path/$CN.crt -subj \"/CN=$CNst/O=$O/OU=$OU/L=$L/C=$C/ST=$ST\" -batch");
			}
			

			echo "Das $ztype f&uuml;r $CN wurde erfolgreich generiert: ";
			echo "<br \>";
			echo "<br \><fieldset><b>Herausgeber: </b><br \>";
			System("cmd /c openssl x509 -noout -issuer -in $path/$CN.crt");
			echo "</fieldset>";
			echo "<br \><fieldset><b>G&uuml;ltigkeit: </b><br \>";
			System("cmd /c openssl x509 -noout -dates -in $path/$CN.crt");
			echo "</fieldset>";
			echo "<br \><fieldset><b>Kunden-&Uuml;bersicht: </b><br \>";
			System("cmd /c openssl x509 -noout -subject -in $path/$CN.crt");
			echo "</fieldset>";					
			echo "<br \><fieldset><b>Zertifikatsdaten: </b><br \>";
			System("cmd /c openssl x509 -in $path/$CN.crt -noout -text");
			echo "</fieldset>";			
			
			
			rename("$csrpath","$path$CN.done");
			rename("$path$file1.lz","$path$CN.lz");	
			
			//Als Zip packen und speichern
			$zip = new ZipArchive;
			
			$_zipdatei = $path . $CN . ".zip";
			$_crtdatei = $path . $CN . ".crt";
			
			if ($zip->open($_zipdatei, ZIPARCHIVE::CREATE) === TRUE) {
			$zip->addFile($_crtdatei, $CN . '.crt');
			$zip->addFile("C:\Onecert\intermediate\intermediate.crt", "onecert_intermediate.crt");
			$zip->close();
			//echo 'ok';
			} else {
			//echo 'Fehler';
			}
			
			//SQL Statement für DB Insert
			$_sql = "INSERT INTO `zertifikate` (`kusername`,`ztyp`, `zdomain`)
					VALUES ('$username', '$_typ', '$CN')";
				
			//Insert ausführen
			$_erg = DBQuery($_sql);
		?>
	  
      </fieldset>
	</form>
	<br />
	<fieldset>                          
			<a href="uebersicht.php">Zur&uuml;ck zum Admin-Frontend</a>
      </fieldset>
	<br />
	<fieldset>                          
			<a href="logout.php">Logout</a>
      </fieldset>
  </body>
</html>
