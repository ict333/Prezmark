<?php
include("dbconnect.php");
session_start();
$date=$_SESSION['Date'];
$venue=$_SESSION['Venue'];
$unitoffering=$_SESSION['UnitOffering'];
ini_set('display_errors',1);
error_reporting(E_ALL);
//$user=$_SESSION[user];
?>
<!DOCTYPE html>
<html> 
    <head>
        
    </head>
    
    <body>
        <?php
            $query="SELECT TeamName FROM Team WHERE UnitOffering='$unitoffering';";
            $result=mysqli_query($dbc,$query);
            $name=array();
            $i=0;
            while($rows=mysqli_fetch_array($result))
            {
                $name[$i]=$rows['TeamName'];
                $i++;
            }
            
        ?>
        <form action="" name="FillPresentationSchedule" id="FillPresentationSchedule" method="post">
            <legend></legend>
            
            <label for="teamname">Team Name
            <select name="teamname" id="teamname" required>
            <?php
                for($i=0;$i<count($name);$i++)
                {
                    echo "<option value='$name[$i]'>$name[$i]</option>";
                }
            
            ?>
            </select>
            </label>
            <br></br>
            
            <label for="logo">Logo
            <input id="imagefile" name="imagefile" type="file" ></input>
            </label>
            <br> </br>
            
            <label for="description">Description
            <textarea id="description" name="description" type="textarea"></textarea>
            </label>
            <br> </br>
            
            <label for="slot">Time Slot
            <select name="slot" id="slot" required>
                <option value="9:30-10:00">9:30-10:00</option>
                <option value="10:00-10:30">10:00-10:30</option>
                <option value="10:30-11:00">10:30-11:00</option>
                <option value="11:00-11:30">11:00-11:30</option>
                <option value="11:30-12:00">11:30-12:00</option>
                <option value="12:00-12:30">12:00-12:30</option>
                <option value="12:30-1:00">12:30-1:00</option>
                <option value="1:00-1:30">1:00-1:30</option>
                <option value="1:30-2:00">1:30-2:00</option>
                <option value="2:00-2:30">2:00-2:30</option>
                <option value="2:30-3:00">2:30-3:00</option>
                <option value="3:00-3:30">3:00-3:30</option>
                <option value="3:30-4:00">3:30-4:00</option>
                <option value="4:00-4:30">4:00-4:30</option>
                <option value="4:30-5:00">4:30-5:00</option>
                <option value="5:00-5:30">5:00-5:30</option>
                <option value="5:30-6:00">5:30-6:00</option>
            </select>
            </label>
            <br></br>
            
             <input name="next" type="submit" value="Next">
             <input name="finish" type="submit" value="Finish">
        </form>  
        
        <?php
            if(isset($_POST['next']))
            {
                $teamname=$_POST['teamname'];
                $description=$_POST['description'];
                $query="SELECT TeamCode FROM Team WHERE TeamName='$teamname' AND UnitOffering='$unitoffering'";
                $result=mysqli_query($dbc,$query);

                while($rows=mysqli_fetch_array($result))
                {
                   $teamcode=$rows['TeamCode'];
                }

                $query="INSERT INTO PresentationSchedule VALUES('$date','peter.cole@gmail.com','$teamcode','$venue')";
                $result = mysqli_query($dbc,$query); 

                $query="UPDATE Team SET Logo='/path', Description='$description',TimeSlot='2017-03-04 15:27:26' WHERE TeamCode='$teamcode'";
                $result = mysqli_query($dbc,$query); 
                echo $query;
                //header("Location: FillPresentationSchedule.php");
            } 
               
                               
                
            
            if(isset($_POST['finish']))
            {
                
            }
            
          
            
        
        ?>
    </body>
</html>
