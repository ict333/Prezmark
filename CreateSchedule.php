<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();
$role= $_SESSION['Role'];
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
    $sthr=substr($start,0,-3);
    $enhr=substr($end,0,-3);
    $stmin=substr($start,-2);
    $enmin=substr($end,-2);
    $_SESSION['Date']=$date;
    $_SESSION['Venue']=$venue;
    $_SESSION['UnitOffering']=$unitoffering;
    $_SESSION['Duration']=$duration;
    $_SESSION['Start']=$start;
    $_SESSION['StartHR']=$sthr;
    $_SESSION['StartMIN']=$stmin;
    $_SESSION['End']=$end;
    $_SESSION['EndHR']=$enhr;
    $_SESSION['EndMIN']=$enmin;
    
    
      
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
            <input id="venue" name="venue" onblur="return checkLength()" type="text" required></input>
            </label>
            <br> </br>
            
            <label for="duration">Duration<br>
            <input id="duration" name="duration" type="number" required></input>
            </label>
            <br> </br>
            
            <label for="start">Start Time<br>
                <select id="start" name="start" required>
                    <option value="9:30">9:30 am</option>
                    <option value="10:00">10:00 am</option>
                    <option value="10:30">10:30 am</option>
                    <option value="11:00">11:00 am</option>
                    <option value="11:30">11:30 am</option>
                    <option value="12:00">12:00 pm</option>
                    <option value="12:30">12:30 pm</option>
                    <option value="13:00">1:00 pm</option>
                    <option value="13:30">1:30 pm</option>
                    <option value="14:00">2:00 pm</option>
                    <option value="14:30">2:30 pm</option>
                    <option value="15:00">3:00 pm</option>
                    <option value="15:30">3:30 pm</option>
                    <option value="16:00">4:00 pm</option>
                    <option value="16:30">4:30 pm</option>
                    <option value="17:00">5:00 pm</option>
                    <option value="17:30">5:30 pm</option>
                    <option value="18:00">6:00 pm</option>
                    <option value="18:30">6:30 pm</option>
                    <option value="19:00">7:00 pm</option>
                    <option value="19:30">7:30 pm</option>
                </select>
            </label>
            <br/> <br/>

            <label for="end">End Time<br>
            <select id="end" name="end" required>
                <option value="10:00">10:00 am</option>
                <option value="10:30">10:30 am</option>
                <option value="11:00">11:00 am</option>
                <option value="11:30">11:30 am</option>
                <option value="12:00">12:00 pm</option>
                <option value="12:30">12:30 pm</option>
                <option value="13:00">1:00 pm</option>
                <option value="13:30">1:30 pm</option>
                <option value="14:00">2:00 pm</option>
                <option value="14:30">2:30 pm</option>
                <option value="15:00">3:00 pm</option>
                <option value="15:30">3:30 pm</option>
                <option value="16:00">4:00 pm</option>
                <option value="16:30">4:30 pm</option>
                <option value="17:00">5:00 pm</option>
                <option value="17:30">5:30 pm</option>
                <option value="18:00">6:00 pm</option>
                <option value="18:30">6:30 pm</option>
                <option value="19:00">7:00 pm</option>
                <option value="19:30">7:30 pm</option>
                <option value="20:00">8:00 pm</option>
            </select>
            </label>
            <br> </br>
            <script>
                function checkLength()
                {
                    if(document.getElementById("venue").value.length>100)
                    {
                        alert("Venue input is too long!");
                        return false;
                    }
                    else
                    {
                        return true;
                    }
                }
            </script>
            <input class="button" type="submit" name="next" value="Next"></input>
        </form>  
        </div>
        <footer>
           &#169;2017 All rights reserved by Murdoch University 
        </footer>
        
    </body>
</html>

