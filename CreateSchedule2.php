<!DOCTYPE html>
<html> 
    <head>
        
    </head>
    
    <body>
        
        <form action="" name="CreateSchedule2" id="CreateSchedule2" method="post">
            <h1>Create a new schedule</h1>
            
            <label for="teamname">Team Name</label>
            <select name="teamname" required>
                <option value="Arab Tech">Arab Tech</option>
                <option value="Lama Inc.">Lama Inc.</option>
                <option value="Desert Junkies">Desert Junkies</option>
            </select><br><br>
            <br> </br>
            
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
            </select><br><br>
            <br> </br>
             <input type="submit" value="Done">
        </form>        
    </body>
</html>
