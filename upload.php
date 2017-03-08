    <?php
    if($_FILES["csvfile"]["error"] > 0){

        echo "Error: " . $_FILES["csvfile"]["error"] . "<br>";

    } else{

        echo "File Name: " . $_FILES["csvfile"]["name"] . "<br>";

        echo "File Type: " . $_FILES["csvfile"]["type"] . "<br>";

        echo "File Size: " . ($_FILES["csvfile"]["size"] / 1024) . " KB<br>";

        echo "Stored in: " . $_FILES["csvfile"]["tmp_name"];

    }

    ?>

    <?php

    if(isset($_FILES["csvfile"]["error"])){

        if($_FILES["csvfile"]["error"] > 0){

            echo "Error: " . $_FILES["csvfile"]["error"] . "<br>";

        } else{

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

            if(in_array($filetype, $allowed)){

                // Check whether file exists before uploading it

                if(file_exists("File/" . $_FILES["csvfile"]["name"])){

                    echo $_FILES["csvfile"]["name"] . " already exists.";

                } else{

                    move_uploaded_file($_FILES["csvfile"]["tmp_name"], "File/" . $_FILES["csvfile"]["name"]);
                    
                    echo "Your file was uploaded successfully.";
                    echo "File/" . $_FILES["csvfile"]["name"];

                } 

            } else{

                echo "Error: There was a problem uploading your file - please try again."; 

            }

        }

    } else{

        echo "Error: Invalid parameters - please contact your server administrator.";

    }

    ?>

