<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>CSR-Bestell&uuml;bersicht</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="F0F8FF">
  <?php
	//Diese Seite dient zur Überprüfung von eingegangenen Bestellungen  
  
	// Einbinden der Datei funktionen.php
	require_once('funktionen.php');
	checklogin();
  
    echo '<h2>Bitte pr&uuml;fen Sie den Certificate Signing Request:</h2>

	  <form name="Generate" action="generate_cert.php" method="post">
      <fieldset>                          
        <table border="1">';
		
		$path = $_GET["path"];		
		$file = $_GET["file"];		
		$csrpath = $path.$file;
		echo "<br /><br />";
		//Auslesen der CSR Daten und Speichern in einem Array
		$csr = file_get_contents("$csrpath");
		
		$array = array();
		$array = openssl_csr_get_subject($csr);
		
		//auslesen der bestellten Laufzeit
		$file1 = substr($file,0,-4);
		$laufzeit = file("$path$file1.lz");
		$_zdays = $laufzeit[0];
		$_zjahr = $_zdays/365;
		
		//Prüfen ob Standard, Wild, San
		if (strpos($csrpath,'typ_standard') !== false) 
		{
			$ztype = "Standard Zertifikat";
			$typ = "standard";
		}
		if (strpos($csrpath,'typ_wildcard') !== false) {
			$ztype = "Wildcard Zertifikat";
			$typ = "wildcard";
		}		
		if (strpos($csrpath,'typ_san') !== false) {
			$ztype = "SAN Zertifikat";
			$typ = "san";
		//auslesen der Sans
		$san = file("$path/$file1.cfg");
		}
		//Ausgabe in Tabellenform und Link zum Genehmigen generieren
		echo "<tr><td>Zertifikatstyp: </td><td> ".@$ztype."</tr></td>";
		echo "<tr><td>Domainname: </td><td> ".@$array[CN]."</tr></td>";
		echo "<tr><td>Organisation: </td><td> ".@$array[O]."</tr></td>";
		echo "<tr><td>Abteilung: </td><td> ".@$array[OU]."</tr></td>";
		echo "<tr><td>Land: </td><td> ".@$array[C]."</tr></td>";
		echo "<tr><td>Ort: </td><td> ".@$array[L]."</tr></td>";
		echo "<tr><td>Region: </td><td> ".@$array[ST]."</tr></td>";
		echo "<tr><td>Laufzeit: </td><td> ".@$_zdays." Tage - ".@$_zjahr." Jahr(e) </tr></td>";
		
		if (strpos($ztype,'SAN') !== false) {
			echo "<tr><td>SANs: </td><td> ".@$san[0]."</tr></td>";
		}
		echo "</table>";
		echo "<br />";	
				echo "<fieldset><a href=\"generate_cert.php?path=$path&file=$file&cn=$array[CN]\">Direkt genehmigen / Zertifikat generieren</a>
					</fieldset>";
				echo "<fieldset><a href=\"change_crt.php?path=$path&file=$file&cn=$array[CN]\">Daten ändern / Zertifikat generieren</a>
					</fieldset>";						
		echo "<br />";	
		echo "<fieldset>";
		System("cmd /c openssl req -in $csrpath -noout -text");	
		echo "</fieldset>";
		echo "<br />";	
				echo "<fieldset><a href=\"uebersicht.php\">Zur&uuml;ck zur &Uuml;bersicht</a>
					</fieldset>";
		echo '<br />';
		echo '<fieldset>                          
			<a href="logout.php">Logout</a>
      </fieldset>';

		?>

      </fieldset>
	  
      <br>

	</form>
  </body>
</html>
