<!DOCTYPE  HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta  http-equiv="Content-Type" content="text/html;  charset=iso-8859-1">
	<title>Search  Contacts</title>
</head>
<p><body>
	<h3>Search Database</h3>
	<p>You may search either by Standard number or Description</p>
	<form  method="get" action=""  id="searchform">
		<input  type="text" name="search_term">
		<input  type="submit" name="submit" value="Search">
	</form>


<?php
function getmicrotime(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$username = "root";
$password = "Password";
$hostname = "localhost";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) or die ('Unable to connect to database');
mysql_select_db("openexport") or die ('Unable to select database.');
$RESULTS_LIMIT=1000;
//echo "Selected openexport<br>";
if(isset($_GET['search_term']) && isset($_GET['submit'])){
	//echo "Search terms recieved<br>";
	$search_term = $_GET['search_term'];
	if(!isset($first_pos)){
		$first_pos = "0";
	}
	$start_search = getmicrotime();
	$sql_query = mysql_query("SELECT * FROM UK WHERE MATCH(DOCUMENT_NUMBER, DESCRIPTION) AGAINST('$search_term')");
	if($results = mysql_num_rows($sql_query) != 0){
		$sql =  "SELECT * FROM UK WHERE MATCH(DOCUMENT_NUMBER, DESCRIPTION) AGAINST('$search_term') LIMIT $first_pos, $RESULTS_LIMIT";
		$sql_result_query = mysql_query($sql);
	}
	else{
		$sql = "SELECT * FROM UK WHERE (DOCUMENT_NUMBER LIKE '%".mysql_real_escape_string($search_term)."%' OR DESCRIPTION LIKE '%".$search_term."%') ";
		$sql_query = mysql_query($sql);
		$results = mysql_num_rows($sql_query);
		$sql_result_query = mysql_query("SELECT * FROM UK WHERE (DOCUMENT_NUMBER LIKE '%".$search_term."%' OR DESCRIPTION LIKE '%".$search_term."%') LIMIT $first_pos, $RESULTS_LIMIT ");
	}
	$stop_search = getmicrotime();
	$time_search = ($stop_search - $start_search);
}

while($row = mysql_fetch_array($sql_result_query)){
  	echo "<br>";
  	echo $row['DOCUMENT_NUMBER'];
	echo "&nbsp;&nbsp;&nbsp;";
	echo $row['STATUS'];
	echo "<br>";
	echo $row['DESCRIPTION'];
	echo "<br>";
	echo "<a href=" . $row['LINK'] . "> View Here</a>";
}
echo "<br> Time taken: <br>";
echo sprintf("%01.2f", $time_search);


?>


</body>
</html>
</p>
