<?php
    /*session_start();
     * if($_SESSION['Role']!="UC")
     *      Location: (redirect somewhere)
     */
    
?>
<html> 
    <head>
        
    </head>
    
    <body>
        
    <form method="post" action="upload.php" enctype="multipart/form-data">
        <fieldset>
        <legend>Upload Student Details</legend>
            
        <label for="unit">Unit*:</label>
        <input id="unit" name="unit" type="text" required></input>
        <br> </br>
            
        <label for="semester">Semester*:</label>
        <input id="semester" name="semester" type="text" required></input>
        <br> </br>
            
        <label for="year">Year*:</label>
        <input id="year" name="year" type="text" required></input>
        <br> </br>
        
   
        <label>Choose file to upload*:</label>
        <input type="file" name="csvfile" id="csvfile" required> 
        <br> </br>

        <input type="submit" value="Upload"/>
        </fieldset>
    </form> 
       
               
    </body>
</html>