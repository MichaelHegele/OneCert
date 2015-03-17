<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>CSR-Bestell&uuml;bersicht</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="F0F8FF">
    <h2>Eingegangene CSR-Bestellungen:</h2>

	<?php
	// Diese Seite zeigt den Admins offene CSR Bestellungen an
	
	// Einbinden der Funktionen.php
	require_once('funktionen.php');
	
	// Überprüfen ob ein User eingeloggt ist
	checklogin();
	
	  echo '<form name="Bestellungen" action="open_orders.php" method="post">
      <fieldset>                          
        <table>';
			
			// Variable path den Kundenordner zuweisen
			$path = "C:/kunden/orders";
			
			// Trennzeichen für eine bessere Übersicht
			$pre = "";
			
			// Schleife um das Verzeichnis orders mit allen Ordnern auszugeben
			// Wenn csr Dateien gefunden werden, diese mit einem Link versehen um hier Pfad und Dateiname über GET übergeben zu können
			function getDir($path,$pre) {
			  $pre.= "-";
			  $dh = opendir($path);
			  while($file = readdir($dh)) {
	
				if($file != "." && $file != "..") {
				  if(is_dir("$path/$file")) {
					echo "<fieldset>$pre $file [DIR]<br>";
					
					getDir("$path/$file",$pre);
				  }else {
					  if (strpos($file,'.csr') !== false) 
						{
							echo "<b>$pre $file (file)</b>
							<a href=\"csr_briefing.php?path=$path/&file=$file\">CSR Pr&uuml;fen</a>
							</fieldset><br />";
						}
				    }
				}
			  }
			  closedir($dh);
			}
			
			getDir($path,$pre);
		?>

        </table>
      </fieldset>

      <br>
      <input type="submit" value="Aktualisieren" formaction="open_orders.php"/>
	  </form>
	  <br />
	  <fieldset>                          
			<a href="uebersicht.php">Zur&uumlck zur &Uumlbersicht</a>
      </fieldset>
	  <br />
	  <fieldset>                          
			<a href="logout.php">Logout</a>
      </fieldset>
  </body>
</html>
