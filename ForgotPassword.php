<?php
include 'dbconnect.php';
session_start();
$email=$_SESSION['Email'];
if((!isset($email)))
{
    echo '<script>alert("Session not Set")</script>';
    header("Location: SuperUserLogin.php");
}
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
    
    ?>