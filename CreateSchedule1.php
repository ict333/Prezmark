<?php
include("dbconnect.php");
?>
<!DOCTYPE html>
<html> 
    <head>
        
    </head>
    
    <body>
        
        <form  name="CreateSchedule1" id="CreateSchedule1" method="post">
            <h1>Create a new schedule</h1>
            
            <label for="unit">Unit Offering</label>
       
            <select name="unit" required>
            <?php
                $get_offering="select DISTINCT UnitOffering from Team ;";

                $runsql=mysqli_query($dbc,$get_offering);

                while($rows=mysqli_fetch_array($runsql))
                {
                        $offering=$rows['UnitOffering'];
                        echo "<option value='$offering'>$offering</option>";
                }
            ?>
            </select><br><br>
            
            <label for="date">Date</label>
            <input id="date" name="date" type="date" required></input>
            <br> </br>
            
            <label for="venue">Venue</label>
            <input id="venue" name="venue" type="text" required></input>
            <br> </br>
             <input type="submit" name="next" value="Next"></input>
        </form>        
    </body>
</html>
<?php
    
        ini_set('display_errors',1);
        error_reporting(E_ALL);
        if(isset($_POST['next']))
	{
                $date=$_POST['date'];
                //echo"<script>alert('$date')</script>";
                $venue=$_POST['venue'];
                $query="Insert into PresentationSchedule values('$date','peter.cole@gmail.com','ICT313S12016IT02','$venue')";
		$run=mysqli_query($dbc,$query);
		if(!$run)
                {
                    echo"<script>alert('Query Error!')</script>";
                }
                else
                {
                    echo"<script>window.open('CreateSchedule2.php','_self')</script>";
                }
	}
?>