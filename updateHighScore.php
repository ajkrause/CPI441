<?php
    $username = "gameadm";
		$password = "7IjJDGpB";
		$hostname = "localhost"; 

		//connection to the database
		$dbhandle = mysql_connect($hostname, $username, $password) 
		  or die("Unable to connect to MySQL");
      
      @mysql_select_db("gameadm_usertest") or die( "Unable to select database");
      
   $query = "UPDATE userdata SET HSCORE=" . $_GET["scr"] . " WHERE ID=" . $_GET["usr"];
   mysql_query($query) or die(mysql_error());
   
   mysql_close($dbhandle);
?>