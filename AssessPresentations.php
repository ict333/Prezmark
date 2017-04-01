<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$role= $_SESSION['Role'];
$email=$_SESSION['Email'];
$teamcode=$_SESSION['TeamCodeAssess'];
if($role=="Admin")
{
    echo '<script>alert("Admin cannot Assess. Please Login as Unit Coordinator or Marker:")</script>';
    header("Location: SuperUserLogin.php");
}

include 'dbconnect.php';
$query = "SELECT TeamName FROM Team WHERE TeamCode='$teamcode';";
$result = mysqli_query($dbc, $query);
while ($rows = mysqli_fetch_array($result)) 
{
    $teamname = $rows['TeamName'];
}

function totalTime($hr,$min)
{
    $totaltime=($hr*60)+$min;
    return $totaltime;
}

function convertTo24hr($hr, $ampm)
{
    if($ampm=="am" && $hr==12)
    {
        $hr=0;
    }
    else if($ampm=="pm")
    {
        $hr=$hr+12;
    }
    return $hr;
}

?>

<html>
    <head> 
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="icon.png" type="image/x-icon"></link>
    </head>
    
    <body>
       <?php
        if($role=="UC")
        {
            echo '<div class="header">
            <a href="index.php"> <img src="logo.png"></a>
           <nav>
               <a href="UploadStudentDetails.php" >Upload Student Details</a>
               <a href="CreateSchedule.php">New Schedule</a>
               <a href="PresentationDisplay.php" class="active">Assess Presentations</a>
               <a href="DownloadMarks.php">Download Marks</a>
              <!-- <a href="">Modify Student Details</a>
               <a href="">Modify Schedule</a-->
              <a href="Logout.php">Logout</a>
           </nav>
           </div>';
        }
        else
        {
            echo '<div class="header">
            <a href="index.php"> <img src="logo.png"></a>
           <nav>
               <a href="PresentationDisplay.php" class="active">Assess Presentations</a>
               <a href="index.php">Logout</a>
           </nav>
           </div>';
        }
        ?>
        
        <div id="separator"></div>
        <p id="demo"></p>
        
        <?php
        $query = "SELECT TimeSlot FROM Team WHERE TeamCode='$teamcode';";
        $result = mysqli_query($dbc, $query);

        while ($rows = mysqli_fetch_array($result)) 
        {
            $datetime= $rows['TimeSlot']; 
        }
        
        
        //Getting the hours and minutes for the presentation start time and calculating the time in minutes
        $starttime=substr($datetime, -8);
        $start_hr=substr($starttime,0,-6);
        $start_min=substr($starttime,3,-3);
        $totalStartTime=totalTime($start_hr, $start_min);
        
        //Getting the hours and minutes for the current time and calculating the time in minutes
        $current_hr=date("h");
        $current_min=date("i");
        $ampm=date("a");
        $current_hr=  convertTo24hr($current_hr, $ampm);
        $totalCurrentTime=totalTime($current_hr, $current_min);
        
        //Getting calculating the time in minutes for countdown time
        $end_hr=2;
        $end_min=8;
        $totalEndTime=totalTime($end_hr, $end_min);
        
        //Getting the date when the presentation ends and restricting marking time to midnight
        $date=substr($datetime,0,-9);
        $time="02:08:00";
        $temp=array($date," ",$time);
        $datetime=implode($temp);
       
        
        
        if($totalCurrentTime<$totalStartTime)
        {
            echo "Presentation Not Commensed Yet";
        }
        else
        {
            echo '        
        <script>
        var countDownDate = new Date("'.$datetime.'");

        var x = setInterval(function() {

            var now = new Date().getTime();

            var distance = countDownDate - now;

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("demo").innerHTML = "Time Left: "+ hours + "h "
            + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);
        </script>';
            
            
        if($totalCurrentTime!=$totalEndTime)
        {
          echo '
        <div class="form">
        <h1>Assessment</h1>
        <form name="Assess" id="Assess" method="post">
      
            <label for="teamname">Team Name
            
                <input id="teamname" name="teamname" type="text" value="'.$teamname.'"></input>          
            
            <table>
            <tr> 
                <td class="column1">
               <label for="introduction">Effectiveness of the Introduction, the value proposition for the project
               and clearly explaining the original client problem</label>
                </td>
                <td class="column2">
                    <select class="mark" id="introduction" name="introduction" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
            <tr> 
                <td class="column1">
               <label for="objective">Clearly identified the objectives of the project explaining the solution 
               in terms of the problem and the methodologies the team used to solve the problem</label>
                </td>
                <td class="column2">
                    <select class="mark" id="objective" name="objective" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td class="column1">
               <label for="demo1">Product Demonstration: Demonstrated the requirements mentioned in point
               3 above</label>
                </td>
                <td class="column2">
                    <select class="mark" id="demo1" name="demo1"  required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td class="column1">
               <label for="demo2">Product Demonstration: Appropriate amount of detail, flowed smoothly,
               and demonstrating the product well.</label>
                </td>
                <td class="column2">
                    <select class="mark" id="demo2" name="demo2" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
            <tr> 
                <td class="column1">
               <label for="conclusion">Effectiveness of the conclusion including the final status at the end of the 
               project, the self assessment and how it could have been improved.</label>
                </td>
                <td class="column2">
                    <select class="mark" id="conclusion" name="conclusion"  required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td class="column1">
               <label for="questions">Responded to questions reasonably</label>
                </td>
                <td class="column2">
                    <select class="mark" id="questions" name="questions" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td class="column1">
               <label for="preparation">The groups preparation and teamwork was evident</label>
                </td>
                <td class="column2">
                    <select class="mark" id="preparation" name="preparation" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td class="column1">
               <label for="structure">The presentation was well-structured, organized into appropriate sections
               starting and finishing on time.</label>
                </td>
                <td class="column2">
                    <select class="mark" id="structure" name="structure"  required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td class="column1">
               <label for="enthusiasm">The presentation was enthusiastic, interesting, clear and concise 
               and was easy to understand</label>
                </td>
                <td class="column2">
                    <select class="mark" id="enthusiasm" name="enthusiasm" type="number" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td class="column1">
               <label for="visual">Visual aids were used effectively and changeover between speakers
               was smoothe and professional</label>
                </td>
                <td class="column2">
                    <select class="mark" id="visual" name="visual" type="number" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>

            
            </table>
            <div class="button-container">
            <input class="button" name="back" type="submit" value="Back" style="float:left;width:150px;">
            <input class="button" type="submit" name="submit" value="Submit"></input>
            </div>
        </form> 
        </div> ';   
        }
        else
        {
            echo 'Presentation Expired';
        }
                   
        }

        
        ?>
        
    <script>
       function validateForm()
       {
            var email=document.SuperUserLogin.email.value;
            var password=document.SuperUserLogin.password.value;
            
            /*some validation tests*/
        }
    </script> 
     
    </body>
    <footer>
           &#169;2017 All rights reserved by Murdoch University 
     </footer>
</html>


<?php
if(isset($_POST['submit']))
{
    $time=date("h:i:s");
    $date=date("Y-m-d");
    $temp=array($date," ",$time);
    $datetime=implode($temp);
    
    $intro=$_POST['introduction'];
    $obj=$_POST['objective'];
    $demo1=$_POST['demo1'];
    $demo2=$_POST['demo2'];
    $conclusion=$_POST['conclusion'];
    $questions=$_POST['questions'];
    $visual=$_POST['visual'];
    $enthusiasm=$_POST['enthusiasm'];
    $preparation=$_POST['preparation'];
    $structure=$_POST['structure'];
           
    $query="INSERT INTO Assessment VALUES ('$teamcode', '$email', '$datetime', "
                  . "'$intro', '$obj', '$demo1', '$demo2', '$conclusion', '$questions', '$preparation', '$structure', '$enthusiasm', '$visual', '33.6666', '-33.222');";
    $result=mysqli_query($dbc,$query);
    if($result)
    {
        echo '<script>alert("Assessment Successful");</script>';
        header("Location: PresentationDisplay.php");
    }
    else
    {
        echo '<script>alert("Assessment Failed! Try again!");</script>';
    }
    mysqli_close($dbc);
}
   ?>
