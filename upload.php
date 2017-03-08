 <?php
        $csv_mimetypes = array('text/csv', 'text/plain', 'application/csv', 'text/comma-separated-values', 'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel', 'text/anytext', 'application/octet-stream', 'application/txt');
        if (in_array($_FILES['csvfile']['type'], $csv_mimetypes)) 
        {
            /* Grab the location of this PHP script and change the path to a different location where we can save the data */
            $filePathRaw = dirname(__FILE__);
            $filePathSegments = explode("/", $filePathRaw);
            
            for ($x = 1; $x < (sizeof($filePathSegments) - 3); $x++) 
            {
                 $filePath = $filePath . "/" . $filePathSegments[$x];
            }
            $filePath = $filePath . "/thecsvfiles";
            
            /* Generate a filename for the CSV file */
            $token = date("YmdHis");
            
            /* Save the CSV data */
            $rawCSV = file_get_contents($_FILES['csvfile']['tmp_name']);
            $fileCSV = fopen($filePath . "/" . $token . ".txt", "w");
            fwrite($fileCSV, $rawCSV);
            fclose($fileCSV);
            chmod($filePath . "/" . $token . ".txt", 0644);
        }

        ?>