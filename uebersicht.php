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
	
    echo '<h2>Onecert Übersicht</h2>
      <fieldset>
	<legend>Übersicht</legend>
		<p>
		  <a href="index.php">OneCert Bestellauswahl</a><br><br>
		  <a href="zliste.php">Eigene Zertifikate anzeigen</a><br>
		</p>
      </fieldset>
	  <br />'; 
		
		if($_SESSION['username'] == 'admin')
		{
			echo '<fieldset>
				<legend>Admin Tools</legend>
				<p><a href="open_orders.php">Offene Bestellungen</a></p>
			</fieldset>
			<br />';
		}
  
	  echo '<fieldset>                          
			<a href="logout.php">Logout</a>
      </fieldset>';
	  ?>
  </body>
</html>
