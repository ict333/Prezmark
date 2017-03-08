<?php
    //session_start();
?>

<html> 
    <head>
        
    </head>
    
    <body>
        
        <form name="UploadStudent" id="UploadStudent" method="post">
            <h1>Upload Student Details</h1>
            
            <label for="unit">Unit</label>
            <input id="unit" name="unit" type="text"></input>
            <br> </br>
            
            <label for="semester">Semester</label>
            <input id="semester" name="semester" type="text"></input>
            <br> </br>
            
            <label for="semester">Year</label>
            <input id="year" name="year" type="text"></input>
            <br> </br>
           
        </form>
        
       <form method="post" action="upload.php" enctype="multipart/form-data">
           <label>Choose file to upload</label>
           <input type="file" name="csvfile" id="csvfile"> 
           <br> </br>

           <input type="submit" value="Upload"/>
        </form> 
       
               
    </body>
</html>