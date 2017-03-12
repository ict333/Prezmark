<!DOCTYPE html>
<html> 
    <head>
        
    </head>
    
    <body>
        
        <form action="CreateSchedule2.php" name="CreateSchedule1" id="CreateSchedule1" method="post">
            <h1>Create a new schedule</h1>
            
            <label for="unit">Unit Offering</label>
            <select name="unit" required>
                <option value="ICT333TJD2017">ICT333TJD2017</option>
                <option value="ICT323TJD2017">ICT323TJD2017</option>
                <option value="ICT333TJD2018">ICT333TJD2018</option>
            </select><br><br>
            <br> </br>
            
            <label for="date">Date</label>
            <input id="date" name="date" type="date" required></input>
            <br> </br>
            
            <label for="venue">Venue</label>
            <input id="venue" name="venue" type="text" required></input>
            <br> </br>
             <input type="submit" value="Next"></input>
        </form>        
    </body>
</html>
<?php
    include("dbconnect.php");
        ini_set('display_errors',1);
        error_reporting(E_ALL);
        if(isset($_POST['m_register']))
	{
		$offering=$_POST['UnitOffering'];
                $date=$_POST['Date'];
                $venue=$_POST['Venue'];
                $role=$_POST['role'];
                $aff=$_POST['affiliation'];
                $id=$_POST['id'];
                $check_per="SELECT * FROM Person WHERE Email='$mail'";
		$run_per=mysqli_query($con,$check_per);
                $outcome=mysqli_num_rows($run_per);
		
		if($outcome==0)
		{
                    //This query inserts marker details to marker table
                    $query ="INSERT INTO Person VALUES ('$mail', '$role');";
                    $result = mysqli_query($con,$query);
                    
                    //This query inserts marker details to marker table
                    $query ="INSERT INTO Marker VALUES('$fn','$ln','$mail','$role','$aff','$id',1);";
                    $result = mysqli_query($con,$query);
                    //if($result) 
                    //{
                    //    echo "Yes";
                    //} 
                    //else 
                    //{
                    //    echo "No";
                    //}
                    //echo $query;
                    mysqli_close($con);
                    
                    echo '<script>alert("Account created successfully!");</script>';
		}
		else 
		{
			echo "<script>alert('Account Exists!Log in *facepalm*')</script>";
			
		}
	}
?>