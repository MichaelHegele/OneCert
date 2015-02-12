<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Zertifikat generiert.</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="#C0C0C0">
  
  <?php
	require_once('funktionen.php');
	checklogin();
	
	if($_SESSION['username'] != 'admin')
			{	
				$_host  = $_SERVER['HTTP_HOST'];
				$_uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				$_extra = 'uebersicht.php';
				header("Location: http://$_host$_uri/$_extra");
				exit;
			}
  
    echo '<h2>Zertifikat erfolgreich generiert.</h2>
	  <fieldset>';                          
		
		$path = $_GET["path"];
		$file = $_GET["file"];
		$csrpath = $path.$file;
		$domainname = $_GET["cn"];
		
		$_array = explode( '/', $path );
		$username = $_array[3];
		
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
			}		
			if (strpos($csrpath,'typ_san') !== false) {
				$ztype = "SAN-Zertifikat";
				$typ = "san";
				$_typ = "typ_san";
			}
			
			// Hier kommt der Code zum generieren des Zertifikats
			// Zusätzlich bei Erfolgreich CSR löschen
			
			$interconf = "../../Onecert/intermediate/intermediate.cnf";
			
			System("cmd /c openssl ca -config $interconf -in $csrpath -out $path/$domainname.crt -batch");	

			echo "Das $ztype f&uuml;r $domainname wurde erfolgreich generiert: ";
			echo "<br \>";
			echo "<br \><fieldset><b>Herausgeber: </b><br \>";
			System("cmd /c openssl x509 -noout -issuer -in $path/$domainname.crt");
			echo "</fieldset>";
			echo "<br \><fieldset><b>G&uuml;ltigkeit: </b><br \>";
			System("cmd /c openssl x509 -noout -dates -in $path/$domainname.crt");
			echo "</fieldset>";
			echo "<br \><fieldset><b>Kunden-&Uuml;bersicht: </b><br \>";
			System("cmd /c openssl x509 -noout -subject -in $path/$domainname.crt");
			echo "</fieldset>";					
			echo "<br \><fieldset><b>Zertifikatsdaten: </b><br \>";
			System("cmd /c openssl x509 -in $path/$domainname.crt -noout -text");
			echo "</fieldset>";			
			echo "<a href=\"admin.php\">Zur&uuml;ck zum Admin-Frontend</a>";
			
			rename("$csrpath","$path$domainname.done");
			
			$zip = new ZipArchive;
			
			$_zipdatei = $path . $domainname . ".zip";
			$_crtdatei = $path . $domainname . ".crt";
			
			if ($zip->open($_zipdatei, ZIPARCHIVE::CREATE) === TRUE) {
			$zip->addFile($_crtdatei, $domainname . '.crt');
			$zip->addFile("C:\Onecert\intermediate\intermediate.crt", "onecert_intermediate.crt");
			$zip->close();
			//echo 'ok';
			} else {
			//echo 'Fehler';
			}
			
			$_sql = "INSERT INTO `zertifikate` (`kusername`,`ztyp`, `zdomain`)
					VALUES ('$username', '$_typ', '$domainname')";
					
			$_erg = DBQuery($_sql);
		?>
	  
      </fieldset>
	</form>
	<br />
	<fieldset>                          
			<a href="logout.php">Logout</a>
      </fieldset>
  </body>
</html>
