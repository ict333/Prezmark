<?php 
session_start();
$email=$_SESSION['Email'];
if((!isset($email)))
{
    echo '<script>alert("Session not Set")</script>';
    header("Location: SuperUserLogin.php");
}

    if(isset($_POST['submit']))
    {
        include 'dbconnect.php';
        $backupFile = 'Prezmark_' . date("d-m-Y") . '.sql';
        header('Content-Type: text/sql');
        header('Content-Disposition: attachment; filename="'.$backupFile.'"');
        
        $command = "mysqldump --user=team71 --password=IUfkjs*454ds --host=localhost "
                . "team71 ";
        passthru($command);
        exit(0);
        
    }    
                        
 ?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="icon.png" type="image/x-icon"></link>
        <!--
        Authors: Christopher Thomas
                 Esha Shetty
                 Sasha Jazzabelle
        Date: 12th April 2017
        -->
    </head>
    
    <div class="header">
         <a href="index.php"> <img src="logo.png"></a>
        <nav>
            <a href="DisableAccounts.php">Disable Account</a>
            <a href="CreateSuperUser.php" >Create Super User</a>
            <a href="Backup.php" class="active">Create Backup</a>
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


