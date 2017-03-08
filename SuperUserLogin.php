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
                            $_SESSION['Role']="Admin";  
                        else
                            $_SESSION['Role']="UC";
                        
                        //displays the role of the user(remove)
                         echo $_SESSION['Role'];

                    }
                    else
                        echo 'Account not active';
                        
                }
            }
                    
        }
        else
            echo 'This user does not exist';
    }
                        
 ?>
<html>
    <head>
        
    </head>
    
    <body>
        
        <form name="SuperUserLogin" id="SuperUserLogin" method="post" onsubmit="return validateForm()">
            <h1>Super User Login</h1>
            
            <label for="email">Email</label>
            <input id="email" name="email" type="email"></input>
            
            <br> </br>
            
            <label for="role">Password</label>
            <input id="password" name="password" type="password"></input>
            <br> </br>
            
            <input type="submit" name="submit" value="Login"></input>
        </form>
        
        <script>
            function validateForm()
            {
                var email=document.SuperUserLogin.email.value;
                var password=document.SuperUserLogin.password.value;
                
                if((email==""||email==null)&&(password==""||password==null))
		{
                    alert("Please enter your details");
                    return false;
		}
                
                 if(email==""||email==null)
		{
                    alert("Please enter your email");
                    return false;
		}
                
                 if(password==""||password==null)
		{
                    alert("Please enter your password");
                    return false;
		}
                
            }
        </script>
        
       
           
    </body>
</html>

