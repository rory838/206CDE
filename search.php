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
	From:	<select name="countryfrom">
        	        <option value="UK">UK</option>
                	<option value="DE">Germany</option>
        	</select>
	To:	<select name="countryto">
                        <option value="UK">UK</option>
                        <option value="DE">Germany</option>
                </select>

		<input  type="text" name="search_term">
		<input  type="submit" name="submit" value="Search">
	</form>


<?php
function getmicrotime(){
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$username = "openexport";
$password = "0-7Lamd)G~SiQ";
$hostname = "localhost";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) or die ('Unable to connect to database');
mysql_select_db("openexport") or die ('Unable to select database.');
$RESULTS_LIMIT=1000;
//echo "Selected openexport<br>";
if(isset($_GET['search_term']) && isset($_GET['submit'])){
	//echo "Search terms recieved<br>";
	$search_term = $_GET['search_term'];
	$country = $_GET['countryfrom'];
	//echo "$country";
	//echo "$search_term";
	if(!isset($first_pos)){
		$first_pos = "0";
	}
	$start_search = getmicrotime();
	$sql_query = mysql_query("SELECT * FROM".$country."') WHERE MATCH(DOCUMENT_NUMBER, DESCRIPTION) AGAINST('$search_term')");
	if($results = mysql_num_rows($sql_query) != 0){
		$sql =  "SELECT * FROM ".$country." WHERE MATCH(DOCUMENT_NUMBER, DESCRIPTION) AGAINST('$search_term') LIMIT $first_pos, $RESULTS_LIMIT";
		$sql_result_query = mysql_query($sql);
	}
	else{
		$sql = "SELECT * FROM ".$country." WHERE (DOCUMENT_NUMBER LIKE '%".mysql_real_escape_string($search_term)."%' OR DESCRIPTION LIKE '%".$search_term."%') ";
		$sql_query = mysql_query($sql);
		$results = mysql_num_rows($sql_query);
		$sql_result_query = mysql_query("SELECT * FROM ".$country." WHERE (DOCUMENT_NUMBER LIKE '%".$search_term."%' OR DESCRIPTION LIKE '%".$search_term."%') LIMIT $first_pos, $RESULTS_LIMIT ");
	}
	$stop_search = getmicrotime();
	$time_search = ($stop_search - $start_search);
}

echo '<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-yw4l{vertical-align:top}
</style><table class="tg"><tr><th class="tg-yw41">';
echo "<h1> Source Standards </h1>";
while($row = mysql_fetch_array($sql_result_query)){
  	echo "<br>";
	$dnumber = $row['DOCUMENT_NUMBER'];
	$countryto = $_GET['countryto'];
  	echo $dnumber;
	echo "&nbsp;&nbsp;&nbsp;";
	echo $row['STATUS'];
	echo "&nbsp;&nbsp;&nbsp;";
	echo "Origin: " . mysql_field_table($sql_result_query, 0);
	echo "<br>";
	echo $row['DESCRIPTION'];
	echo "<br>";
	echo "<a href=" . $row['LINK'] . "> View Here</a>";
}
echo "</th>";

echo '<th class="tg-yw41">';
echo "<h1> Destination Standards </h1>";
//echo "Selected openexport<br>";
if(isset($_GET['search_term']) && isset($_GET['submit'])){
        //echo "Search terms recieved<br>";
        $search_term = $_GET['search_term'];
        $country = $_GET['countryto'];
        //echo "$country";
        //echo "$search_term";
        if(!isset($first_pos)){
                $first_pos = "0";
        }
        $start_search = getmicrotime();
        $sql_query = mysql_query("SELECT * FROM".$country."') WHERE MATCH(DOCUMENT_NUMBER, DESCRIPTION) AGAINST('$search_term')");
        if($results = mysql_num_rows($sql_query) != 0){
                $sql =  "SELECT * FROM ".$country." WHERE MATCH(DOCUMENT_NUMBER, DESCRIPTION) AGAINST('$search_term') LIMIT $first_pos, $RESULTS_LIMIT";
                $sql_result_query = mysql_query($sql);
        }
        else{
                $sql = "SELECT * FROM ".$country." WHERE (DOCUMENT_NUMBER LIKE '%".mysql_real_escape_string($search_term)."%' OR DESCRIPTION LIKE '%".$search_term."%') ";
                $sql_query = mysql_query($sql);
                $results = mysql_num_rows($sql_query);
                $sql_result_query = mysql_query("SELECT * FROM ".$country." WHERE (DOCUMENT_NUMBER LIKE '%".$search_term."%' OR DESCRIPTION LIKE '%".$search_term."%') LIMIT $first_pos, $RESULTS_LIMIT ");
        }
        $stop_search = getmicrotime();
        $time_search = ($stop_search - $start_search);
}

while($row = mysql_fetch_array($sql_result_query)){
        echo "<br>";
        $dnumber = $row['DOCUMENT_NUMBER'];
        $countryto = $_GET['countryto'];
        echo $dnumber;
        echo "&nbsp;&nbsp;&nbsp;";
        echo $row['STATUS'];
        echo "&nbsp;&nbsp;&nbsp;";
        echo "Origin: " . mysql_field_table($sql_result_query, 0);
        echo "<br>";
        echo $row['DESCRIPTION'];
        echo "<br>";
        echo "<a href=" . $row['LINK'] . "> View Here</a>";
}

echo "</th></tr></table>";

echo "<br> Time taken: <br>";
echo sprintf("%01.2f", $time_search);


?>


</body>
</html>
</p>
