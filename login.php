<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Login</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="#C0C0C0">
    <h2>Onecert Login</h2>

	<?php 
	echo '<fieldset>  
		<legend><h3>Anmeldedaten</h3></legend>';
		
		if (isset($_POST['username']) && isset($_POST['passwort']) && $_POST['username'] != "" && $_POST['passwort'] != "")
		{
			$_username = $_POST["username"];
			$_passwort = hash('sha512',$_POST["passwort"]);
			
			$_sql = "SELECT * 
					FROM 	kunde 
					WHERE 	username ='$_username'
					AND 	passwort = '$_passwort';";
					
			require_once('funktionen.php');
		
			$_erg = DBQuery($_sql);
			$_anzahl = @mysqli_num_rows($_erg);	
			if($_anzahl > 0)
			{	
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
	  
	  <fieldset>  
		<legend><h3>Registrierung</h3></legend>
			<p>Noch kein Kunde? Dann geht\'s hier zur Registrierung:</p>
			<form action="registrierung.php" method="POST" >
			<input type="submit" value="Registrieren" />
			</form>
	    </fieldset>'; 		
	?>
  </body>
</html>
