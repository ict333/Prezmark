<?php session_start();
    if(isset($_POST['submit']))
    {
        include 'db_connect.php';	
        $email=$_POST['email'];
        $password=$_POST['password'];
                
        /*This query checks if the email exists in the database from the Person table*/
	$query="SELECT * FROM Person WHERE Email='$email'";
	$result = mysqli_query($dbc,$query); 
	$outcome=mysqli_num_rows($result);
                
	if($outcome!=0)
        {
            $query="SELECT * FROM SuperUser WHERE Email='$email' AND Password='$password'";
            $result = mysqli_query($dbc,$query); 
            $outcome=mysqli_num_rows($result);
                    
            if($outcome!=0)
            {
                while ($row=mysqli_fetch_assoc($result))
                {
                    $role=$row['Role'];
                    $active=$row['Active'];

                    if($active==1)
                    {
                        echo 'Logged in successfully';
                        if($role=="Admin")
                        {
                            $_SESSION['Role']="Admin";  
                        }
                        else
                        {
                            $_SESSION['Role']="UC";
                        }
                    }
                    else
                    {
                        echo 'Account not active';
                    }
                        
                }
            }
                    
        }
        else
        {
            echo 'This user does not exist';
        }
    }
                        
 ?>
<html>
    <head>
        
    </head>
    
    <body>
        
    <form name="SuperUserLogin" id="SuperUserLogin" method="post" onsubmit="return validateForm()">
        <fieldset>
        <legend>Super User Login</legend>
            
        <label for="email">Email*:</label>
        <input id="email" name="email" type="email" required></input>  
        <br> </br>
            
        <label for="password">Password*:</label>
        <input id="password" name="password" type="password" required></input>
        <br> </br>
            
        <input type="submit" name="submit" value="Login"></input>
        </fieldset>
    </form>
        
    <script>
       function validateForm()
       {
            var email=document.SuperUserLogin.email.value;
            var password=document.SuperUserLogin.password.value;
            
            /*some validation tests*/
        }
    </script>  
           
    </body>
</html>

