<?php
    //session_start();
?>

<html> 
    <head>
        
    </head>
    
    <body>
        
    <form name="CreateSuperUser" id="CreateSuperUser" method="post" onsubmit="return validateForm()">
        <fieldset>
        <legend>Create Super User</legend>
            
        <label for="email">Email*:
        <input id="email" name="email" type="email" required></input>
        </label>
        <br> </br>
            
        <label for="role">Role*:
        <select name="role" required>
            <option id="role" name="role" value="Admin">Administrator</option>
            <option id="role" name="role" value="UC">Unit Coordinator</option>
        </select>
        </label>
        <br> </br>
            
        <input type="submit" name="submit" value="Create"></input>
        </field>  
    </form>
        
    <script>
        function validateForm()
        {
            var email=document.CreateSuperUser.email.value;    
           /* some tests*/ 
        }
    </script>
        
<?php
    function generatePassword() 
    {
        $length=8;
        $r ="";
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($characters);

        for ($i = 0 ; $i < $length; $i++)
        {
            $index = rand(0, $count - 1);
            $r= mb_substr($characters, $index, 1);
            echo $r;
        }

        return $r;
    }
          
    if(isset($_POST['submit']))
    {
        include 'dbconnect.php';	
        $email=$_POST['email'];
        $role1="SuperUser";
	$role2=$_POST['role'];
        $password=  generatePassword();
        $active="1";
        echo $password;
                
        /*This query looks for the user entered email in the Person table to eliminate same values*/
        $query="SELECT * FROM Person WHERE Email='$email'";
	$result = mysqli_query($dbc,$query);
        $outcome=mysqli_num_rows($result);
                
	if($outcome==0)
	{
            /*This query inserts the email into the Person table*/
            $query ="INSERT INTO Person VALUES ('$email', '$role1');";
            $result = mysqli_query($dbc,$query);
            echo $query;
            /*This query inserts the email into the SuperUser table*/
            $query ="INSERT INTO SuperUser VALUES ('$email', '$role2','$password', '$active');";
            $result = mysqli_query($dbc,$query);
            echo $query;
            mysqli_close($dbc);
                   
            echo '<script>alert("Account created successfully!");</script>';
        }
        else
        {
            echo '<script>alert("This email is already exists!");</script>';
				
	}
    }
			
?>
        
    </body>
</html>