<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
$role= $_SESSION['Role'];
if($role!="Admin")
{
    header("Location: SuperUserLogin.php");
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
        <nav>
            <a href="">Disable Account</a>
            <a href="CreateSuperUser.php" class="active">Create Super User</a>
            <a href="">Create Backup</a>
            <a href="Logout.php">Logout</a>
        </nav>
    </div>
        
    <div id="separator"></div>
                
    <div class="form bottom">
        
    <form name="CreateSuperUser" id="CreateSuperUser" method="post" onsubmit="return validateForm()">
        <h1>Create Super User</h1>         
        <label for="email">Email<br>
        <input id="email" name="email" type="email" required></input>
        </label>
        <br> </br>
            
        <label for="role"> Role<br>
        <select name="role" required>
            <option id="role" name="role" value="Admin">Administrator</option>
            <option id="role" name="role" value="UC">Unit Coordinator</option>
        </select>
        </label>
        <br> </br>
            
        <input class="button" type="submit" name="submit" value="Create"></input>
        
    </form>
    </div>   
    <script>
        function validateForm()
        {
            var email=document.CreateSuperUser.email.value;    
           /* some tests*/ 
        }
    </script>
    </body>
     <footer>
           &#169;2017 All rights reserved by Murdoch University 
    </footer>  
</html>

<?php
function generatePassword() 
{
    $passwordRange = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); 
    $length = strlen($passwordRange) - 1;
    for ($i = 0; $i < 8; $i++) 
    {
        $n = rand(0, $length);
        $pass[] = $passwordRange[$n];
    }
    $password=implode($pass);
    echo $password;
    return $password;       
}
function hashPassword($pass)
{
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    return $hashedPassword;
}
          
if(isset($_POST['submit']))
{
    include 'dbconnect.php';	
    $email=$_POST['email'];
    $role1="SuperUser";
    $role2=$_POST['role'];
    $password=  generatePassword();
    $hashPass=  hashPassword($password);
    $active="1";
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) 
    {
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
            $query ="INSERT INTO SuperUser VALUES ('$email', '$role2','$hashPass', '$active');";
            $result = mysqli_query($dbc,$query);
            mysqli_close($dbc);

            echo '<script>alert("Account created successfully!");</script>';
            
            //send password email
            require_once "pear2/Mail.php";

            $from = '<project_ict333@murdochdubai.ac.ae>';
            $to = $email;
            $subject = 'Prezmark Account Password';
            $body = "Your account password is: $password\n"
                    . "You can log in by clicking on http://ceto.murdoch.edu.au/~team71/SuperUserLogin.php";
            $headers = array(
                'From' => $from,
                'To' => $to,
                'Subject' => $subject
            );

            $smtp = Mail::factory('smtp', array(
                    'host' => 'smtp.outlook.office365.com',
                    'port' => '587',
                    'auth' => true,
                    'username' => 'project_ict333@murdochdubai.ac.ae',
                    'password' => 'ict@333'
                ));

            $mail = $smtp->send($to, $headers, $body);

            if (PEAR::isError($mail)) 
            {
                echo('<p>' . $mail->getMessage() . '</p>');
            } 
            else 
            {
                echo('<p>Message successfully sent!</p>');
            }
          }
          
          else
          {
            echo 'This email is already exists!';

          }
        } 
        
        else
        {
          echo $email.' is not a valid email address';
        }        
    }		
?>