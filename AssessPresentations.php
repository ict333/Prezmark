<?php session_start();
  ini_set('display_errors',1);
    error_reporting (E_ALL);
   ?>
<html>
    <head>
        
    </head>
    
    <body>
        <?php
            $query="SELECT TeamName FROM Team WHERE UnitOffering='$unitoffering';";
            $result=mysqli_query($dbc,$query);
            $name=array();
            $i=0;
            while($rows=mysqli_fetch_array($result))
            {
                $name[$i]=$rows['TeamName'];
                $i++;
            }
            
        ?>
        
    <form name="Assess" id="Assess" method="post" onsubmit="">
      
        <legend>Assessment</legend>
        <label for="teamname">Team Name
            <select name="teamname" id="teamname" required>
            <?php
                for($i=0;$i<count($name);$i++)
                {
                    echo "<option value='$name[$i]'>$name[$i]</option>";
                }
            
            ?>
            <table>
            <tr> 
                <td>
               <label for="introduction">Effectiveness of the Introduction, the value proposition for the project
               and clearly explaining the original client problem</label>
                </td>
                <td>
               <input id="introduction" name="introduction" type="number" required></input>  
                </td>
            </tr>
            
            <tr> 
                <td>
               <label for="objective">Clearly identified the objectives of the project explaining the solution 
               in terms of the problem and the methodologies the team used to solve the problem</label>
                </td>
                <td>
               <input id="objective" name="objective" type="number" required></input>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="demo1">Product Demonstration: Demonstrated the requirements mentioned in point
               3 above</label>
                </td>
                <td>
               <input id="demo1" name="demo1" type="number" required></input>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="demo2">Product Demonstration: Appropriate amount of detail, flowed smoothly,
               and demostrating the product well.</label>
                </td>
                <td>
               <input id="demo2" name="demo2" type="number" required></input>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="conclusion">Effectiveness of the conclusion including the final status at the end of the 
               project, the self assessment and how it could have been improved.</label>
                </td>
                <td>
               <input id="conclusion" name="conclusion" type="number" required></input>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="questions">Responded to questions reasonalbly</label>
                </td>
                <td>
               <input id="questions" name="questions" type="number" required></input>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="preparation">The group's preparation and teamwork was evident</label>
                </td>
                <td>
               <input id="preparation" name="preparation" type="number" required></input>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="structure">The presentation was well-structured, organized into appropriate sections
               starting and finishing on time.</label>
                </td>
                <td>
               <input id="structure" name="structure" type="number" required></input>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="enthusiasm">The presentation was enthusiastic, interesting, clear and consise 
               and was easy to understand</label>
                </td>
                <td>
               <input id="enthusiasm" name="enthusiasm" type="number" required></input>  
                </td>
            </tr>
            
             <tr> 
                <td>
               <label for="visual">Visual aids were used effectively and changeover between speakers
               was smoothe and professional</label>
                </td>
                <td>
               <input id="visual" name="visual" type="number" required></input>  
                </td>
            </tr>

            
            </table>
        <input type="submit" name="Assess" value="Assess"></input>
       
    </form>
        
    <script>
       function validateForm()
       {
            var email=document.SuperUserLogin.email.value;
            var password=document.SuperUserLogin.password.value;
            
            /*some validation tests*/
        }
    </script> 
    
    <?php
        if(isset($_POST['Assess']))
        {
            
        }
    
    ?>
           
    </body>
</html>

