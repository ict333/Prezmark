<?php session_start();
  ini_set('display_errors',1);
    error_reporting (E_ALL);
    if(isset($_POST['submit']))
    {
        include 'dbconnect.php';	
        $email=$_POST['email'];
        $pass=$_POST['password'];
        
                
        /*This query checks if the email exists in the database from the Person table*/
	$query="SELECT * FROM Person WHERE Email='$email'";
	$result = mysqli_query($dbc,$query); 
	$outcome=mysqli_num_rows($result);
        
	if($outcome!=0)
        {
            $query="SELECT * FROM SuperUser WHERE Email='$email'";
            $result = mysqli_query($dbc,$query); 
            $outcome=mysqli_num_rows($result);
            
            if($outcome!=0)
            {
                while ($row=mysqli_fetch_assoc($result))
                {
                    $role=$row['Role'];
                    $active=$row['Active'];
                    $password=$row['Password'];
                    if(password_verify($pass, $password))
                    {
                        if($active==1)
                        {
                         echo '<script>alert("Logged in successfully")</script>';
                         if($role=="Admin")
                         {
                             $_SESSION['Role']="Admin";  
                             header("Location: CreateSuperUser.php");
                         }
                         else
                         {
                             $_SESSION['Role']="UC";
                             $_SESSION['Email']=$email;
                             header("Location: UploadStudentDetails.php");
                         }
                        }
                        else
                        {
                         echo '<script>alert("Account not active")</scipt>';
                         } 
                    }
                    else
                    {
                        echo '<script>alert("Wrong Password")</script>';
                    }
                    
                        
                }
            }
                    
        }
        else
        {
            echo '<script>alert("This user does not exist")</script>';
        }
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
    </div>
    <div id="separator"></div>


    <div class="form bottom" >
        
    <form  name="SuperUserLogin" id="SuperUserLogin" method="post" onsubmit="return validateForm()">
        <h1>Unit Coordinator/ Administrator Login</h1>
        <label for="email">Email<br>
        <input id="email" name="email" type="email" required></input> 
        </label>
        <br> </br>
            
        <label for="password">Password<br>
        <input id="password" name="password" type="password" required></input>
        </label>
        <br> </br>
        <input class="button" type="submit" name="submit" value="Login"></input>
     
    </form>
    </div>
    <script>
       function validateForm()
       {
            var email=document.SuperUserLogin.email.value;
            var password=document.SuperUserLogin.password.value;
            
            /*some validation tests*/
        }
    </script>     
    </body>
    <footer>
           &#169;2017 All rights reserved by Murdoch University 
    </footer>  
</html>

