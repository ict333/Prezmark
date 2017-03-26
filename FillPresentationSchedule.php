<?php
include("dbconnect.php");
session_start();
$role= $_SESSION['Role'];
$email=$_SESSION['Email'];
if($role!="UC")
{
    header("Location: SuperUserLogin.php");
}
$date=$_SESSION['Date'];
$venue=$_SESSION['Venue'];
$unitoffering=$_SESSION['UnitOffering'];
ini_set('display_errors',1);
error_reporting(E_ALL);
//$user=$_SESSION[user];


$query = "SELECT TeamName FROM Team WHERE UnitOffering='$unitoffering';";
$result = mysqli_query($dbc, $query);
$name = array();
$i = 0;
while ($rows = mysqli_fetch_array($result)) {
    $name[$i] = $rows['TeamName'];
    $i++;
}
?>
<!DOCTYPE html>
<html> 
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">  
        <link rel="icon" href="icon.png" type="image/x-icon"></link>      
    </head>
    
    <body>
        <div class="header">
         <a href="index.php"> <img src="logo.png"></a>
        <nav>
            <a href="UploadStudentDetails.php" >Upload Student Details</a>
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
        <form action="" name="FillPresentationSchedule" id="FillPresentationSchedule" method="post"enctype="multipart/form-data">
           
        <h1>Team Schedule</h1>
            
            <label for="teamname">Team Name<br>
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
            
            <label for="logo">Logo<br>
            <input id="imagefile" name="imagefile" type="file" ></input>
            </label>
            <br> </br>
            
            <label for="description">Description<br>
            <input id="description" name="description" type="text"></input>
            </label>
            <br> </br>
            
            <!--label for="duration">Duration
            <input id="duration" name="duration" value="0" type="number"></input>
            </label>
            <br> </br-->
            
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
            <!--?php
                $start = strtotime('9:30 AM');
                $end   = strtotime('6:30 PM');
                echo "<script>$t=document.getElementById('duration').value</script>";
                for ($hours = 9; $hours < 18; $hours++)
                { // the interval for hours is '1'
                    if ($hours>12){$hours=$hours-12;}
                    for ($mins = 0; $mins < 60; $mins+=30) 
                    { // the interval for mins is '35'
                    echo '<option>' . str_pad($hours, 2, '0', STR_PAD_LEFT) . ':'
                    . str_pad($mins, 2, '0', STR_PAD_LEFT) . '</option>';
                    }
                }
            ?-->
            </select>
            </label>
            <br></br>
            <div class="button-container">
            <input class="button" name="next" type="submit" value="Next" style="float:left;width:150px;">
             <input class="button" name="finish" type="submit" value="Finish" style="width:150px;">
            </div>
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
                $teamname=$_POST['teamname'];
                $description=$_POST['description'];
               // $time=$_POST['time'];
                $query="SELECT TeamCode FROM Team WHERE TeamName='$teamname' AND UnitOffering='$unitoffering'";
                $result=mysqli_query($dbc,$query);

                while($rows=mysqli_fetch_array($result))
                {
                   $teamcode=$rows['TeamCode'];
                }

                $query="INSERT INTO PresentationSchedule VALUES('$date','$email','$teamcode','$venue')";
                $result = mysqli_query($dbc,$query); 
               // echo $query;

                $query="UPDATE Team SET Description='$description',TimeSlot='2017-03-04 15:27:26' WHERE TeamCode='$teamcode'";
                $result = mysqli_query($dbc,$query); 
               // echo $query;
                
                

                $target_dir = "TeamLogo/";
                $target_file = $target_dir . basename($_FILES["imagefile"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                // Check if image file is a actual image or fake image

                $check = getimagesize($_FILES["imagefile"]["tmp_name"]);
                if($check !== false) 
                {
                    echo '<script>alert("File is an image - " . $check["mime"] . ".")</script>';
                    $uploadOk = 1;
                } 
                else 
                {
                    echo '<script>alert("File is not an image")<script>';
                    $uploadOk = 0;
                }

                // Check if file already exists
                if (file_exists($target_file)) 
                {
                    echo '<script>alert("Sorry, file already exists.")</script>';
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["imagefile"]["size"] > 500000) 
                {
                    echo '<script>alert("Sorry, your file is too large")</script>';
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) 
                {
                    echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed")</script>';
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0)
                {
                    echo '<script>alert("Sorry, your file was not uploaded"</script>';
                // if everything is ok, try to upload file
                } 
                else 
                {
                    if (move_uploaded_file($_FILES["imagefile"]["tmp_name"], $target_file))
                    {
                        echo "The file ". basename( $_FILES["imagefile"]["name"]). " has been uploaded.";
                        $query="UPDATE Team SET Logo='$target_file' WHERE TeamCode='$teamcode'";
                        $result=mysqli_query($dbc,$query);
                        echo '<script>alert("Schedule Created Successfully");</script>';
                    } 
                    else 
                    {
                        echo '<script>alert("Sorry, there was an error uploading your file");</script>';
                    }
                }

            } 
               
                               
                
            
            if(isset($_POST['finish']))
            {
                
            }
            
          
            
        
        ?>
