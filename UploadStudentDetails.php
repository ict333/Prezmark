<?php
    /*session_start();
     * if($_SESSION['Role']!="UC")
     *      Location: (redirect somewhere)
     */
ini_set('display_errors',1);
    error_reporting (E_ALL);
    
?>
<html> 
    <head>
        
    </head>
    
    <body>
        
        <form method="post" action="UploadStudentDetails.php" enctype="multipart/form-data">
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

        <input name="upload" type="submit" value="Upload"/>
        </fieldset>
    </form> 
<?php
if(isset($_POST['upload']))
{
    include 'dbconnect';
    $unit=$_POST['unit'];
    $semester=$_POST['semester'];
    $year=$_POST['year'];
    $offering=array($unit,$semester,$year);
    $unitoffering=implode($offering);
    $teamcode=array();
    echo $unitoffering;
    
    if(isset($_FILES["csvfile"]["error"]))
    {
        if($_FILES["csvfile"]["error"] > 0)
        {
            echo "Error: " . $_FILES["csvfile"]["error"] . "<br>";
        }
        else
        {
            $allowed =array("csv"=>"text/csv");
                    //array('text/csv', 'text/plain', 'application/csv', 'text/comma-separated-values', 'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel', 'text/anytext', 'application/octet-stream', 'application/txt');
            $filename = $_FILES["csvfile"]["name"];
            $filetype = $_FILES["csvfile"]["type"];
            $filesize = $_FILES["csvfile"]["size"];      

            // Verify file extension
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if(!array_key_exists($ext, $allowed)) 
            {
                die("Error: Please select a valid file format.");
            }

       
            // Verify file size - 2MB maximum
            $maxsize = 2 * 1024 * 1024;

            if($filesize > $maxsize)
            {
                die("Error: File size is larger than the allowed limit.");
            }

            // Verify MIME type of the file
            if(in_array($filetype, $allowed))
            {
                // Check whether file exists before uploading it
                if(file_exists("File/" . $_FILES["csvfile"]["name"]))
                {
                    echo $_FILES["csvfile"]["name"] . " already exists.";
                } 
                else
                {
                    if(move_uploaded_file($_FILES["csvfile"]["tmp_name"], "File/". $_FILES["csvfile"]["name"]))
                    {
                        echo 'Your file was uploaded successfully.';
                    }
                    
                    //Read from file
                    $file = fopen("File/".$_FILES["csvfile"]["name"],"r");
                    //skips first line
                    fgetcsv($file);
                    $count=0;
                    
                    while (($line = fgetcsv($file)) !== FALSE) 
                    {
                        $temp=array($unitoffering,$line[6]);
                        $teamcode[$count]=  implode($temp);
                        echo $line[5].'----'.$line[6];
                        $query="INSERT INTO Team VALUES('$teamcode[$count]','$line[6]','$line[5]','$unitoffering')";
                        echo $query;
                        $result = mysqli_query($dbc,$query); 
                        $count++;
                    }
                    
                    while(! feof($file))
                    {
                       // print_r(fgetcsv($file));
                        //$teamcode[$count]=$unitoffering+$line[6];  
                        //$count++;
                    }

                    fclose($file);
                    //echo "File/" . $_FILES["csvfile"]["name"];
                    //for($i=0;$i<2;$i++)
                    //    echo $teamcode[$i];
                } 

            }
            else
            {
                echo "Error: There was a problem uploading your file - please try again."; 
            }
        }

    }
    else
    {
        echo "Error: Invalid parameters - please contact your server administrator.";
    }
}

?>


    
    </body>
</html>