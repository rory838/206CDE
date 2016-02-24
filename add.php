<html>
<body>

<?php
$username = "root";
$password = "Password";
$hostname = "localhost";
//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
  or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";
//select the correct database
$selected = mysql_select_db("openexport", $dbhandle)
  or die("Could not select openexport");
echo "Selected openexport<br>";
//attempt to filter out escape characters to help preven SQL Injection attacks
$country = mysql_real_escape_string($_POST[country]);
$name = mysql_real_escape_string($_POST[name]);
$description = mysql_real_escape_string($_POST[descr]);
echo "Arguments filtered<br>";
//insert the data
$sql = "INSERT INTO $country (ID, STANDARD, DESCRIPTION)
VALUES
	(NULL, 
	'$name', 
	'$description'
	)";
if (!mysql_query($sql,$dbhandle))
  {
  die('Error: ' . mysql_error());
  }
echo "Added Record<br>";
//Close the connection properly
mysql_close($dbhandle);
echo "Success";
?>

</body>
</html>
