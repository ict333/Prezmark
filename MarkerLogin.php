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
        <input type="text" name="firstname" required><br>
        Last name:*<br>
        <input type="text" name="lastname" required><br><br>
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
        ini_set('display_errors',1);
        error_reporting(E_ALL);
        if(isset($_POST['m_register']))
	{
		$mail=$_POST['mail'];
                $fn=$_POST['firstname'];
                $ln=$_POST['lastname'];
                $role=$_POST['role'];
                //echo "<script>alert('$role')</script>";
                echo'$check_per="insert into Person values('.$mail.','.$role.')";';
		//$check_reg="insert into Marker(FirsName,LastName,Email,Role) values('$fn','$ln','$mail','$role') ";
		$run_per=mysqli_query($con,$check_per);
                //$run_reg=mysqli_query($con,$check_reg);
                
		
		if($run_per)
		{
			
			while($row_usr=mysqli_fetch_array($run_per))
			{
				echo "<script>alert('Registered! You may login now!')</script>";
			}
			if(!mysqli_fetch_array($run_per))
			{
				echo "<script>alert('Error')</script>";
			}
			
		}
		else 
		{
			echo "<script>alert('Query Error!')</script>";
			
		}
	}
        
	if(isset($_POST['m_login']))
	{
		$email=$_POST['email'];
		$check_login="select * from Marker where Email='$email'";
		$run_login=mysqli_query($con,$check_login);
		
		if($run_login)
		{
			
			while($row_usr=mysqli_fetch_array($run_login))
			{
				
				echo "<script>alert('Welcome back!)</script>";
				echo "<script>window.open('dbconnect.php','_self')</script>";
			}
			if(!mysqli_fetch_array($run_login))
			{
				echo "<script>alert('Please Register First')</script>";
			}
			
		}
		else 
		{
			echo "<script>alert('Query Error!')</script>";
			
		}
	}
        
        
?>