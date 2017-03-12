    <?php
    ini_set('display_errors',1);
    error_reporting (E_ALL);
    
    if($_FILES["csvfile"]["error"] > 0)
    {
        echo "Error: " . $_FILES["csvfile"]["error"] . "<br>";

    } 
    else
    {
        echo "File Name: " . $_FILES["csvfile"]["name"] . "<br>";
        echo "File Type: " . $_FILES["csvfile"]["type"] . "<br>";
        echo "File Size: " . ($_FILES["csvfile"]["size"] / 1024) . " KB<br>";
        echo "Stored in: " . $_FILES["csvfile"]["tmp_name"];
    }

    ?>

    