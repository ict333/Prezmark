<?php
ini_set('display_errors',1);
error_reporting (E_ALL);

session_start();
$role= $_SESSION['Role'];
if($role!="UC")
{
    header("Location: SuperUserLogin.php");
}
?>

<?php

if(isset($_POST['download']))
{
    $date=$_POST['date'];
    include 'dbconnect.php';
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="sample1.csv"');
    $fp = fopen('php://output', 'w');
    
    $downloadMarks[0] = array('Email');
    
    $select_date = "SELECT * FROM PresentationSchedule WHERE Date='$date'";
    $result1 = mysqli_query($dbc, $select_date);
    
    while ($rows = mysqli_fetch_array($result1)) 
    {
        $teamcode = $rows['TeamCode'];
        array_push($downloadMarks[0], $teamcode);   
    }
    
    $query = "SELECT * FROM Assessment";
    $result = mysqli_query($dbc, $query);
    $people_assessed=array();
    while ($rows = mysqli_fetch_array($result)) 
    {
        $time=$rows['Time'];
        $email=$rows['Email'];
        $all_dates=substr($time,0,-9);
        
        if($all_dates==$date)
        {
            array_push($people_assessed,$email);
        }
    }
    
    $people=array_unique($people_assessed);
     for($i=1,$j=0;$j<count($people);$j++,$i++)
     {
        $downloadMarks[$i]=array();
        $query= "SELECT * FROM Person WHERE Email='$people[$j]'";
        $result = mysqli_query($dbc, $query);
        while ($rows = mysqli_fetch_array($result)) 
        {
            $role=$rows['Role'];
            if($role=="Marker")
            {
                
            }
            else
            {
                
            }
        }
         array_push($downloadMarks[$i], $people[$j]);
     }
     
     //put the assessments in the file
     $query= "SELECT * FROM PresentationSchedule WHERE Date='$date'";
     $result = mysqli_query($dbc, $query);
     $teamcodes=array();
     while ($rows = mysqli_fetch_array($result)) 
     {
        array_push($teamcodes, $rows['TeamCode']);
     }
     
     for($k=0;$k<count($teamcodes);$k++)
     {
         
        for($j=0, $i=1;$j<count($people);$j++,$i++)
        {
           $query= "SELECT * FROM Assessment WHERE TeamCode='$teamcodes[$k]' AND Email='$people[$j]'";
           $result = mysqli_query($dbc, $query);
          
           while ($rows = mysqli_fetch_array($result)) 
           {
                $total=$rows['Introduction']+$rows['Objectives']+$rows['Demonstration1']+$rows['Demonstration2']+$rows['Conclusion']
                            +$rows['Question']+$rows['Preparation']+$rows['Structure']+$rows['Enthusiasm']+$rows['VisualAid']; 
                    
                array_push($downloadMarks[$i], $total);
           }          
        }
     }

     
    mysqli_close($dbc);
        
   foreach ($downloadMarks as $line) 
    {
        fputcsv($fp, $line, ',');
    }
    fclose($fp);
   
}
else
{
   echo '<html> 
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
            
        <h1>Download Marks</h1>
        <form method="post">
               
        <label for="date">Date</label><br> 
        <input id="date" name="date" type="date" required></input>
        <br> </br>
        
        
        <!--label for="date">Unit Offering</label><br>
        <select name="" id="" required>
       
            //insert here
        
        </select-->
        <input class="button" name="download" type="submit" value="Download"/>
     
        </form> 
        </div>
        
        <footer>
           &#169;2017 All rights reserved by Murdoch University 
        </footer>
    </body>
</html>'; 
}

//insert here
/*for($i=0;$i<count($name);$i++)
            {
                <option value='$name[$i]'>$name[$i]</option>
            }*/

//shortlist the assessments to the given date
//the units created by a uc in the drop down
// shortlist the assessments based on the unit offering
//store all teamcodes and email. associative array
?>

