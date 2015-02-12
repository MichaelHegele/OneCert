<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>CSR-Bestell&uuml;bersicht</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="#C0C0C0">
    <h2>Eingegangene CSR-Bestellungen:</h2>

	<?php
	require_once('funktionen.php');
	checklogin();
	
	if($_SESSION['username'] != 'admin')
			{	
				$_host  = $_SERVER['HTTP_HOST'];
				$_uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				$_extra = 'uebersicht.php';
				header("Location: http://$_host$_uri/$_extra");
				exit;
			}
	
	  echo '<form name="Bestellungen" action="open_orders.php" method="post">
      <fieldset>                          
        <table>';

			$path = "C:/kunden/orders";
			$pre = "";
			
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
