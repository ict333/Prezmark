<?php
include("dbconnect.php");
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();

?>
<!DOCTYPE html>
<html> 
    <head>
        
    </head>
    
    <body>
        
        <form  name="CreateSchedule" id="CreateSchedule" method="post">
            <legend>Create a new schedule</legend>
            
            <label for="unitoffering">Unit Offering
       
            <select name="unitoffering" id="unitoffering" required>
            <?php
                $get_offering="SELECT DISTINCT UnitOffering FROM Team";

                $runsql=mysqli_query($dbc,$get_offering);

                while($rows=mysqli_fetch_array($runsql))
                {
                        $offering=$rows['UnitOffering'];
                        echo "<option value='$offering'>$offering</option>";
                }
            ?>
            </select>
            </label>
            <br></br>
            
            <label for="date">Date
            <input id="date" name="date" type="date" required></input>
            </label>
            <br> </br>
            
            <label for="venue">Venue
            <input id="venue" name="venue" type="text" required></input>
            </label>
            <br> </br>
            
             <input type="submit" name="next" value="Next"></input>
        </form>  
        
        
    </body>
</html>





<?php
    if(isset($_POST['next']))
    {    
        $date=$_POST['date'];
        $venue=$_POST['venue'];
        $unitoffering=$_POST['unitoffering'];
        $_SESSION['Date']=$date;
        $_SESSION['Venue']=$venue;
        $_SESSION['UnitOffering']=$unitoffering;
        
        header("Location: FillPresentationSchedule.php");
    }
?>