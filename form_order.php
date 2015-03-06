<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Antwort</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="#C0C0C0">
  
  <?php
	//Übersichtsseite zur Bestellung und Kundenordner im Dateisystem anlegen
	
	// Einbinden der Datei funktionen.php 
	require_once('funktionen.php');
	checklogin();
  
    echo '<h2>Vielen Dank f&uuml;r Ihre Bestellung. Wir pr&uuml;fen diese umgehend!</h2>
	<h3>Bestell&uuml;bersicht:</h3>
    <ul>';

	// Übergabe Username aus der Sessionvariable zur Anzeige der Kontaktdaten im Bestellformular
	$_username = $_SESSION['username'];
	
	//SQL Statement
	$_sql = "SELECT * 
			FROM 	kunde 
			WHERE 	username ='$_username';";
	
	//DB Abfrage
	$_erg = DBQuery($_sql);

	//Daten aus der DB in ein Array schreiben und Variablen zuordnen
	$_daten = mysqli_fetch_array( $_erg, MYSQL_ASSOC);
		  
	  $_kname = $_daten["kname"];
	  $_kvname = $_daten["kvname"];
	  $_kstrasse = $_daten["kstrasse"];
	  $_khausnr = $_daten["khausnummer"];
	  $_kplz = $_daten["kplz"];
	  $_kort = $_daten["kort"];
	  $_kland = $_daten["kland"];
	  $_kregion = $_daten["kregion"];
	  $_ktelefon = $_daten["ktelefon"];
	  $_kmail = $_daten["kmail"];
	  
	  //POST Variablen zuweisen
	  
	  $_ztyp = $_POST["ztype"];
	  $_zdays = $_POST["zdays"];
	  
	  echo '<fieldset>                              
        <legend><h3>Kontaktdaten:</h3></legend>
        <table>
	  
	 <tr>
            <td style="text-align:right;">Nachname: </td>
            <td>';
				echo $_kname ;
				echo'</td>
          </tr>
		  <tr>
            <td style="text-align:right;">Vorname:</td>
            <td>';
			echo $_kvname;
			echo '</td>
          </tr>
		  <tr>
            <td style="text-align:right;">Strasse:</td>
            <td>';
			echo $_kstrasse;
			echo '</td>
			<td style="text-align:right;">Hausnummer:</td>
            <td>';
			echo $_khausnr;
			echo '</td>
		  </tr>
		  <tr>
            <td style="text-align:right;">PLZ:</td>
            <td>';
			echo $_kplz;
			echo '</td>
			<td style="text-align:right;">Ort:</td>
            <td>';
			echo $_kort;
			echo '</td>
          </tr>
		  <tr>
            <td style="text-align:right;">Land:</td> 
            <td>';
			echo $_kland;
			echo '</td>
          </tr>
		  <tr>
            <td style="text-align:right;">Region:</td>
            <td>';
			echo $_kregion;
			echo '</td>
          </tr>
		  <tr>
            <td style="text-align:right;">Telefonnummer:</td>
            <td>';
			echo $_ktelefon;
			echo '</td>
          </tr>
		  <tr>
            <td style="text-align:right;">Mail:</td>
            <td>';
			echo $_kmail;
			echo '</td>
          </tr></table></fieldset>  ';
	  
 
		// Kundenordner anlegen, falls noch nicht vorhanden
	  $path = "C:/kunden/orders/$_username";	  
	if (!file_exists($path))
	  {
		mkdir($path, 0700);		 
	  }
	  
	  // Im Kundenordner Zertifikatsordner anlegen, falls noch nicht vorhanden und Laufzeit in Datei schreiben
	  $uploaddir = "$path/$_ztyp/";
		  if (!file_exists($uploaddir))
		  {
			mkdir($uploaddir, 0700);
			$dateihandle = fopen("$uploaddir/laufzeit.txt","w");
			fwrite($dateihandle, $_zdays);
			fclose($dateihandle);
		  }
	  $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	  
	  // CSR-Datei entgegennehmen, prüfen und speichern  
			echo '<pre>';
				if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
					echo "Datei wurde erfolgreich hochgeladen.\n";
				} else {
					echo "Es ist ein Fehler aufgetreten! Bitte kontaktieren Sie das OneCert Team.\n";
				}

				//echo 'Weitere Debugging Informationen:';
				//print_r($_FILES);

				print "</pre>";
				echo '<br />
					<fieldset>                          
						<a href="uebersicht.php"> Zur&uumlck zur &Uumlbersicht</a>
					</fieldset>
					<br />
					<fieldset>
						<a href="logout.php">Logout</a>
					</fieldset>';
	  ?>
		<br \>
    </ul>
  </body>
</html>
