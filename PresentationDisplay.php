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
        
        <div>
        <?php
        
            $dateCurrent=date("Y-m-d");
            include 'dbconnect.php';	
            
            $query="SELECT TeamCode FROM PresentationSchedule WHERE Date='$dateCurrent'";
            $result=mysqli_query($dbc,$query);
            
            $j=0;
            $i=0;
            while($rows=mysqli_fetch_array($result))
            {               
                $teamcode[$j]=$rows['TeamCode']; 
                $j++; 
            }         
            
            for($k=0;$k<$j;$k++)
            {
                $query="SELECT * FROM Team WHERE TeamCode='$teamcode[$k]'";
                $result=mysqli_query($dbc,$query);
                echo '<table>';
                while($rows=mysqli_fetch_array($result))
                {
                    echo '<tr>';
                    $teamname=$rows['TeamName'];
                    $logo=$rows['Logo'];
                    $description=$rows['Description'];
                    echo '<td class="column2"><img src="'.$logo.'" style="width:50px;height:50px;"></td>';
                    echo '<td class="column2">'.$teamname.'</td>';
                    echo '<td class="column3">'.$description.'</td>';
                    echo '<td> <form method="post">'
                       . '<input class="button" type="submit" name="assess'.$i.'" id="assess'.$i.'" value="Assess"></input>'
                       . '</form></td>';
                    echo '</tr>';

                    if(isset($_POST['assess'.$i]))
                    {
                        $_SESSION['TeamCodeAssess']=$teamcode[$k];
                        header("Location: AssessPresentations.php");
                    }
                    $i++;
                      
                    echo '</table>'; 
                }
            }
           
            mysqli_close($dbc);  
        
        ?>          
        </div>
         
        
        
    </body>
    <footer>
           &#169;2017 All rights reserved by Murdoch University 
     </footer>
</html>

