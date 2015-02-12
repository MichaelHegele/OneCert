<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>CSR-Bestell&uuml;bersicht</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="#C0C0C0">
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
  
    echo '<h2>Bitte pr&uuml;fen Sie den Certificate Signing Request:</h2>

	  <form name="Generate" action="generate_cert.php" method="post">
      <fieldset>                          
        <table border="1">';
		
		$path = $_GET["path"];		
		$file = $_GET["file"];		
		$csrpath = $path.$file;
		echo "<br /><br />";
		
		$csr = file_get_contents("$csrpath");
		
		$array = array();
		$array = openssl_csr_get_subject($csr);

		
		
		if (strpos($csrpath,'typ_standard') !== false) 
		{
			$ztype = "Standard Zertifikat";
			$typ = "standard";
		}
		if (strpos($csrpath,'typ_wildcard') !== false) {
			$ztype = "Wildcard Zertifikat";
			$typ = "wildcard";
		}		
		if (strpos($csrpath,'typ_san') !== false) {
			$ztype = "SAN Zertifikat";
			$typ = "san";
		}

		echo "<tr><td>Zertifikatstyp: </td><td> ".@$ztype."</tr></td>";
		echo "<tr><td>Domainname: </td><td> ".@$array[CN]."</tr></td>";
		echo "<tr><td>Organisation: </td><td> ".@$array[O]."</tr></td>";
		echo "<tr><td>Abteilung: </td><td> ".@$array[OU]."</tr></td>";
		echo "<tr><td>Land: </td><td> ".@$array[C]."</tr></td>";
		echo "<tr><td>Ort: </td><td> ".@$array[L]."</tr></td>";
		echo "<tr><td>Region: </td><td> ".@$array[ST]."</tr></td>";
		echo "</table>";
		echo "<br />";	
				echo "<fieldset><a href=\"generate_cert.php?path=$path&file=$file&cn=$array[CN]\">Genehmigen / Zertifikat generieren</a>
					</fieldset>";					
		echo "<br />";	
		echo "<fieldset>";
		System("cmd /c openssl req -in $csrpath -noout -text");	
		echo "</fieldset>";
		echo "<br />";	
				echo "<fieldset><a href=\"uebersicht.php\">Zur&uuml;ck zur &Uuml;bersicht</a>
					</fieldset>";
		echo '<br />';
		echo '<fieldset>                          
			<a href="logout.php">Logout</a>
      </fieldset>';
	
		?>

      </fieldset>
	  
      <br>

	</form>
  </body>
</html>
