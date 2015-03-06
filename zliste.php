<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Onecert Admin-Frontend</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="#C0C0C0">
	<?php
	// Diese Seite zeigt dem User seine vorhandenen Zertifikate an und lässt ihn diese downloaden
	
	// Einbinden der funktionen.php
	require_once('funktionen.php');
	
	// Prüfen ob ein User eingeloggt ist
	checklogin();
	
    echo '<h2>Onecert Zertifikat Abruf</h2>
      <fieldset>                          
		<legend><h3>Zertifikate</h3></legend>
		<table border="1">
			<tr>
				<td>Domain</td>
				<td>Typ</td>
				<td>Datum</td>
				<td>Gesamt-Laufzeit</td>
				<td>Ablaufdatum</td>
				<td></td>
			</tr>';
		// Username aus der  Session holen	
		$_username = $_SESSION['username'];
		
		// SQL Statement um die Zertifikate des Users aus der DB holen	
		$_sql = "SELECT * 
				FROM 	zertifikate 
				WHERE 	kusername ='$_username';";
	
	// DB Abfrage ausführen
	$_erg = DBaQuery($_sql);
	
	// Anzahl der Ergebnisse in die Variable $_anzahl schreiben
	$_anzahl = @mysqli_num_rows($_erg);
	
	// Anzeige, dass keine Zertifikate für den User verfügbar sind
	if($_anzahl < 1)
	{
		echo '<tr>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tr>';
	}
	else
	{
	// Prüfen ob Standard, Wild, San und in Tabellenform ausgeben solange Datensätze vorhanden sind
	while ($_daten = mysqli_fetch_array( $_erg, MYSQL_ASSOC))
	{
		if (strpos($_daten['ztyp'],'typ_standard') !== false) 
			{
				$ztype = "Standard-Zertifikat";
				$typ = "standard";
				$cdomain = $_daten['zdomain'];
			}
			if (strpos($_daten['ztyp'],'typ_wildcard') !== false) {
				$ztype = "Wildcard-Zertifikat";
				$typ = "wildcard";
				$cdomain = $_daten['zdomain'];
				$cdomain = "*".$cdomain;
			}		
			if (strpos($_daten['ztyp'],'typ_san') !== false) {
				$ztype = "SAN-Zertifikat";
				$typ = "san";
				$cdomain = $_daten['zdomain'];
			}
		
		$_path = "../../kunden/orders/" . $_username . "/" .  $_daten['ztyp'] . "/";
		//Bestellte Laufzeit des Users ausgeben
		@$laufzeit = file("$_path/laufzeit.txt");
		@$_zdays = $laufzeit[0];
		@$_zjahr = $_zdays/365;
		
		echo '<tr>
				<td>' . $cdomain . '</td>
				<td>' . $ztype .'</td>
				<td>' . $_daten['zdate'] .'</td>
				<td>' . $_zdays .' Tage - ' .$_zjahr.' Jahr(e)</td>
				<td>'.date('Y.m.d', strtotime($_daten['zdate'])+(60*60*24*$_zdays)).'</td>
				<td>
				<form action="download.php" method="post">
					<input type="hidden" name="path" value="'. $_path .'" />
					<input type="hidden" name="domain" value="'. $_daten['zdomain'] .'" />
					<input type="submit" value="Download" />
				</form>
				</td>
			</tr>';
	}}
	
			
		echo '</table>
      </fieldset>
	  <br />
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
