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
    $fp1 = fopen('php://output', 'w');
    
    $downloadMarks[0] = array('Email');
    $select_date = "SELECT * FROM PresentationSchedule WHERE Date='$date'";
    //echo $select_date;
    $result1 = mysqli_query($dbc, $select_date);
    
    while ($rows = mysqli_fetch_array($result1)) 
    {
        $teamcode = $rows['TeamCode'];
        //echo $teamcode;
        array_push($downloadMarks[0], $teamcode);
        //$download_CSV[0]=array();
        /*$sort_emails="SELECT * FROM PresentationSchedule WHERE Date='$date'";
        $result2 = mysqli_query($dbc, $select_date);
        echo $sort_teamcodes;
        while ($rows = mysqli_fetch_array($result2)) 
        {
            $teamcode=$rows['TeamCode'];
        }*/
    
    }
    mysqli_close($dbc);
   /* $downloadMarks[0] = array('Email');
    array_push($downloadMarks[0],'Team1');

    
    very simple to increment with i++ if looping through a database result 
    $user_CSV[1] = array('Quentin', 'Del Viento', 34);
    $user_CSV[2] = array('Antoine', 'Del Torro', 55);
    $user_CSV[3] = array('Arthur', 'Vincente', 15);
*/
   
    foreach ($downloadMarks as $line) 
    {
        fputcsv($fp1, $line, ',');
    }
    fclose($fp1);
   
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

