<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Daten ändern:</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="F0F8FF">
  
  <?php
    // Einbinden der Datei funktionen.php 
	require_once('funktionen.php');
	checklogin();
	
		$path = $_GET["path"];
		$file = $_GET["file"];
		$csrpath = $path.$file;
		$domainname = $_GET["cn"];
		
		//Auslesen der CSR Daten und Speichern in einem Array
		$csr = file_get_contents("$csrpath");
		
		$array = array();
		$array = openssl_csr_get_subject($csr);
		
		$url = "\?path=$path&file=$file&cn=$domainname";
		
		echo '<h2>Welche Daten sollen geändert werden?</h2>

	  <form name="Change" action="change_crt.php'.$url.'" method="post">
      <fieldset>                          
        <table border="1">';         
	
		// bestellte Laufzeit auslesen
		$file1 = substr($file,0,-4);
		$laufzeit = file("$path$file1.lz");
		$_zdays = $laufzeit[0];
		
		// Das Array mit dem Pfad mit Trennzeichen / auftrennen um den Besteller zu bekommen
		$_array = explode( '/', $path );
		$username = $_array[3];
		
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
				$cdomain = $domainname;
				$domainname=str_replace("*","", $domainname); 
			}		
			if (strpos($csrpath,'typ_san') !== false) {
				$ztype = "SAN-Zertifikat";
				$typ = "san";
				$_typ = "typ_san";
			}
			
			// CSR Subject in eine externe Datei schreiben
			$newline = "\r\n";
			$dateihandle = fopen("$path/tmp_$domainname.cfg","w");
			fwrite($dateihandle, @$ztype);
			fwrite($dateihandle, $newline);
			fwrite($dateihandle, @$array[CN]);
			fwrite($dateihandle, $newline);		
			fwrite($dateihandle, @$array[O]);
			fwrite($dateihandle, $newline);		
			fwrite($dateihandle, @$array[OU]);
			fwrite($dateihandle, $newline);		
			fwrite($dateihandle, @$array[C]);
			fwrite($dateihandle, $newline);		
			fwrite($dateihandle, @$array[L]);
			fwrite($dateihandle, $newline);		
			fwrite($dateihandle, @$array[ST]);
			fclose($dateihandle);
			
			// Temp-Datei mit dem CSR-Subject auslesen
			$subject = file("$path/tmp_$domainname.cfg");
			// CSR Subject lokalen Variablen zuweisen und letztes Zeichen (Leerzeichen) abschneiden
			$ztype = substr($subject[0],0,-1);
			$CN = substr($subject[1],0,-1);
			$O = substr($subject[2],0,-1);
			$OU = substr($subject[3],0,-1);
			$C = substr($subject[4],0,-1);
			$L = substr($subject[5],0,-1);
			$ST = $subject[6];
			
				// Ausgabe der CSR Daten

				echo "<tr><td>Zertifikatstyp: </td><td> ".@$ztype."</td></tr></td>";
				echo "<tr><td>Domainname: </td><td><input type=\"text\" name=\"domainname\" size=\"30\" value=\"$CN\"/></tr></td>";
				echo "<tr><td>Organisation: </td><td><input type=\"text\" name=\"organisation\" size=\"30\" value=\"$O\"/></tr></td>";
				echo "<tr><td>Abteilung: </td><td><input type=\"text\" name=\"abteilung\" size=\"30\" value=\"$OU\"/></tr></td>";
				echo "<tr><td>Land: </td><td><input type=\"text\" name=\"land\" size=\"30\" value=\"$C\"/></tr></td>";
				echo "<tr><td>Ort: </td><td><input type=\"text\" name=\"ort\" size=\"30\" value=\"$L\"/></tr></td>";
				echo "<tr><td>Region: </td><td><input type=\"text\" name=\"region\" size=\"30\" value=\"$ST\"></tr></td>";
		
				// Wenn San dann auch Möglichkeit geben, um San zu ändern
				if(strpos(@$ztype,'SAN') !== false) 
				{
				//auslesen der Sans
				$san = file("$path/$file1.cfg");
				echo "<tr><td>SANs: </td><td> ".@$san[0]."</tr></td>";
				echo "<tr><td>DNS 1:</td><td><input type=\"text\" name=\"dns1\" size=\"30\"></tr></td>";
				echo "<tr><td>DNS 2:</td><td><input type=\"text\" name=\"dns2\" size=\"30\"></tr></td>";	
				echo "<tr><td>DNS 3:</td><td><input type=\"text\" name=\"dns3\" size=\"30\"></tr></td>";	
				echo "<tr><td>DNS 4:</td><td><input type=\"text\" name=\"ip1\" size=\"30\"></tr></td>";	
				echo "<tr><td>DNS 5:</td><td><input type=\"text\" name=\"ip2\" size=\"30\"></tr></td>";	
				echo "<tr><td>DNS 6:</td><td><input type=\"text\" name=\"ip3\" size=\"30\"></tr></td>";	
				@$dns1 = $_POST["dns1"];
				@$dns2 = $_POST["dns2"];
				@$dns3 = $_POST["dns3"];
				@$ip1 = $_POST["ip1"];
				@$ip2 = $_POST["ip2"];
				@$ip3 = $_POST["ip3"];
				
				$san = "subjectAltName=";
				
				if (isset($dns1) && $dns1 != '')
				{
					$san = $san."DNS:$dns1";
				}
				if (isset($dns2) && $dns2 != '')
				{
					$san = $san.",DNS:$dns2";
				}
				if (isset($dns3) && $dns3 != '')
				{
					$san = $san.",DNS:$dns3";
				}
				if (isset($ip1) && $ip1 != '')
				{
					$san = $san.",DNS:$ip1";
				}
				if (isset($ip2) && $ip2 != '')
				{
					$san = $san.",DNS:$ip2";
				}
				if (isset($ip3) && $ip3 != '')
				{
					$san = $san.",DNS:$ip3";
				}
				
				$dateihandle = fopen("$path/ext_$domainname.cfg","w");
				fwrite($dateihandle, $san);
				fclose($dateihandle);
				

				}
			
			echo "</table>";
				
			echo '</fieldset><fieldset>     
			
			<input type="submit" name="changebutton" value="Ändern" />

			</form>';
			
		// Im Formular eingegebene Daten in eine Config schreiben
		
		if(isset($_POST['changebutton']) && $_POST['changebutton'] == 'Ändern') {
		if(file_exists("$path/$domainname.cfg"))
		{
		unlink("$path/$domainname.cfg");
		}		
		$fp = fopen("$path/$domainname.cfg", 'a+');		
		$config = file("$path/tmp_$domainname.cfg");	
			if (isset($_POST["domainname"]) && isset($_POST["organisation"]) && isset($_POST["abteilung"]) && isset($_POST["land"]) && isset($_POST["ort"]) && isset($_POST["region"])) {
				if ($_POST["domainname"] != '' && $_POST["region"]!='' && $_POST["organisation"]!='' && $_POST["abteilung"]!='' && $_POST["land"]!='' && $_POST["ort"]!='' ) {				
				$CN_neu = $_POST["domainname"];
				$config[1] = "$CN_neu \n";
				$O_neu = $_POST["organisation"];
				$config[2] = "$O_neu \n";				
				$OU_neu = $_POST["abteilung"];
				$config[3] = "$OU_neu \n";				
				$C_neu = $_POST["land"];
				$config[4] = "$C_neu \n";				
				$L_neu = $_POST["ort"];
				$config[5] = "$L_neu \n";
				$ST_neu = $_POST["region"];
				$config[6] = "$ST_neu \n";
				fwrite($fp, implode($config));

				// Neue Daten ausgeben
				
				echo "<h2>Neue Daten des Zertifikats:</h2><fieldset><table border=\"1\">";  
				echo "<tr><td>Zertifikatstyp: </td><td> ".@$ztype."</td></tr></td>";
				echo "<tr><td>Domainname: </td><td> ".@$CN_neu."</tr></td>";
				echo "<tr><td>Organisation: </td><td> ".@$O_neu."</tr></td>";
				echo "<tr><td>Abteilung: </td><td> ".@$OU_neu."</tr></td>";
				echo "<tr><td>Land: </td><td> ".@$C_neu."</tr></td>";
				echo "<tr><td>Ort: </td><td> ".@$L_neu."</tr></td>";
				echo "<tr><td>Region: </td><td> ".@$ST_neu."</tr></td>";
				if(strpos(@$ztype,'SAN') !== false) 
				{
				echo "<tr><td>SANs: </td></tr>";					
				echo "<tr><td>DNS1: </td><td> ".@$dns1."</td></tr></td>";
				echo "<tr><td>DNS2: </td><td> ".@$dns2."</td></tr></td>";
				echo "<tr><td>DNS3: </td><td> ".@$dns3."</td></tr></td>";
				echo "<tr><td>IP1: </td><td> ".@$ip1."</td></tr></td>";
				echo "<tr><td>IP2: </td><td> ".@$ip2."</td></tr></td>";
				echo "<tr><td>IP3: </td><td> ".@$ip3."</td></tr></td>";				
				}					
				echo "</fieldset></table><fieldset><a href=\"http://localhost:8080/gen_changedcert.php?path=$path&file=$file&cn=$domainname\">Zertifikat generieren</a>
					</fieldset>";				
			}
		else{
			echo "Bitte alle Felder ausfüllen.";
			}}
		}
		
		?>
	  
      </fieldset>
	</form>
	<br />
	<fieldset>                          
	<a href="http://localhost:8080/open_orders.php">Zur&uuml;ck zu den Bestellungen ### </a>
	<a href="http://localhost:8080/uebersicht.php">Zur&uuml;ck zum Admin-Frontend</a>
      </fieldset>
	<br />
	<fieldset>                          
			<a href="http://localhost:8080/logout.php">Logout</a>
      </fieldset>
  </body>
</html>
