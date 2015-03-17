<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Login</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="F0F8FF">
    <h2>Onecert Admin - Login</h2>

	<?php 
	// Diese Seite dient zum Login eines Users
	
	echo '<fieldset>  
		<legend><h3>Anmeldedaten</h3></legend>';
		
		//Prüfen ob Daten eingegeben wurden, wenn ja Übergabe an die Datenbank zur Überprüfung (gehasht)
		if (isset($_POST['username']) && isset($_POST['passwort']) && $_POST['username'] != "" && $_POST['passwort'] != "")
		{
			$_username = $_POST["username"];
			$_passwort = hash('sha512',$_POST["passwort"]);
			
			//SQL Statement
			$_sql = "SELECT * 
					FROM 	admin 
					WHERE 	ausername ='$_username'
					AND 	apasswort = '$_passwort';";
			
			//	Einbinden der funktionen.php		
			require_once('funktionen.php');
		
			// Ausführen der Datenbankabfrage
			$_erg = DBQuery($_sql);
			
			// Anzahl zurückgegebener Datensätze in die Variable $_anzahl schreiben
			$_anzahl = @mysqli_num_rows($_erg);	
			
			// Wird nur ausgeführt, wenn die Logindaten korrekt sind
			if($_anzahl > 0)
			{	
				// Wenn der User korrekt ist, Weiterleitung auf die Übersichtsseite
				session_start();
				$_SESSION['onecert'] = true;
				$_SESSION['username'] = $_username;
				
				$_host  = $_SERVER['HTTP_HOST'];
				$_uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				$_extra = 'uebersicht.php';
				header("Location: http://$_host$_uri/$_extra");
				exit;
			}
			else
			{
				// Username / Passwort nicht bekannt oder falsch
				echo "<p>Der Username $_username ist nicht bekannt oder es wurde ein falsches Passwort eingegeben!</p>";
			}
		}
		
		echo '<form echo $_SERVER["PHP_SELF"]; method="POST" >
		<table>
			<tr>
				<td>Username:</td>
				<td width="10"></td>
				<td>
					<input type="text" name="username" />
				</td>
			</tr>
			<tr>
				<td>Passwort:</td>
				<td width="10"></td>
				<td>
					<input type="password" name="passwort" />
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="Anmelden" />
				</td>
			</tr>
		</table>
		</form>
      </fieldset>
  </body>
</html>';
