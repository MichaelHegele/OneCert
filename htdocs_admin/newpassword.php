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
	
	//Einbinden der funktionen.php
	require_once('funktionen.php');
	checklogin();
	
	// Seite zum ändern des eigenen Kennworts
	 if(isset($_POST['apasswortold']) && isset($_POST['apasswort']) && isset($_POST['apasswortcheck']) && $_POST['apasswortold'] != "" && $_POST['apasswort'] != "" && $_POST['apasswortcheck'] != "" )
        {
			//Übergabe der Variablen
			$_ausername = $_SESSION['username'];
            $_apasswortold = hash('sha512',$_POST["apasswortold"]);
			$_apasswort = hash('sha512',$_POST["apasswort"]);
			$_apasswortcheck = hash('sha512',$_POST["apasswortcheck"]);
			
			//Check ob mit den Passwörtern alles stimmt
            if($_apasswort == $_apasswortcheck && $_apasswort != $_apasswortold && $_apasswortcheck != $_apasswortold)
            {  
				//SQL Statement um zu prüfen, ob das alte Kennwort richtig ist
                $_sql = "   Select apasswort
                            FROM admin
                            WHERE ausername = '$_ausername'
                            AND apasswort = '$_apasswortold'";
 
				//DB Abfrage ausführen
                $_erg = DBQuery($_sql);
				
				//Prüfen ob Passwort stimmt
                $_anzahl = @mysqli_num_rows($_erg);
                if($_anzahl > 0)
                {
					//SQL Statement zum Update des Kennworts
                    $_sql = "   UPDATE admin
                            SET apasswort = '$_apasswort'
                            WHERE ausername = '$_ausername'";
							
                    // Update Statement ausführen
					DBQuery($_sql);
                    echo'<p>Kennwort erfolgreich ge&#228;ndert.</p>';
                }
                else
                {
                    echo'<p class="red">Das alte Kennwort ist nicht korrekt!</p>';
                }
            }
            else
            {
                echo'<p class="red">Altes und neues Kennwort sind gleich bzw. das neue Kennwort wurde nicht richtig best&#228;tigt!</p>';
            }
        }
        else
        {
            echo "<p class='red'>Es d&uumlrfen keine Felder leergelassen werden!</p>";
        }
	
		//Formular zum ändern des Kennworts
	
      echo '<form'; echo $_SERVER["PHP_SELF"]; echo' method="POST" >
	  
		<fieldset>
		<legend><h3>Kennwort &aumlndern</h3></legend>
			<table>
				<tr>
					<td style="text-align:right;">Altes Kennwort:</td>
					<td><input type="text" name="apasswortold" size="10"/></td>
				</tr>
				<tr>
					<td style="text-align:right;">Neues Kennwort:</td>
					<td><input type="password" name="apasswort" size="10"/></td>
				</tr>
				<tr>
					<td style="text-align:right;">Kennwort Bestätigung:</td>
					<td><input type="password" name="apasswortcheck" size="10"/></td>
				</tr>
			</table>
		</fieldset>
		<br />
		<fieldset>
			<a href="uebersicht.php">Zur&uuml;ck zur &Uuml;bersicht</a>
		</fieldset>
		<br />
		<input type="submit" value="Kennwort ändern" />
		</form>';
	?>
  </body>
</html>