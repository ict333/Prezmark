<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
$role= $_SESSION['Role'];
$email=$_SESSION['Email'];
if((!isset($email))||(!isset($role)))
{
    echo '<script>alert("Session not Set")</script>';
    header("Location: SuperUserLogin.php");
}
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
        <!--
        Authors: Christopher Thomas
                 Esha Shetty
                 Sasha Jazzabelle
        Date: 12th April 2017
        -->
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
              <a href="Logout.php">Logout</a>
           </nav>
           </div>';
        }
        else
        {
            echo '<div class="header">
            <img src="logo.png">
           <nav>
               <a href="PresentationDisplay.php" class="active">Assess Presentations</a>
              <a href="LogoutMarker.php">Logout</a>               
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
            if(mysqli_num_rows($result)==0)
            {
                echo "No Presentations to Assess";
            }
            
            else
            {
                $j=0;
                $i=0;
                $p=0;
                while($rows=mysqli_fetch_array($result))
                {         
                    $teamcode[$j]=$rows['TeamCode']; 
                    $j++; 
                }         

                $query="SELECT Venue FROM PresentationSchedule WHERE Date='$dateCurrent'";
                $result=mysqli_query($dbc,$query);
                 while($rows=mysqli_fetch_array($result))
                {
                    $venue[$p]=$rows['Venue']; 
                    $p++;
                }

                echo '<div class="container">';
               echo ' <table>
                <tr>
                <td><b>Date:</b> </h4>'.date("d-m-Y").'</td>            
                </tr>
                </table>';
                echo '</div>';
                                
                 echo '<table>';
                 echo '<tr>';
                 echo '<td class="column2"><b>Team Logo</b></td>';
                 echo '<td class="column2"><b>Team Name</b></td>';
                 echo '<td class="column3"><b>Description</b></td>';
                 echo '<td class="column3"><b>Location</b></td>';
                 echo '<td></td>';
                 echo '</tr>';
                for($k=0;$k<$j;$k++)
                {
                    $query="SELECT * FROM Team WHERE TeamCode='$teamcode[$k]'";
                    $result=mysqli_query($dbc,$query);
                    while($rows=mysqli_fetch_array($result))
                    {
                        echo '<tr>';
                        $teamname=$rows['TeamName'];
                        $logo=$rows['Logo'];
                        $description=$rows['Description'];
                        echo '<td class="column2"><img src="'.$logo.'" style="width:50px;height:50px;"></td>';
                        echo '<td class="column2">'.$teamname.'</td>';
                        echo '<td class="column3">'.$description.'</td>';
                        echo '<td class="column3">'.$venue[$k].'</td>';
                        echo '<td> <form method="post">'
                           . '<input class="buttonAssess" type="submit" name="assess'.$i.'" id="assess'.$i.'" value="Assess"></input>'
                           . '</form></td>';
                        echo '</tr>';

                        if(isset($_POST['assess'.$i]))
                        {
                            $_SESSION['TeamCodeAssess']=$teamcode[$k];
                            header("Location: AssessPresentations.php");
                        }
                        $i++;

                    }
                }
                
                echo '</table>'; 
            }
                
            
           
            mysqli_close($dbc);  
        
        ?>          
        </div>
         
        
        
    </body>
    <footer>
           &#169;2017 All rights reserved by Murdoch University 
     </footer>
</html>

