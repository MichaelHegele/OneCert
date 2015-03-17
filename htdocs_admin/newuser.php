<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Registrierung</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="F0F8FF">
    <h2>Onecert Adminverwaltung</h2>

	<?php
	  // Registrierungsseite und Daten in Datenbank aufnehmen
	  if(isset($_POST["aname"]) && isset($_POST["avname"]) && isset($_POST["ausername"]) && isset($_POST["apasswort"]) && isset($_POST["apasswortcheck"]) && $_POST["aname"] != "" && $_POST["avname"] != "" && $_POST["ausername"] != ""  && $_POST["apasswort"] != "" && $_POST["apasswortcheck"] != "")
	  {	
		// apasswort und Bestätigung auf Übereinstimmung prüfen
		if($_POST["apasswort"] == $_POST["apasswortcheck"])
		{
			//POST Variablen übergeben
			$_aname = $_POST["aname"];
			$_avname = $_POST["avname"];
			$_ausername = $_POST["ausername"];
			$_apasswort = hash('sha512', $_POST["apasswort"]);
			$_apasswortcheck = $_POST["apasswortcheck"];
			
			//SQL Statement
			$_sql = "INSERT INTO `admin` (`ausername` ,`apasswort` , `aname`, `avname`)
                 VALUES ('$_ausername',  '$_apasswort', '$_aname', '$_avname')";
				 
			// Einbinden der funktionen.php
			require_once('funktionen.php');
			
			// Insert ausführen
            $_erg = DBQuery($_sql);
				
				//Weiterleitung zur Übersichtsseite
				$_host  = $_SERVER['HTTP_HOST'];
				$_uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				$_extra = 'uebersicht.php';
				header("Location: http://$_host$_uri/$_extra");
				exit;
		}
		else
		{
			echo 'Die Passwörter müssen &uuml;bereinstimmen!';
		}
		
	  }
	  else
	  {
		  echo 'Bitte alle Felder ausf&uuml;llen!';
	  }
	  
      echo '<form'; echo $_SERVER["PHP_SELF"]; echo' method="POST" >
	  
		<fieldset>
		<legend><h3>Logindaten</h3></legend>
			<table>
				<tr>
					<td style="text-align:right;">Nachname:</td>
					<td><input type="text" name="aname" size="10"/></td>
				</tr>
				<tr>
					<td style="text-align:right;">Vorname:</td>
					<td><input type="text" name="avname" size="10"/></td>
				</tr>
				<tr>
					<td style="text-align:right;">Username:</td>
					<td><input type="text" name="ausername" size="10"/></td>
				</tr>
				<tr>
					<td style="text-align:right;">Passwort:</td>
					<td><input type="password" name="apasswort" size="10"/></td>
				</tr>
				<tr>
					<td style="text-align:right;">Passwort Bestätigung:</td>
					<td><input type="password" name="apasswortcheck" size="10"/></td>
				</tr>
			</table>
		</fieldset>
		<br />
		<fieldset>
			<a href="uebersicht.php">Zur&uuml;ck zur &Uuml;bersicht</a>
		</fieldset>
		<br />
		<input type="submit" value="Registrieren" />
		</form>';
	?>
  </body>
</html>