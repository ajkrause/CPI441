<?php
    $username = "gameadm";
		$password = "7IjJDGpB";
		$hostname = "localhost"; 

		//connection to the database
		$dbhandle = mysql_connect($hostname, $username, $password) 
		  or die("Unable to connect to MySQL");
      
      @mysql_select_db("gameadm_usertest") or die( "Unable to select database");
      $newscore = round($_GET["scr"]);
  $query = "SELECT HSCORE FROM userdata WHERE ID=" . $_GET["usr"];
  $response = mysql_query($query) or die(mysql_error());
  $row = mysql_fetch_array($response);
  $score = $row["HSCORE"];
  
  if($score < $newscore)
  {
    $score = $newscore; 
  }
  
    $query = "UPDATE userdata SET HSCORE=" . $score . ", GAMES=" . $_GET["games"] . " WHERE ID=" . $_GET["usr"];
    mysql_query($query) or die(mysql_error());
  
  
   mysql_close($dbhandle);
   echo $score;
?>