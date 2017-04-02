<?php //session_start();
  ini_set('display_errors',1);
    error_reporting (E_ALL);
    
    function this()
    {
        if(isset($_POST['submit']))
        {
            $host = "localhost";
            $user = "root";
            $password = "123";
            $dbname = "Prezmark";
            $type=$_POST['Type'];
            $dbc = mysqli_connect($host,$user,$password,$dbname);
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

            echo"<select id='email'>";
            while($row = mysqli_fetch_assoc($result))
            {
                $email = $row['Email'];
                echo"<option value='$email'>$email</option>";
            }
            echo"</select><br><br><a href='DisableAccounts.php?email=$email&Type=$type'><button>Disable</button></a>";
        }
         
    }   
 echo $m=$_GET['Type'];
 function that(){
 if(isset($_GET['email']))
 {echo"<script>alert('yes')</script>";
    include("dbconnect.php");
    $type=$_GET['Type'];
    $mail=$_GET['email'];
    if($type === "Marker")
    {
        $query="update Marker set Active=0 where Email='$mail'";
    }
    else if($type === "Unit Coordinator")
    {
        $query="update SuperUser set Active=0 where Email='$mail'";
    }
    else
    {
        $query="update SuperUser set Active=0 where Email='$mail'";
    }
    $result= mysqli_query($dbc,$query);
 }
 } 
    
echo'<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="icon.png" type="image/x-icon"></link>
    </head>
    
    <body>
     <div class="header">
         <a href="index.php"> <img src="logo.png"></a>
    </div>
    <div id="separator"></div>


    <div class="form bottom" >
        
    <form  name="Disable"  id="Disable" method="post" onsubmit="DisableAccounts.php">
        <h1>Disable Accounts</h1>
        <label for="Type">Account Type<br>
            <select id="Type" name="Type" >
                <option value="Marker">Marker</option>
                <option value="Unit Coordinator">Unit Coordinator</option>
                <option value="Admin">Admin</option>
            </select>
        </label>
        <br> </br>';
        this();
        that();
        echo'           
        <input class="button" type="submit" name="submit" value="Show Accounts"></input>
     
    </form>
    </div>    
    </body>
    <footer>
           &#169;2017 All rights reserved by Murdoch University 
    </footer>  
</html>';

