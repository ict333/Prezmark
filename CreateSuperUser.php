<?php
    //session_start();
?>

<html> 
    <head>
        
    </head>
    
    <body>
        
        <form name="CreateSuperUser" id="CreateSuperUser" method="post" onsubmit="return validateForm()">
            <h1>Create Super User</h1>
            
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
			
	
            

    
/*
    $to = 'esha.dshetty@email.com';

    $subject = 'Marriage Proposal';

    $message = 'Hi Jane, will you marry me?'; 

    $from = 'esha.dshetty@email.com';

     

    // Sending email

    if(mail($to, $subject, $message)){

        echo 'Your mail has been sent successfully.';

    } else{

        echo 'Unable to send email. Please try again.';

    }*/

  
        $subject = "PresMark Password";
        $msg = "Hello Your Password is "+$password;
        $to="esha.dshetty@gmail.com";
        $from="project_ict333@murdochdubai.ac.ae";
        $from_name="Esha";
        $account="project_ict333@murdochdubai.ac.ae";
        $password="ict@333";
        
        include("phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = "smtp.live.com";
        $mail->SMTPAuth= true;
        $mail->Port = 587;
        $mail->Username= $account;
        $mail->Password= $password;
        $mail->SMTPSecure = 'tls';
        $mail->From = $from;
        $mail->FromName= $from_name;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->addAddress($to);
           /*
            $header = "From: Prezmark student marking system" . "\r\n" ;

            mail($email,$subject,$txt);*/
        ?> 
        
    </body>
</html>