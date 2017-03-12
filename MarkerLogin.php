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
        <input type="text" name="id" ><br><br>
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
                $aff=$_POST['affiliation'];
                $id=$_POST['id'];
                $check_per="SELECT * FROM Person WHERE Email='$mail'";
		$run_per=mysqli_query($con,$check_per);
                $outcome=mysqli_num_rows($run_per);
		
		if($outcome==0)
		{
                    //This query inserts marker details to marker table
                    $query ="INSERT INTO Person VALUES ('$mail', '$role');";
                    $result = mysqli_query($con,$query);
                    
                    //This query inserts marker details to marker table
                    $query ="INSERT INTO Marker VALUES('$fn','$ln','$mail','$role','$aff','$id',1);";
                    $result = mysqli_query($con,$query);
                    //if($result) 
                    //{
                    //    echo "Yes";
                    //} 
                    //else 
                    //{
                    //    echo "No";
                    //}
                    //echo $query;
                    mysqli_close($con);
                    
                    echo '<script>alert("Account created successfully!");</script>';
		}
		else 
		{
			echo "<script>alert('Account Exists!Log in *facepalm*')</script>";
			
		}
	}
?>

<?php
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