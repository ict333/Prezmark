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

include 'dbconnect.php';

if(isset($_POST['download1']))
{
    
    $date=$_POST['date'];
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="Marks_Per_Team_Per_Role.csv"');
    $fp = fopen('php://output', 'w');
    
    $downloadMarks[0] = array('Role','MarkerFirstName','MarkerLastName','Email', 'Affiliation');
    
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
    $people=array_values($people);
    $students=array();
    $visitors=array();
    $clients=array();
    $uc=array();
    for($i=0;$i<count($people);$i++)
    {
        $query= "SELECT * FROM Marker WHERE Email='$people[$i]'";
        $result = mysqli_query($dbc, $query);
        
        if(mysqli_num_rows($result)==0)
        {
            array_push($uc,$people[$i]);
        }
        while ($rows = mysqli_fetch_array($result)) 
        {
            $R=$rows['Role'];
            if($R=="Student")
            {
                array_push($students,$people[$i]);
            }
            else if($R=="Visitor")
            {
                array_push($visitors,$people[$i]);
            }
            else
            {
                array_push($clients,$people[$i]);                
            }
        }
    }
    
    $people=array_merge($students,$visitors,$clients,$uc);
 
     for($i=1,$j=0;$j<count($people);$j++,$i++)
     {
        $downloadMarks[$i]=array();
        $query= "SELECT * FROM Person WHERE Email='$people[$j]'";
        $result = mysqli_query($dbc, $query);
        
        while ($rows = mysqli_fetch_array($result)) 
        {
            $role1=$rows['Role'];
            if($role1=="Marker")
            {
                $query= "SELECT * FROM Marker WHERE Email='$people[$j]'";
                $result = mysqli_query($dbc, $query);
                while ($rows = mysqli_fetch_array($result)) 
                {
                    $role2=$rows['Role'];
                    $fname=$rows['FirstName'];
                    $lname=$rows['LastName'];
                    $aff=$rows['Affiliation'];
                    if($role2=="Client")
                    { 
                        array_push($downloadMarks[$i], "Visitor");
                    }
                    else
                    {
                        array_push($downloadMarks[$i], $role2);
                    }
                    array_push($downloadMarks[$i], $fname);
                    array_push($downloadMarks[$i], $lname);
                    array_push($downloadMarks[$i], $people[$j]);
                    array_push($downloadMarks[$i], $aff);                  
                }
                               
            }
            else
            {
                $query= "SELECT * FROM SuperUser WHERE Email='$people[$j]'";
                $result = mysqli_query($dbc, $query);
                while ($rows = mysqli_fetch_array($result)) 
                {
                    array_push($downloadMarks[$i], "Staff");
                    array_push($downloadMarks[$i], " ");
                    array_push($downloadMarks[$i], " ");
                    array_push($downloadMarks[$i], $people[$j]);
                    array_push($downloadMarks[$i], " ");     
                }
                
            }
        }
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
           
           if(mysqli_num_rows($result)!=0)
            {
                while ($rows = mysqli_fetch_array($result)) 
                {
                     $total=$rows['Introduction']+$rows['Objectives']+$rows['Demonstration1']+$rows['Demonstration2']+$rows['Conclusion']
                                 +$rows['Question']+$rows['Preparation']+$rows['Structure']+$rows['Enthusiasm']+$rows['VisualAid']; 

                     array_push($downloadMarks[$i], $total);
                }  
            }
            else
            {
                array_push($downloadMarks[$i], "");
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

else if(isset($_POST['download2']))
{
    $date=$_POST['date'];
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="Total_Average_Per_Team.csv"');
    $fp2 = fopen('php://output', 'w');
    
    $averageMarks[0] = array('TeamNames','Staff','Visitor','Student','Total');
    $countTeams=1;
    $select_date = "SELECT * FROM PresentationSchedule WHERE Date='$date'";
  
    $result1 = mysqli_query($dbc, $select_date);
    
    while ($rows = mysqli_fetch_array($result1)) 
    {
        $teamcode = $rows['TeamCode'];
        $averageMarks[$countTeams]=array();
        array_push($averageMarks[$countTeams], $teamcode);   
        $countTeams++;
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
    $people=array_values($people);
    $students=array();
    $visitors=array();
    $clients=array();
    $uc=array();
    for($i=0;$i<count($people);$i++)
    {
        $query= "SELECT * FROM Marker WHERE Email='$people[$i]'";
        $result = mysqli_query($dbc, $query);
        
        if(mysqli_num_rows($result)==0)
        {
            array_push($uc,$people[$i]);
        }
        while ($rows = mysqli_fetch_array($result)) 
        {
            $R=$rows['Role'];
            if($R=="Student")
            {
                array_push($students,$people[$i]);
            }
            else if($R=="Visitor")
            {
                array_push($visitors,$people[$i]);
            }
            else
            {
                array_push($clients,$people[$i]);                
            }
        }
    }
    
         //put the averages in the file
     $query= "SELECT * FROM PresentationSchedule WHERE Date='$date'";
     $result = mysqli_query($dbc, $query);
     $teamcodes=array();
     while ($rows = mysqli_fetch_array($result)) 
     {
        array_push($teamcodes, $rows['TeamCode']);
     }
     
     for($k=0,$i=1;$k<count($teamcodes);$k++,$i++)
     {       
        $staffTotal=0;
        $visitorTotal=0;
        $studentTotal=0;
        $Gtotal=0;
        
        $countStaff=0;
        $countVisitor=0;
        $countStudent=0;
        
        $averageStaff=0.0;
        $averageVisitor=0.0;
        $averageStudent=0.0;
        $averageTotal=0;
        $t=0.0;
        
        
        //calculating total staff marks for team 'k'
        for($j=0;$j<count($uc);$j++)
        {
           $query= "SELECT * FROM Assessment WHERE TeamCode='$teamcodes[$k]' AND Email='$uc[$j]'";
           $result = mysqli_query($dbc, $query);
           
           if(mysqli_num_rows($result)!=0)
            {
                while ($rows = mysqli_fetch_array($result)) 
                {
                     $total=$rows['Introduction']+$rows['Objectives']+$rows['Demonstration1']+$rows['Demonstration2']+$rows['Conclusion']
                                 +$rows['Question']+$rows['Preparation']+$rows['Structure']+$rows['Enthusiasm']+$rows['VisualAid']; 
                     $staffTotal+=$total;
                     $averageTotal+=$total;
                } 
                $countStaff++;
                $Gtotal++;
            }
        }
        //calculating total visitors marks for team 'k'        
        for($j=0;$j<count($visitors);$j++)
        {
           $query= "SELECT * FROM Assessment WHERE TeamCode='$teamcodes[$k]' AND Email='$visitors[$j]'";
           $result = mysqli_query($dbc, $query);
           
           if(mysqli_num_rows($result)!=0)
            {
                while ($rows = mysqli_fetch_array($result)) 
                {
                     $total=$rows['Introduction']+$rows['Objectives']+$rows['Demonstration1']+$rows['Demonstration2']+$rows['Conclusion']
                                 +$rows['Question']+$rows['Preparation']+$rows['Structure']+$rows['Enthusiasm']+$rows['VisualAid']; 
                     $visitorTotal+=$total;
                     $averageTotal+=$total;
                }  
                $countVisitor++;
                $Gtotal++;
            }
        }
        
        //calculating total client marks for team 'k'
        for($j=0;$j<count($clients);$j++)
        {
           $query= "SELECT * FROM Assessment WHERE TeamCode='$teamcodes[$k]' AND Email='$clients[$j]'";
           $result = mysqli_query($dbc, $query);
           
           if(mysqli_num_rows($result)!=0)
            {
                while ($rows = mysqli_fetch_array($result)) 
                {
                     $total=$rows['Introduction']+$rows['Objectives']+$rows['Demonstration1']+$rows['Demonstration2']+$rows['Conclusion']
                                 +$rows['Question']+$rows['Preparation']+$rows['Structure']+$rows['Enthusiasm']+$rows['VisualAid']; 
                     $visitorTotal+=$total;
                     $averageTotal+=$total;
                } 
                $countVisitor++;
                $Gtotal++;
            }
        }
        
        //calculating total student marks for team 'k'
        for($j=0;$j<count($students);$j++)
        {
           $query= "SELECT * FROM Assessment WHERE TeamCode='$teamcodes[$k]' AND Email='$students[$j]'";
           $result = mysqli_query($dbc, $query);
           
           if(mysqli_num_rows($result)!=0)
            {
                while ($rows = mysqli_fetch_array($result)) 
                {
                     $total=$rows['Introduction']+$rows['Objectives']+$rows['Demonstration1']+$rows['Demonstration2']+$rows['Conclusion']
                                 +$rows['Question']+$rows['Preparation']+$rows['Structure']+$rows['Enthusiasm']+$rows['VisualAid']; 
                     $studentTotal+=$total;
                     $averageTotal+=$total;
                }  
                $countStudent++;
                $Gtotal++;
            }
        }
      
        if($countStaff!=0)
        {   
            $averageStaff=$staffTotal/$countStaff;
        }
        if($countVisitor!=0)
        {
           // $averageVistor=$visitorTotal/$countVisitor;  
            $avg=$visitorTotal/$countVisitor;
        }
        if($countStudent!=0)
        {   
            $averageStudent=$studentTotal/$countStudent;
        }
        
        $t=$averageTotal/$Gtotal;
        array_push($averageMarks[$i], $averageStaff);
        array_push($averageMarks[$i], $avg);
        array_push($averageMarks[$i], $averageStudent);
        array_push($averageMarks[$i], $t);
     }
      
    
    
    foreach ($averageMarks as $line) 
    {
        fputcsv($fp2, $line, ',');
    }
    fclose($fp2); 
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
            <a href="UploadStudentDetails.php">Upload Student Details</a>
            <a href="CreateSchedule.php">New Schedule</a>
            <a href="PresentationDisplay.php">Assess Presentations</a>
            <a href="DownloadMarks.php"  class="active">Download Marks</a>
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
        <div class="button-container">
            <input class="button" name="download1" type="submit" value="Download1" style="float:left;width:150px;"/>
            <input class="button" name="download2" type="submit" value="Download2" style="width:150px;">
        </div>
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

