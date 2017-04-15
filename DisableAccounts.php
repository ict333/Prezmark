<?php 
session_start();
$email=$_SESSION['Email'];
if((!isset($email)))
{
    echo '<script>alert("Session not Set")</script>';
    header("Location: SuperUserLogin.php");
}
 
    include("dbconnect.php");
    
    function display()
    {
        if(isset($_GET['submit']))
        {
            
            $host = "localhost";
            $user = "team71";
            $password = "IUfkjs*454ds";
            $dbname = "team71"; 
            $dbc = mysqli_connect($host,$user,$password,$dbname);
            $type=$_GET['Type'];
            $_SESSION['Type']=$type;
            if($type === "Marker")
            {
                $query="select * from Marker where Active=1";
            }
            else if($type === "Unit Coordinator")
            {
                $query="select * from SuperUser where Role='UC' and Active=1";
            }
            else
            {
                $query="select * from SuperUser where Role='Admin' and Active=1";
            }
            $result= mysqli_query($dbc,$query);

            
            while($row = mysqli_fetch_assoc($result))
            {
                $email = $row['Email'];
                echo"<option value='$email'>$email</option>";
            }
        }
         
    }
    
    function disable()
    {
        if(isset($_GET['disable']))
        {   
            $host = "localhost";
            $user = "team71";
            $password = "IUfkjs*454ds";
            $dbname = "team71"; 
            $dbc = mysqli_connect($host,$user,$password,$dbname);
            $type=$_SESSION['Type'];
            $mail=$_GET['Account'];
            if($type === "Marker" && $mail)
            {
                $query="update Marker set Active=0 where Email='$mail'";
            }
            else if($type === "Unit Coordinator" && $mail)
            {
                $query="update SuperUser set Active=0 where Email='$mail'";
            }
            else if($type === "Admin" && $mail)
            {
                $query="update SuperUser set Active=0 where Email='$mail'";
            }
            else
            {
                echo"<script>alert('No Account Selected!')</script>";
            }
        $result= mysqli_query($dbc,$query);
        if($result)
        {
            echo"<script>alert('Account Disabled!')</script>";
        }
        }
    
    }
  
echo'<html>
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
    
    <body>
     <div class="header"> <a href="index.php"> 
     <img src="logo.png"></a>
        <nav>
            <a href="DisableAccounts.php" class="active">Disable Account</a>
            <a href="CreateSuperUser.php" >Create Super User</a>
            <a href="Backup.php">Create Backup</a>
            <a href="Logout.php">Logout</a>
        </nav>
    </div>
    <div id="separator"></div>


    <div class="form bottom" >
        
    <form  name="Disable"  id="Disable" method="get">
        <h1>Disable Accounts</h1>
        <label for="Type">Account Type<br>
            <select id="Type" name="Type" >
                <option value="Marker">Marker</option>
                <option value="Unit Coordinator">Unit Coordinator</option>
                <option value="Admin">Admin</option>
            </select>
        </label>
        <br> </br>
        <input class="button" type="submit" name="submit" value="Show Accounts"></input>
        <br> </br>
        <label for="Account">Account<br>
            <select id="Account" name="Account" >';
            display();
            disable();
            echo'</select>
        </label>
        <br> </br>
        <input class="button" type="submit" name="disable" value="Disable"></input><br>
        
     
    </form>
    </div>    
    </body>
    <footer>
           &#169;2017 All rights reserved by Murdoch University 
    </footer>  
</html>';

