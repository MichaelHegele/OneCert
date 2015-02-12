<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
      "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title>OneCert</title>
  </head>
  <body text="#202040" bgcolor="#C0C0C0">
  <h1>OneCert - Bestellung</h1>
  
  <?php
	require_once('funktionen.php');
	checklogin();
	
	$_username = $_SESSION['username'];
	
	$_sql = "SELECT * 
			FROM 	kunde 
			WHERE 	username ='$_username';";
			
	$_erg = DBQuery($_sql);

	$_daten = mysqli_fetch_array( $_erg, MYSQL_ASSOC);
	
    echo '<form enctype="multipart/form-data" name="Formular" action="form_order.php" method="post" onsubmit="return chkFormular()">
      <fieldset>                              
        <legend><h3>Kontaktdaten</h3></legend>
        <table>
          <tr>
            <td style="text-align:right;">Nachname:</td>
            <td><b>' . $_daten["kname"] . '</b></td>
          </tr>
		  <tr>
            <td style="text-align:right;">Vorname:</td>
            <td><b>' . $_daten["kvname"] . '</b></td>
          </tr>
		  <tr>
            <td style="text-align:right;">Strasse:</td>
            <td><b>' . $_daten["kstrasse"] . '</b></td>
			<td style="text-align:right;">Hausnummer:</td>
            <td><b>' . $_daten["khausnummer"] . '</b></td>
		  </tr>
		  <tr>
            <td style="text-align:right;">PLZ:</td>
            <td><b>' . $_daten["kplz"] . '</b></td>
			<td style="text-align:right;">Ort:</td>
            <td><b>' . $_daten["kort"] . '</b></td>
          </tr>
		  <tr>
            <td style="text-align:right;">Land:</td> 
            <td><b>' . $_daten["kland"] . '</b></td>
          </tr>
		  <tr>
            <td style="text-align:right;">Region:</td>
            <td><b>' . $_daten["kregion"] . '</b></td>
          </tr>
		  <tr>
            <td style="text-align:right;">Telefonnummer:</td>
            <td><b>' . $_daten["ktelefon"] . '</b></td>
          </tr>
		  <tr>
            <td style="text-align:right;">Mail:</td>
            <td><b>' . $_daten["kmail"] . '</b></td>
          </tr>
        </table>
      </fieldset>
      <br>
      <fieldset>
        <legend><h3>Serverzertifikat</h3></legend>
		
				<!-- Upload-Feld f�r die CSR DAtei -->
				<input type="hidden" name="MAX_FILE_SIZE" value="10000" />
				<!-- Der Name des Input Felds bestimmt den Namen im $_FILES Array -->
				 CSR-Datei hochladen: <input name="userfile" type="file" accept="csr"/>
		
        <!-- <table>
          <tr>
            <td style="text-align:right;">Server Name</td>
            <td><input type="text" name="zsname" size="10"/></td>
          </tr>
		  <tr>
            <td style="text-align:right;">Organisation</td>
            <td><input type="text" name="zorganisation" size="10"/></td>
          </tr>
		  <tr>
            <td style="text-align:right;">Ort</td>
            <td><input type="text" name="zort" size="10"/></td>
          </tr>
		  <tr>
            <td style="text-align:right;">Region</td>
            <td><input type="text" name="zregion" size="10"/></td>
          </tr>
		  <tr>
            <td style="text-align:right;">Land</td> 
            <td>
              <select name="zland" size="1">
				<option value="AF">Afghanistan</option>
				<option value="EG">&Auml;gypten</option>
				<option value="AX">Aland</option>
				<option value="AL">Albanien</option>
				<option value="DZ">Algerien</option>
				<option value="AS">Amerikanisch-Samoa</option>
				<option value="VI">Amerikanische Jungferninseln</option>
				<option value="AD">Andorra</option>
				<option value="AO">Angola</option>
				<option value="AI">Anguilla</option>
				<option value="AQ">Antarktis</option>
				<option value="AG">Antigua und Barbuda</option>
				<option value="GQ">&Auml;quatorialguinea</option>
				<option value="AR">Argentinien</option>
				<option value="AM">Armenien</option>
				<option value="AW">Aruba</option>
				<option value="AC">Ascension</option>
				<option value="AZ">Aserbaidschan</option>
				<option value="ET">&Auml;thiopien</option>
				<option value="AU">Australien</option>
				<option value="BS">Bahamas</option>
				<option value="BH">Bahrain</option>
				<option value="BD">Bangladesch</option>
				<option value="BB">Barbados</option>
				<option value="BE">Belgien</option>
				<option value="BZ">Belize</option>
				<option value="BJ">Benin</option>
				<option value="BM">Bermuda</option>
				<option value="BT">Bhutan</option>
				<option value="BO">Bolivien</option>
				<option value="BA">Bosnien und Herzegowina</option>
				<option value="BW">Botswana</option>
				<option value="BV">Bouvetinsel</option>
				<option value="BR">Brasilien</option>
				<option value="BN">Brunei</option>
				<option value="BG">Bulgarien</option>
				<option value="BF">Burkina Faso</option>
				<option value="BI">Burundi</option>
				<option value="CL">Chile</option>
				<option value="CN">China</option>
				<option value="CK">Cookinseln</option>
				<option value="CR">Costa Rica</option>
				<option value="CI">Cote d\'Ivoire</option>
				<option value="DK">D&auml;nemark</option>
				<option value="DE">Deutschland</option>
				<option value="DG">Diego Garcia</option>
				<option value="DM">Dominica</option>
				<option value="DO">Dominikanische Republik</option>
				<option value="DJ">Dschibuti</option>
				<option value="EC">Ecuador</option>
				<option value="SV">El Salvador</option>
				<option value="ER">Eritrea</option>
				<option value="EE">Estland</option>
				<option value="EU">Europ&auml;ische Union</option>
				<option value="FK">Falklandinseln</option>
				<option value="FO">F&auml;r&ouml;er</option>
				<option value="FJ">Fidschi</option>
				<option value="FI">Finnland</option>
				<option value="FR">Frankreich</option>
				<option value="GF">Franz&ouml;sisch-Guayana</option>
				<option value="PF">Franz&ouml;sisch-Polynesien</option>
				<option value="GA">Gabun</option>
				<option value="GM">Gambia</option>
				<option value="GE">Georgien</option>
				<option value="GH">Ghana</option>
				<option value="GI">Gibraltar</option>
				<option value="GD">Grenada</option>
				<option value="GR">Griechenland</option>
				<option value="GL">Gr&ouml;nland</option>
				<option value="GB">Gro&szlig;britannien</option>
				<option value="CP">Guadeloupe</option>
				<option value="GU">Guam</option>
				<option value="GT">Guatemala</option>
				<option value="GG">Guernsey</option>
				<option value="GN">Guinea</option>
				<option value="GW">Guinea-Bissau</option>
				<option value="GY">Guyana</option>
				<option value="HT">Haiti</option>
				<option value="HM">Heard und McDonaldinseln</option>
				<option value="HN">Honduras</option>
				<option value="HK">Hongkong</option>
				<option value="IN">Indien</option>
				<option value="ID">Indonesien</option>
				<option value="IQ">Irak</option>
				<option value="IR">Iran</option>
				<option value="IE">Irland</option>
				<option value="IS">Island</option>
				<option value="IL">Israel</option>
				<option value="IT">Italien</option>
				<option value="JM">Jamaika</option>
				<option value="JP">Japan</option>
				<option value="YE">Jemen</option>
				<option value="JE">Jersey</option>
				<option value="JO">Jordanien</option>
				<option value="KY">Kaimaninseln</option>
				<option value="KH">Kambodscha</option>
				<option value="CM">Kamerun</option>
				<option value="CA">Kanada</option>
				<option value="IC">Kanarische Inseln</option>
				<option value="CV">Kap Verde</option>
				<option value="KZ">Kasachstan</option>
				<option value="QA">Katar</option>
				<option value="KE">Kenia</option>
				<option value="KG">Kirgisistan</option>
				<option value="KI">Kiribati</option>
				<option value="CC">Kokosinseln</option>
				<option value="CO">Kolumbien</option>
				<option value="KM">Komoren</option>
				<option value="CG">Kongo</option>
				<option value="HR">Kroatien</option>
				<option value="CU">Kuba</option>
				<option value="KW">Kuwait</option>
				<option value="LA">Laos</option>
				<option value="LS">Lesotho</option>
				<option value="LV">Lettland</option>
				<option value="LB">Libanon</option>
				<option value="LR">Liberia</option>
				<option value="LY">Libyen</option>
				<option value="LI">Liechtenstein</option>
				<option value="LT">Litauen</option>
				<option value="LU">Luxemburg</option>
				<option value="MO">Macao</option>
				<option value="MG">Madagaskar</option>
				<option value="MW">Malawi</option>
				<option value="MY">Malaysia</option>
				<option value="MV">Malediven</option>
				<option value="ML">Mali</option>
				<option value="MT">Malta</option>
				<option value="MA">Marokko</option>
				<option value="MH">Marshallinseln</option>
				<option value="MQ">Martinique</option>
				<option value="MR">Mauretanien</option>
				<option value="MU">Mauritius</option>
				<option value="YT">Mayotte</option>
				<option value="MK">Mazedonien</option>
				<option value="MX">Mexiko</option>
				<option value="FM">Mikronesien</option>
				<option value="MD">Moldawien</option>
				<option value="MC">Monaco</option>
				<option value="MN">Mongolei</option>
				<option value="MS">Montserrat</option>
				<option value="MZ">Mosambik</option>
				<option value="MM">Myanmar</option>
				<option value="NA">Namibia</option>
				<option value="NR">Nauru</option>
				<option value="NP">Nepal</option>
				<option value="NC">Neukaledonien</option>
				<option value="NZ">Neuseeland</option>
				<option value="NT">Neutrale Zone</option>
				<option value="NI">Nicaragua</option>
				<option value="NL">Niederlande</option>
				<option value="AN">Niederl&auml;ndische Antillen</option>
				<option value="NE">Niger</option>
				<option value="NG">Nigeria</option>
				<option value="NU">Niue</option>
				<option value="KP">Nordkorea</option>
				<option value="MP">N&ouml;rdliche Marianen</option>
				<option value="NF">Norfolkinsel</option>
				<option value="NO">Norwegen</option>
				<option value="OM">Oman</option>
				<option value="AT">&Ouml;sterreich</option>
				<option value="PK">Pakistan</option>
				<option value="PS">Pal&auml;stina</option>
				<option value="PW">Palau</option>
				<option value="PA">Panama</option>
				<option value="PG">Papua-Neuguinea</option>
				<option value="PY">Paraguay</option>
				<option value="PE">Peru</option>
				<option value="PH">Philippinen</option>
				<option value="PN">Pitcairninseln</option>
				<option value="PL">Polen</option>
				<option value="PT">Portugal</option>
				<option value="PR">Puerto Rico</option>
				<option value="RE">R�union</option>
				<option value="RW">Ruanda</option>
				<option value="RO">Rum&auml;nien</option>
				<option value="RU">Russische F&ouml;deration</option>
				<option value="SB">Salomonen</option>
				<option value="ZM">Sambia</option>
				<option value="WS">Samoa</option>
				<option value="SM">San Marino</option>
				<option value="ST">Sao Tom� und Pr�ncipe</option>
				<option value="SA">Saudi-Arabien</option>
				<option value="SE">Schweden</option>
				<option value="CH">Schweiz</option>
				<option value="SN">Senegal</option>
				<option value="CS">Serbien und Montenegro</option>
				<option value="SC">Seychellen</option>
				<option value="SL">Sierra Leone</option>
				<option value="ZW">Simbabwe</option>
				<option value="SG">Singapur</option>
				<option value="SK">Slowakei</option>
				<option value="SI">Slowenien</option>
				<option value="SO">Somalia</option>
				<option value="ES">Spanien</option>
				<option value="LK">Sri Lanka</option>
				<option value="SH">St. Helena</option>
				<option value="KN">St. Kitts und Nevis</option>
				<option value="LC">St. Lucia</option>
				<option value="PM">St. Pierre und Miquelon</option>
				<option value="VC">St. Vincent/Grenadinen (GB)</option>
				<option value="ZA">S&uuml;dafrika, Republik</option>
				<option value="SD">Sudan</option>
				<option value="KR">S&uuml;dkorea</option>
				<option value="SR">Suriname</option>
				<option value="SJ">Svalbard und Jan Mayen</option>
				<option value="SZ">Swasiland</option>
				<option value="SY">Syrien</option>
				<option value="TJ">Tadschikistan</option>
				<option value="TW">Taiwan</option>
				<option value="TZ">Tansania</option>
				<option value="TH">Thailand</option>
				<option value="TL">Timor-Leste</option>
				<option value="TG">Togo</option>
				<option value="TK">Tokelau</option>
				<option value="TO">Tonga</option>
				<option value="TT">Trinidad und Tobago</option>
				<option value="TA">Tristan da Cunha</option>
				<option value="TD">Tschad</option>
				<option value="CZ">Tschechische Republik</option>
				<option value="TN">Tunesien</option>
				<option value="TR">T&uuml;rkei</option>
				<option value="TM">Turkmenistan</option>
				<option value="TC">Turks- und Caicosinseln</option>
				<option value="TV">Tuvalu</option>
				<option value="UG">Uganda</option>
				<option value="UA">Ukraine</option>
				<option value="HU">Ungarn</option>
				<option value="UY">Uruguay</option>
				<option value="UZ">Usbekistan</option>
				<option value="VU">Vanuatu</option>
				<option value="VA">Vatikanstadt</option>
				<option value="VE">Venezuela</option>
				<option value="AE">Vereinigte Arabische Emirate</option>
				<option value="US">Vereinigte Staaten von Amerika</option>
				<option value="VN">Vietnam</option>
				<option value="WF">Wallis und Futuna</option>
				<option value="CX">Weihnachtsinsel</option>
				<option value="BY">Wei&szlig;russland</option>
				<option value="EH">Westsahara</option>
				<option value="CF">Zentralafrikanische Republik</option>
				<option value="CY">Zypern</option>
				</select>
            </td>
          </tr>
		  <tr>
            <td style="text-align:right;">Key</td> 
            <td>
              <select name="zkey" size="1">
                <option value="2048">2048 (empfohlen)</option>
                <option value="4096">4096</option>
              </select>
            </td>
          </tr>
		  <tr>-->
			<p>Laufzeit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <select name="zdays" size="1">
                <option value="365">1 Jahr</option>
                <option value="1095">3 Jahre</option>
				<option value="1825">5 Jahre</option>
              </select>
			  <p/>
            <!--
          </tr>
        </table> -->
      </fieldset>
      <br>
	  <input name="ztype" type="hidden" value="typ_standard" />
      <input type="submit" value="Bestellen"/>
      <input type="reset" value="Verwerfen"/>
    </form>
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
