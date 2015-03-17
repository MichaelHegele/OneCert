<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Onecert Admin-Frontend</title>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>

  <body text="#202040" bgcolor="F0F8FF">
	<?php
	
	// Einbinden der funktionen.php
	require_once('funktionen.php');
	checklogin();
	
	// Übersicht für den Benutzer 
	
    echo '<h2>Onecert Übersicht Adminbereich</h2>
      
		<fieldset>
			<legend>Admin Tools</legend>
				<p><a href="open_orders.php">Offene Bestellungen</a></p>
		</fieldset>';
		
		echo '<br /><fieldset> 
			<legend>Neuer User</legend>
			<p><a href="newuser.php">Neuen User anlegen</a></p>
			<p><a href="newpassword.php">Kennwort ändern</a></p>
      </fieldset>';
  
	  echo '<br /><fieldset>                          
			<a href="logout.php">Logout</a>
      </fieldset>';
	  ?>
  </body>
</html>
