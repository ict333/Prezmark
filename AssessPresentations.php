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

$query = "SELECT TeamName FROM Team WHERE UnitOffering='$unitoffering';";
$result = mysqli_query($dbc, $query);
$name = array();
$i = 0;
while ($rows = mysqli_fetch_array($result)) 
{
    $name[$i] = $rows['TeamName'];
    $i++;
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
            <a href="AssessPresentations.php" class="active">Assess Presentations</a>
            <a href="">Download Marks</a>
            <a href="">Modify Student Details</a>
            <a href="">Modify Schedule</a>
            <a href="">Logout</a>
        </nav>
        </div>
        <div id="separator"></div>
        
        
        <div class="form">
        <h1>Assessment</h1>
       <form name="Assess" id="Assess" method="post" onsubmit="">
      
       
        <label for="teamname">Team Name
            <select name="teamname" id="teamname" required>
            <?php
                $query="SELECT distinct TeamName FROM Team";
                $result=mysqli_query($dbc,$query);
                while($rows=mysqli_fetch_array($result))
                {
                        $team=$rows['TeamName'];
                        echo "<option value='$team'>$team</option>";
                }
            
            ?>
            </select>
            <table>
            <tr> 
                <td>
               <label for="introduction">Effectiveness of the Introduction, the value proposition for the project
               and clearly explaining the original client problem</label>
                </td>
                <td>
                    <select id="introduction" name="introduction" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
            <tr> 
                <td>
               <label for="objective">Clearly identified the objectives of the project explaining the solution 
               in terms of the problem and the methodologies the team used to solve the problem</label>
                </td>
                <td>
                    <select id="objective" name="objective" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="demo1">Product Demonstration: Demonstrated the requirements mentioned in point
               3 above</label>
                </td>
                <td>
                    <select id="demo1" name="demo1"  required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="demo2">Product Demonstration: Appropriate amount of detail, flowed smoothly,
               and demostrating the product well.</label>
                </td>
                <td>
                    <select id="demo2" name="demo2" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="conclusion">Effectiveness of the conclusion including the final status at the end of the 
               project, the self assessment and how it could have been improved.</label>
                </td>
                <td>
                    <select id="conclusion" name="conclusion"  required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="questions">Responded to questions reasonalbly</label>
                </td>
                <td>
                    <select id="questions" name="questions" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="preparation">The group's preparation and teamwork was evident</label>
                </td>
                <td>
                    <select id="preparation" name="preparation" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="structure">The presentation was well-structured, organized into appropriate sections
               starting and finishing on time.</label>
                </td>
                <td>
                    <select id="structure" name="structure"  required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="enthusiasm">The presentation was enthusiastic, interesting, clear and consise 
               and was easy to understand</label>
                </td>
                <td>
                    <select id="enthusiasm" name="enthusiasm" type="number" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="visual">Visual aids were used effectively and changeover between speakers
               was smoothe and professional</label>
                </td>
                <td>
                    <select id="visual" name="visual" type="number" required>
                        <option value="0">Mark</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>  
                </td>
            </tr>

            
            </table>
        <input class="button" type="submit" name="Assess" value="Assess"></input>
       
    </form>
        </div> 
    <script>
       function validateForm()
       {
            var email=document.SuperUserLogin.email.value;
            var password=document.SuperUserLogin.password.value;
            
            /*some validation tests*/
        }
    </script> 
     
    </body>
    <footer>
           &#169;2017 All rights reserved by Murdoch University 
     </footer>
</html>

<?php
        if(isset($_POST['Assess']))
        {
            $intro=$_POST['introduction'];
            $obj=$_POST['objective'];
            $demo1=$_POST['demo1'];
            $demo2=$_POST['demo2'];
            $conclusion=$_POST['conclusion'];
            $questions=$_POST['questions'];
            $visual=$_POST['visual'];
            $enthusiasm=$_POST['enthusiasm'];
            $preparation=$_POST['preparation'];
            $structure=$_POST['structure'];
            /*$query="insert into Assessment Introduction,Objectives,Demonstration1"
                    . ",Demonstration2,Conclusion,Question,Preparation,Structure"
                    . ",Enthusiasm,VisualAid values(intro,obj,demo1,demo2,conclusion"
                    . "questions,preparation,structure,enthusiasm,visual) where"
                    . "TeamName='$team'";*/
            $query="update Assessment set Introduction=$intro,Objectives=$obj,"
                    . "Demonstration1=$demo1,Demonstration2=$demo2,Conclusion=$conclusion"
                    . ",Question=$questions,Preparation=$preparation,Structure=$structure"
                    . ",Enthusiasm=$enthusiasm,VisualAid=$visual where TeamCode like 'ICT333TJD%'";
            $result=mysqli_query($dbc,$query);
            if($result)
            {
                echo"yeah";
            }
            else
                echo "no";
        }
    
?>
