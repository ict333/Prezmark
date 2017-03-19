<?php
	$host = "localhost";
	$user = "root";
	$password = "123";
	$dbname = "Prezmark"; 
	$dbc = mysqli_connect($host,$user,$password,$dbname); 

	if(!$dbc)
        {
            die("Connection failed: ".mysqli_connect_error());
        }
	
?>