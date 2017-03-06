<?php
    //session_start();
?>

<html> 
    <head>
        
    </head>
    
    <body>
        
        <form name="CreateSuperUser" id="CreateSuperUser" method="post" onsubmit="return validateForm()">
            <legend>Create Super User</legend>
            
            <label for="email">Email</label>
            <input id="email" name="email" type="email"></input>
            
            <br> </br>
            
            <label for="role">Role</label>
            <select name="role">
                <option id="role" name="role" value="Admin">Administrator</option>
                <option id="role" name="role" value="UC">Unit Coordinator</option>
            </select>
            
            <br> </br>
            
            <input type="submit" name="submit" value="Create"></input>
        </form>
        
        <script>
            function validateForm()
            {
                var email=document.CreateSuperUser.email.value;
                
                if(email==""||email==null)
		{
                    alert("Please Enter your Email");
                    return false;
		}
                
            }
        </script>
        
        <?php
            if(isset($_POST['submit']))
            {
                include 'db_connect.php';	
		$email=$_POST['email'];
                $role1="SuperUser";
		$role2=$_POST['role'];
                $password="123";
                $active="1";
                
                /*This query looks for the user entered email in the Person table to eliminate same values*/
		$query="SELECT * FROM Person WHERE Email='$email'";
		$result = mysqli_query($dbc,$query);
                
		$outcome=mysqli_num_rows($result);
                
		if($outcome==0)
		{
                    /*This query inserts the email into the Person table*/
                    $query ="INSERT INTO Person VALUES ('$email', '$role1');";
                    $result = mysqli_query($dbc,$query);
                    
                    /*This query inserts the email into the SuperUser table*/
                    $query ="INSERT INTO SuperUser VALUES ('$email', '$role2','$password', '$active');";
                    $result = mysqli_query($dbc,$query);
                    
                    mysqli_close($dbc);
                    
                    echo '<script>alert("Account created successfully!");</script>';
		}
                else
                {
                    echo '<script>alert("This email is already exists!");</script>';
				
		}
            }
			
	
            
           /* $subject = "PresMark Password";
            $txt = "Hello Your Password is "+$password;
            $headers = "From: Prezmark student marking system" . "\r\n" ;

            mail($email,$subject,$txt);*/
        ?> 
        
    </body>
</html>