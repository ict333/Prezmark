<?php
include("dbconnect.php");
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();
$role= $_SESSION['Role'];
if($role!="UC")
{
    header("Location: SuperUserLogin.php");
}

?>
<!DOCTYPE html>
<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="logo.png" type="image/x-icon"></link>
    </head>
    
    <body>
        <div class="header">
         <a href="index.php"> <img src="logo.png"></a>
        <nav>
            <a href="UploadStudentDetails.php">Upload Student Details</a>
            <a href="CreateSchedule.php" class="active">New Schedule</a>
            <a href="AssessPresentations.php">Assess Presentations</a>
            <a href="">Download Marks</a>
            <!--a href="">Modify Student Details</a>
            <a href="">Modify Schedule</a-->
            <a href="Logout.php">Logout</a>
        </nav>
        </div>
        <div id="separator"></div>
        
        
        <div class="form">
        
        <h1>New Schedule</h1>
        <form  name="CreateSchedule" id="CreateSchedule" method="post">
            
            <label for="unitoffering">Unit Offering<br>
       
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
            
            <label for="date">Date<br>
            <input id="date" name="date" type="date" required></input>
            </label>
            <br> </br>
            
            <label for="venue">Venue<br>
            <input id="venue" name="venue" type="text" required></input>
            </label>
            <br> </br>
            
             <input class="button" type="submit" name="next" value="Next"></input>
        </form>  
        </div>
        <footer>
           &#169;2017 All rights reserved by Murdoch University 
        </footer>
        
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