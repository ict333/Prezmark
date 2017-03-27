<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
$role= $_SESSION['Role'];
if($role=="Admin")
{
    echo '<script>alert("Admin cannot Assess. Please Login as Unit Coordinator or Marker:")';
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
         <a href="index.php"> <img src="logo.png"></a>
        <nav>
            <a href="UploadStudentDetails.php" >Upload Student Details</a>
            <a href="CreateSchedule.php">New Schedule</a>
            <a href="PresentationDisplay.php" class="active">Assess Presentations</a>
            <a href="">Download Marks</a>
           <!-- <a href="">Modify Student Details</a>
            <a href="">Modify Schedule</a-->
           <a href="Logout.php">Logout</a>
        </nav>
        </div>
        <div id="separator"></div>
        
        <div>
        <?php
            include 'dbconnect.php';	
            $query="SELECT * FROM Team";
            $result=mysqli_query($dbc,$query);
            $i=1;
            echo '<table>';
            while($rows=mysqli_fetch_array($result))
            {
                echo '<tr>';
                $teamcode=$rows['TeamCode'];
                $teamname=$rows['TeamName'];
                $logo=$rows['Logo'];
                $description=$rows['Description'];
                echo '<td>'.$teamcode.'</td>';
                echo '<td><img src="'.$logo.'"></td>';
                echo '<td>'.$teamname.'</td>';
                echo '<td>'.$description.'</td>';
                echo '<td> <form method="post">'
                . '<input class="button" type="submit" name="assess'.$i.'" id="assess'.$i.'" value="Assess"></input>'
                  . '</form></td>';
                echo '</tr>';
                
                 if(isset($_POST['assess'.$i]))
                {
                    $_SESSION['TeamCodeAssess']=$teamcode;
                    header("Location: AssessPresentations.php");
                }
                $i++;
            }  
            echo '</table>'; 
            
           
            mysqli_close($dbc);  
        
        ?>          
        </div>
        
     
    </body>
    <footer>
           &#169;2017 All rights reserved by Murdoch University 
     </footer>
</html>

