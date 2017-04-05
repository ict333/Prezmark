<?php //session_start();
  ini_set('display_errors',1);
    error_reporting (E_ALL);
    if(isset($_POST['submit']))
    {
        include 'dbconnect.php';
        $backupFile = 'Prezmark_' . date("d-m-Y") . '.sql';
        header('Content-Type: text/sql');
        header('Content-Disposition: attachment; filename="'.$backupFile.'"');
        $path=$_POST['Path'];
        
        $command = "mysqldump --user=root --password=123 --host=localhost "
                . "Prezmark ";
        passthru($command);
        exit(0);
        
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
            <a href="DisableAccounts.php">Disable Account</a>
            <a href="CreateSuperUser.php" class="active">Create Super User</a>
            <a href="Backup.php">Create Backup</a>
            <a href="Logout.php">Logout</a>
        </nav>
    </div>
    <div id="separator"></div>


    <div class="form bottom" >
        
    <form  name="Backup" id="Backup" method="post" onsubmit="Backup.php">
        <h1>Create Backup</h1>
        <br> </br>
            
        <input class="button" type="submit" name="submit" value="Create"></input>
     
    </form>
    </div>    
    </body>
    <footer>
           &#169;2017 All rights reserved by Murdoch University 
    </footer>  
</html>


