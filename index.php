<html>
<body>
<h1>Add a standard to the database</h1>
<form action="add.php" method="post">
Country: <select name="country">
           <option value="UK">UK</option>
           <option value="DE">Germany</option>
         </select>
Document Number: <input type="text" name="dnum" />
Description: <input type="text" name="descr" />
Publisher: <input type="text" name="publ" />
Status: <input type="text" name="status" />
Publication Date: <input type="text" name="date" />
<br><br><br><br><br>


<input type="submit" />
</form>
</body>
</html>

<?php
$username = "openexport";
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

//Get all contents of the UK table
$result = mysql_query("SELECT * FROM DE")
  or die("Could not complete search");
echo "Search Completed<br><br>";
//Display contents in a nice table
echo "<h1> DE TABLE CONTENTS </h1>";
echo '<table border="1">';
echo "<tr><th>Document Number</th><th>Description</th><th>Publisher</th><th>Status</th><th>Publication Date</th></tr>";
while($row = mysql_fetch_array($result)){
  echo "<tr><td>";
  echo $row['DOCUMENT_NUMBER'];
  echo "</td><td>";
  echo $row['DESCRIPTION'];
  echo "</td><td>";
  echo $row['PUBLISHER'];
  echo "</td><td>";
  echo $row['STATUS'];
  echo "</td><td>";
  echo $row['PUBLICATION_DATE'];
  echo "</td></tr>";
}
echo "</table>";

echo "<h1> UK TABLE CONTENTS </h1>";


//Get all contents of the UK table
$result = mysql_query("SELECT * FROM UK WHERE STATUS LIKE '%Current%' AND DOCUMENT_NUMBER LIKE '%BS EN%'")
  or die("Could not complete search");
echo "Search Completed<br><br>";
//Display contents in a nice table
echo '<table border="1">'; 
echo "<tr><th>Document Number</th><th>Description</th><th>Publisher</th><th>Status</th><th>Publication Date</th></tr>"; 
while($row = mysql_fetch_array($result)){
  echo "<tr><td>"; 
  echo $row['DOCUMENT_NUMBER'];
  echo "</td><td>";   
  echo $row['DESCRIPTION'];
  echo "</td><td>";    
  echo $row['PUBLISHER'];
  echo "</td><td>";
  echo $row['STATUS'];
  echo "</td><td>";
  echo $row['PUBLICATION_DATE'];
  echo "</td></tr>";  
}
echo "</table>";  

echo "<h1> List of US database contents </h1>";

//Get all contents of the US table
$result = mysql_query("SELECT * FROM US")
  or die("Could not complete search");
echo "Search Completed<br><br>";
//Display contents in a nice table
echo '<table border="1">';
echo "<tr><th>ID</th><th>Standard</th><th>Description</th></tr>";
while($row = mysql_fetch_array($result)){
  echo "<tr><td>";
  echo $row['ID'];
  echo "</td><td>";
  echo $row['STANDARD'];
  echo "</td><td>";
  echo $row['DESCRIPTION'];
  echo "</td></tr>";
}
echo "</table>";

$result = mysql_query("SELECT * FROM TARIFF LIMIT 0, 100")
  or die("Could not complete search");
echo "Search Completed<br><br>";
//Display contents in a nice table
echo '<table border="1">';
echo "<tr><th>SID</th><th>CHAPTER</th><th>COMMODITY_CODE</th><th>PRODUCT_LINE</th><th>INDENTS</th><th>DESCRIPTION</th></tr>";
while($row = mysql_fetch_array($result)){
  echo "<tr><td>";
  echo $row['SID'];
  echo "</td><td>";
  echo $row['CHAPTER'];
  echo "</td><td>";
  echo $row['COMMODITY_CODE'];
  echo "</td><td>";
  echo $row['PRODUCT_LINE'];
  echo "</td><td>";
  $indents = intval($row['INDENTS']);
  echo $indents;
  echo "</td><td>";
  $description = $row['DESCRIPTION'];
  if($indents > 0){
    for($indents; $indents > 0; $indents--){
      echo " &nbsp; &nbsp; &nbsp;";
    }
    echo $description;
    echo "</td></tr>";
  }
  else{
    echo $description;
    echo "</td></tr>";
  }
}
echo "</table>";



//Close the connection properly
mysql_close($dbhandle);
echo "<br>Success";
?>
