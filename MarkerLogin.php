<?php
include ("Functions.php");
include ("dbconnect.php");
?>
<html>
<head>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
    <form action="MarkerLogin.php" method="post">
        <fieldset>
        <legend>Welcome to Prezmark</legend>
        First name:*<br>
        <input type="text" name="firstname" id="firstname" required><br>
        Last name:*<br>
        <input type="text" name="lastname" id="lastname" required><br><br>
        Email:*<br>
        <input type="email" name="mail" required><br><br>
        Role:*<br>
        <select name="role" required>
        <option value="Student">Student</option>
        <option value="Visitor">Visitor</option>
        <option value="Client">Client</option>
        </select><br><br>
        Affiliation:<br>
        <input type="text" name="affiliation" ><br><br>
        Student:<br>
        <input type="integer" name="id" ><br><br>
        <div class="g-recaptcha" data-sitekey="6LdqCBgUAAAAALo2kI5Qx2lPIQAzMAVjFc1iNnNV"></div><br>
        <input type="submit" name="m_register" value="Register">
        </fieldset>
    </form>

    <form action="MarkerLogin.php" method="post">
        <fieldset>
        <legend>Login</legend>
        Email:<br>
        <input type="email" name="email" ><br><br>
        <input type="submit" name="m_login" value="Login">
        </fieldset>
    </form>
</html>
  
        
<?php
    if(isset($_POST['m_register']))
    {
        include 'dbconnect.php';	
        $mail=$_POST['mail'];
        $role1="Marker";
	$role2=$_POST['role'];
        $fn=$_POST['firstname'];
        $ln=$_POST['lastname'];
        $active="1";
                
        /*This query looks for the user entered email in the Person table to eliminate same values*/
        $query="SELECT * FROM Person WHERE Email='$mail'";
	$result = mysqli_query($dbc,$query);
        $outcome=mysqli_num_rows($result);
                
        if($outcome==0)
	{
            /*This query inserts the email into the Person table*/
                    $query ="INSERT INTO Person VALUES ('$mail', '$role1');";
                    $result = mysqli_query($dbc,$query);
                    echo $query;
                    /*This query inserts the email into the Marker table*/
                    $query ="INSERT INTO Marker VALUES ('$fn','$ln','$mail','$role2','la','32498909','$active');";
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
			
	
       
        
	if(isset($_POST['m_login']))
	{
		$email=$_POST['email'];
                
		/*This query checks if the email exists in the database from the Person table*/
                $query="SELECT * FROM Person WHERE Email='$email'";
                $result = mysqli_query($dbc,$query); 
                $outcome=mysqli_num_rows($result);
                
		if($outcome!=0)
		{
                    $query="SELECT * FROM Marker WHERE Email='$email'";
                    $result = mysqli_query($dbc,$query); 
                    echo $query;
                    $outcome=mysqli_num_rows($result);
                    if($outcome!=0)
                    {
                        session_start();
                        $_SESSION['Role']="Marker";
                        echo '<script>alert("Login successful");</script>';
                    }
                    else
                         echo '<script>alert("Please Register First!");</script>';
					
		}
                 else
                         echo '<script>alert("Please Register First!");</script>';
                
	}
        
        
?>