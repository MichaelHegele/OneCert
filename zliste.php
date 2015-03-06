<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Onecert Admin-Frontend</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="#C0C0C0">
	<?php
	require_once('funktionen.php');
	checklogin();
	
    echo '<h2>Onecert Zertifikat Abruf</h2>
      <fieldset>                          
		<legend><h3>Zertifikate</h3></legend>
		<table border="1">
			<tr>
				<td>Domain</td>
				<td>Typ</td>
				<td>Datum</td>
				<td>Laufzeit in Tagen</td>
				<td></td>
			</tr>';
			
		$_username = $_SESSION['username'];
			
		$_sql = "SELECT * 
				FROM 	zertifikate 
				WHERE 	kusername ='$_username';";
			
	$_erg = DBQuery($_sql);
	$_anzahl = @mysqli_num_rows($_erg);
	if($_anzahl < 1)
	{
		echo '<tr>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td>-</td>
			</tr>';
	}
	else
	{
	while ($_daten = mysqli_fetch_array( $_erg, MYSQL_ASSOC))
	{
		if (strpos($_daten['ztyp'],'typ_standard') !== false) 
			{
				$ztype = "Standard-Zertifikat";
				$typ = "standard";
			}
			if (strpos($_daten['ztyp'],'typ_wildcard') !== false) {
				$ztype = "Wildcard-Zertifikat";
				$typ = "wildcard";
			}		
			if (strpos($_daten['ztyp'],'typ_san') !== false) {
				$ztype = "SAN-Zertifikat";
				$typ = "san";
			}
		
		$_path = "../../kunden/orders/" . $_username . "/" .  $_daten['ztyp'] . "/";
		
		echo '<tr>
				<td>' . $_daten['zdomain'] . '</td>
				<td>' . $ztype .'</td>
				<td>' . $_daten['zdate'] .'</td>
				<td>' . $_daten['zdays'] .'</td>
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
