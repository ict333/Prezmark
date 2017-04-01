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
            
        <h1>Download Marks</h1>
        <form method="post">
               
        <label for="date">Date</label><br> 
        <input id="date" name="date" type="date" required></input>
        <br> </br>
        
        
        <!--label for="date">Unit Offering</label><br>
        <select name="" id="" required>
        <?php
            /*for($i=0;$i<count($name);$i++)
            {
                echo "<option value='$name[$i]'>$name[$i]</option>";
            }*/
        ?>
        </select-->
        <input class="button" name="download" type="submit" value="Download"/>
     
        </form> 
        </div>
        <footer>
           &#169;2017 All rights reserved by Murdoch University 
        </footer>
    </body>
</html>


<?php

if(isset($_POST['download']))
{

    header('Content-Type: application/excel');
    header('Content-Disposition: attachment; filename="sample1.csv"');
    $fp = fopen('php://output', 'w');
    $user_CSV[0] = array('Role', 'MarkerFirstName', 'MarkerLastName','Email',
        'Affiliation','TeamNumber1_Marks','TeamNumber2_Marks','TeamNumber3_Marks','TeamNumber4_Marks');

    
    // very simple to increment with i++ if looping through a database result 
    $user_CSV[1] = array('Quentin', 'Del Viento', 34);
    $user_CSV[2] = array('Antoine', 'Del Torro', 55);
    $user_CSV[3] = array('Arthur', 'Vincente', 15);

   
    foreach ($user_CSV as $line) 
    {
        fputcsv($fp, $line, ',');
    }
    fclose($fp);
}

?>