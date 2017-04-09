<?php
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
ini_set('display_errors',1);
    error_reporting (E_ALL);
    
?>
<html> 
    <head>        
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="icon.png" type="image/x-icon"></link>
    </head>
    
    <body>
        <div class="header">
         <a href="index.php"> <img src="logo.png" ></a>
        <nav>
            <a href="UploadStudentDetails.php" class="active">Upload Student Details</a>
            <a href="CreateSchedule.php">New Schedule</a>
            <a href="PresentationDisplay.php">Assess Presentations</a>
            <a href="DownloadMarks.php">Download Marks</a>
            <!--a href="">Modify Student Details</a>
            <a href="">Modify Schedule</a-->
            <a href="Logout.php">Logout</a>
        </nav>
        </div>
        
	<div id="separator"></div>
        
        
        <div class="form">
            
        <h1>Upload Student Details</h1>
        <form name="UploadStudent" method="post" action="UploadStudentDetails.php" onsubmit="return validate()" enctype="multipart/form-data">
                   
        <label for="unit">Unit</label>
        <br> 
        <input id="unit" name="unit" type="text" required placeholder="For example: ICT333/ICT312"></input>
        <br> </br>
            
        <label for="semester">Teaching Period</label>
        <br> 
        <input id="semester" name="semester" type="text" required placeholder="For example: S1/S2/TJD/TMD/TSD"></input>
        <br> </br>
            
        <label for="year">Year</label>
        <br> 
        <input id="year" name="year" type="text" required></input>
        <br> </br>
        
   
        <label>Choose file to upload</label>
        <br>
        <input type="file" name="csvfile" id="csvfile" accept=".csv"  required> 
        <br> </br>
        <input class="button" name="upload" type="submit" value="Upload"/>
     
        </form> 
        </div>
        
        <script>
            function validate()
            {
                var year=document.UploadStudent.year.value;
                var teaching=document.UploadStudent.semester.value;
                if(isNaN(year))
                {
                    alert("Please Enter Numeric Values for Year!");
                    return false;
                }
                if(teaching.length()>3)
                {
                    alert("Please enter a valid teaching period!");
                }
            }
        </script>
        
        <footer>
           &#169;2017 All rights reserved by Murdoch University 
        </footer>
    </body>
</html>


<?php

if(isset($_POST['upload']))
{
    $folder="File/";
    $unit=$_POST['unit'];
    $semester=$_POST['semester'];
    $year=$_POST['year'];
    $offering=array($unit,$semester,$year);
    $unitoffering=implode($offering);
    $teamcode=array();
    
    if(isset($_FILES["csvfile"]["error"]))
    {
        if($_FILES["csvfile"]["error"] > 0)
        {
            echo "<script>alert('Error: " . $_FILES["csvfile"]["error"] . "')</scrpt>";
        }
        else
        {
            //$allowed =array(array("csv"=>"application/vnd.msexcel"),array("csv"=>"text/csv"),);
            $filename = $_FILES["csvfile"]["name"];
            $filetype = $_FILES["csvfile"]["type"];
            $filesize = $_FILES["csvfile"]["size"];      
            
            // Verify file extension
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            /*if(!array_key_exists($ext, $allowed[1])) 
            {
                die("Error: Please select a valid file format.");
            }
            else if(!array_key_exists($ext, $allowed[0]))
            {
                die("Error: Please select a valid file format.");                
            }*/
            if($ext!="csv")
            {
                die("Error: Please select a valid file format.");
            }
       
            // Verify file size - 2MB maximum
            $maxsize = 2 * 1024 * 1024;

            if($filesize > $maxsize)
            {
                die("Error: File size is larger than the allowed limit.");
            }

            /* Verify MIME type of the file
            if(in_array($filetype, $allowed[0])||in_array($filetype, $allowed[1]))
            {*/
            if($ext=="csv"){
                // Check whether file exists before uploading it
                if(file_exists($folder . $_FILES["csvfile"]["name"]))
                {
                    echo "<script>alert('".$_FILES["csvfile"]["name"] ." already exists.')</script>";
                } 
                else
                {
                                       
                    if(move_uploaded_file($_FILES["csvfile"]["tmp_name"], $folder. $_FILES["csvfile"]["name"]))
                    {
                        echo '<script>alert("Your file was uploaded successfully");</script>';
                    }
                    
                    //Read from file
                    $file = fopen("File/".$_FILES["csvfile"]["name"],"r");
                    //skips first line
                    fgetcsv($file);
                    $count=0;
                    include 'dbconnect.php';
                    while (($line = fgetcsv($file)) !== FALSE) 
                    {                        
                        $temp=array($unitoffering,$line[6]);
                        $teamcode[$count]=  implode($temp);
                        
                        $query="INSERT INTO Team (TeamCode, TeamNo, TeamName, UnitOffering) VALUES('$teamcode[$count]','$line[6]','$line[5]','$unitoffering')";
                        //echo $query;
                        $result = mysqli_query($dbc,$query); 
                        
                        $query="INSERT INTO Student VALUES('$line[0]','$teamcode[$count]','$line[2]','$line[3]','$line[1]','$line[4]')";
                        //echo $query;
                        $result = mysqli_query($dbc,$query); 
                        
                    }
                  
                    mysqli_close($dbc);
                    fclose($file);
                } 

            }
            else
            {
                echo "<script>alert('Error: There was a problem uploading your file - please try again.')</script>"; 
            }
        }

    }
    else
    {
        echo "<script>alert('Error: Invalid parameters - please contact your server administrator.')</script>";
    }
}

?>