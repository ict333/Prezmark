<?php
include ("dbconnect.php");
function marker()
{
	global $con;
	$get_p="select * from Marker where LastName='Doe'";
	
	$run_p=mysqli_query($con,$get_p);
	if(mysqli_num_rows($run_p)==0)
		{
			echo "<h1>Prezmark</h1><br/><h1>No Markers</h1>";
		}
	while($row_p=mysqli_fetch_array($run_p))
	{
		$first=$row_p['FirstName'];
		$last=$row_p['LastName'];
		$email=$row_p['Email'];
		$role=$row_p['Role'];
		
		if(mysqli_num_rows($run_p)>0)
		{
			echo "<table name='Prezmark' cellspacing='10px'><tr><td>Email: $email</td><br/><td>LastName: $last</td><br/></tr></table><br/>";
		}
	}

}

