<?php
    //session_start(); 
     ini_set('display_errors',1);
    error_reporting (E_ALL);
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
       
        // You can now safely store the contents of $hashedPassword in your database!

        // Check if a user has provided the correct password by comparing what they typed with our hash
        //

       // password_verify('my super cool password', $hashedPassword); 
        return $password;
        
        
    }
  function hashPassword($pass)
  {
      $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
      echo $hashedPassword;
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
          echo $email.' is a valid email address';
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

            echo 'Account created successfully!';
            
            
            //send password email
            require_once "pear2/Mail.php";

            $from = '<project_ict333@murdochdubai.ac.ae>';
            $to = $email;
            $subject = 'Account Password';
            $body = "Your account password is: $password";
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
        
    </body>
</html>