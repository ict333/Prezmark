<?php
include("dbconnect.php");
?>
<!DOCTYPE html>
<html> 
    <head>
        
    </head>
    
    <body>
        
        <form action="" name="CreateSchedule2" id="CreateSchedule2" method="post">
            <h1>Create a new schedule</h1>
            
            <label for="teamname">Team Name</label>
            <select name="teamname" required>
                <?php
                    $get_name="select DISTINCT TeamName from Team ;";

                    $runsql=mysqli_query($dbc,$get_name);

                    while($rows=mysqli_fetch_array($runsql))
                    {
                            $name=$rows['TeamName'];
                            echo "<option value='$name'>$name</option>";
                    }
                ?>
            </select><br><br>
            
            <label for="logo">Logo</label>
            <input id="logo" name="logo" type="file" required></input>
            <br> </br>
            
            <label for="description">Description</label>
            <textarea form="CreateSchedule2" id="description" name="description" type="textarea" required></textarea>
            <br> </br>
            
            <label for="slot">Time Slot</label>
            <select name="slot" required>
                <option value="9:30-10:00">9:30-10:00</option>
                <option value="10:00-10:30">10:00-10:30</option>
                <option value="10:30-11:00">10:30-11:00</option>
                <option value="11:00-11:30">11:00-11:30</option>
                <option value="11:30-12:00">11:30-12:00</option>
                <option value="12:00-12:30">12:00-12:30</option>
                <option value="12:30-1:00">12:30-1:00</option>
                <option value="1:00-1:30">1:00-1:30</option>
                <option value="1:30-2:00">1:30-2:00</option>
                <option value="2:00-2:30">2:00-2:30</option>
                <option value="2:30-3:00">2:30-3:00</option>
                <option value="3:00-3:30">3:00-3:30</option>
                <option value="3:30-4:00">3:30-4:00</option>
                <option value="4:00-4:30">4:00-4:30</option>
                <option value="4:30-5:00">4:30-5:00</option>
                <option value="5:00-5:30">5:00-5:30</option>
                <option value="5:30-6:00">5:30-6:00</option>
            </select><br><br>
            <br> </br>
             <input type="submit" value="Done">
        </form>        
    </body>
</html>
