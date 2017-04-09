<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();
$role= $_SESSION['Role'];
$email=$_SESSION['Email'];
if((!isset($email)))
{
    echo '<script>alert("Session not Set")</script>';
    header("Location: SuperUserLogin.php");
}
if($role!="UC")
{
    header("Location: SuperUserLogin.php");
}

if(isset($_POST['next']))
{    
    $date=$_POST['date'];
    $venue=$_POST['venue'];
    $unitoffering=$_POST['unitoffering'];
    $duration=$_POST['duration'];
    $start=$_POST['start'];
    $end=$_POST['end'];
    $_SESSION['Date']=$date;
    $_SESSION['Venue']=$venue;
    $_SESSION['UnitOffering']=$unitoffering;
    $_SESSION['Duration']=$duration;
    $_SESSION['Start']=$start;
    $_SESSION['End']=$end;
      
    header("Location: FillPresentationSchedule.php");
}
?>

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
            <a href="PresentationDisplay.php">Assess Presentations</a>
            <a href="DownloadMarks.php">Download Marks</a>
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
                include("dbconnect.php");
                $get_offering="SELECT DISTINCT UnitOffering FROM Team";

                $runsql=mysqli_query($dbc,$get_offering);

                while($rows=mysqli_fetch_array($runsql))
                {
                        $offering=$rows['UnitOffering'];
                        echo "<option value='$offering'>$offering</option>";
                }
                
                mysqli_close($dbc);
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
            
            <label for="duration">Duration<br>
            <input id="duration" name="duration" type="number" required></input>
            </label>
            <br> </br>
            
            <label for="start">Start Time<br>
            <input id="start" name="start" type="time" required></input>
            </label>
            <br> </br>

            <label for="end">End Time<br>
            <input id="end" name="end" type="time" required></input>
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

