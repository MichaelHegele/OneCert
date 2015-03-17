<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <title>OneCert Produktauswahl</title>
  </head>
  <body text="#202040" bgcolor="#C0C0C0">
  
  <?php
	
	// Diese Seite dient zur Produktauswahl zwischen Standard, San und Wildcard Zertifikat
	
	// Einbinden der funktionen.php
	require_once('funktionen.php');
	
	//Überprüfen ob ein User eingeloggt ist	
	checklogin();
  
	// Produktauswahl über ein Formular
  echo '<h1>OneCert Produktauswahl:</h1>
      <fieldset>                              
        <legend><h3>Bitte w&auml;hlen Sie das gew&uuml;nschte Zertifikat aus</h3></legend>
        <table>
			<tr>
				<td style="text-align:right; vertical-align:top;">Zertifikat:</td> 
				<td>
					<form name="Formular" action="Serverzertifikat.php">
						<input type="submit" value="Serverzertifikat">
					</form>
					<br>
					<form name="Formular" action="SANServerzertifikat.php">
						<input type="submit" value="SAN Serverzertifikat">
					</form>
					<br>
					<form name="Formular" action="WildcardServerzertifikat.php">
						<input type="submit" value="Wildcard Serverzertifikat">
					</form>
				</td>
			</tr>
        </table>
      </fieldset>
      <br>
	  <fieldset>                          
			<a href="uebersicht.php"> Zur&uumlck zur &Uumlbersicht</a>
		</fieldset>
		<br />
	  <fieldset>                          
			<a href="logout.php">Logout</a>
      </fieldset>';
	  ?>
  </body>  
</html>
