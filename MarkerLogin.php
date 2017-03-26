<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="icon.png" type="image/x-icon"></link>
    </head>
    <body>
      <div class="header">
         <img src="logo.png">
    </div>
    <div id="separator"></div>
    <h1>Marker Login</h1>
    <div class="form">
    <form name="Register" onsubmit="return check()" method="post">

        <label for="firstname">First Name <br>
            <input type="text" name="firstname" id="firstname" required>
        </label>
        <br></br>

        <label for="lastname">Last Name<br>
            <input type="text" name="lastname" id="lastname" required>
        </label>
        <br></br>

        <label for="email">Email <br>
            <input type="email" name="mail" id="mail" required>
        </label>
        <br></br>

        <label for="role">Role <br>
            <select onblur="checkStudent()" name="role" id="role" required>
                <option value="Student">Student</option>
                <option value="Visitor">Visitor</option>
                <option value="Client">Client</option>
            </select>
        </label>
        <br></br>

        <label for="affiliation">Affiliation<br>
            <input  type="text" name="affiliation" id="affiliation">
        </label>
        <br></br>

        <label for="student">Student Number<br>
            <input type="integer" name="student" id="student">
        </label>
        <br></br>

        <div class="g-recaptcha" data-sitekey="6LdqCBgUAAAAALo2kI5Qx2lPIQAzMAVjFc1iNnNV"></div><br>
        <input class="button" type="submit" name="m_register" value="Register">

    </form>
    </div>
    <form name="MarkerLogin" onsubmit="" method="post">

        <legend>Login</legend>

        <label for="email">Email<br>
            <input type="email" name="email" >
        </label>
        <br></br>
        <input class="button" type="submit" name="m_login" value="Login">
    </form>

         <script>
        function check()
        {
            if (grecaptcha.getResponse().length==0){
                alert("You can't proceed!");
                return false;
            }
            else
            {
                alert("Thank you");
            }
        }
        function checkStudent()
        {
            
            if (document.getElementById("role").value==="Student")
            {
                    document.getElementById("student").disabled=false;
                    document.getElementById("affiliation").disabled=true;
            }
            else if (document.getElementById("role").value==="Client")
            {
                    document.getElementById("student").disabled=true;
                    document.getElementById("affiliation").disabled=false;
            }
            else if (document.getElementById("role").value==="Visitor")
            {
                    document.getElementById("student").disabled=true;
                    document.getElementById("affiliation").disabled=false;
            }
            
        }
        </script>
        
        <footer>
           &#169;2017 All rights reserved by Murdoch University 
        </footer>
    </body>
</html>


<?php
/* PHP script for the marker registration form */
if (isset($_POST['m_register']))
{
    include 'dbconnect.php';
    $mail = $_POST['mail'];
    $role1 = "Marker";
    $role2 = $_POST['role'];
    $fn = $_POST['firstname'];
    $ln = $_POST['lastname'];
    $aff = $_POST['affiliation'];
    $stud = $_POST['student'];
    $success = $_POST['g-recaptcha-response'];
    $active = "1";

    /* This query looks for the user entered email in the Person table to eliminate same values */
    $query = "SELECT * FROM Person WHERE Email='$mail'";
    $result = mysqli_query($dbc, $query);
    $outcome = mysqli_num_rows($result);
  if (!filter_var($mail, FILTER_VALIDATE_EMAIL) === false) 
   {
    if ($success) 
    {
        if ($outcome == 0) {
            /* This query inserts the email into the Person table */
            $query = "INSERT INTO Person VALUES ('$mail', '$role1');";
            $result = mysqli_query($dbc, $query);

            /* This query inserts the email into the Marker table */
            $query = "INSERT INTO Marker VALUES ('$fn','$ln','$mail','$role2','$aff','$stud','$active');";
            $result = mysqli_query($dbc, $query);
            mysqli_close($dbc);

            echo '<script>alert("Account created successfully!");</script>';
        } else {
            echo '<script>alert("This email already exists!");</script>';
        }
    }
    else if(!$success)
    {
        echo '<script>alert("Please verify that you are a human!")</script>';
        return false;
    }
  }
  else
  {
      echo 'Incorrect email format';
  }
}
?>

<?php
/* PHP script for the marker login form */
if (isset($_POST['m_login'])) {
    include 'dbconnect.php';
    $email = $_POST['email'];

    /* This query checks if the email exists in the database from the Person table */
    $query = "SELECT * FROM Person WHERE Email='$email'";
    $result = mysqli_query($dbc, $query);
    $outcome = mysqli_num_rows($result);

    if ($outcome != 0) {
        $query = "SELECT * FROM Marker WHERE Email='$email'";
        $result = mysqli_query($dbc, $query);
        $outcome = mysqli_num_rows($result);

        if ($outcome != 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $role = $row['Role'];
                $active = $row['Active'];

                if ($active == 1) {
                    session_start();
                    $_SESSION['Role'] = "Marker";
                    echo '<script>alert("Login successful")</script>';
                } else {
                    echo '<script>alert("Account not active")</script>';
                }
            }
        } else {
            echo '<script>alert("Please Register First!")</script>';
        }
    } else {
        echo '<script>alert("Please Register First")</script>';
    }
}
?>