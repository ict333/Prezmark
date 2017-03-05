<?php
    include 'db_connect.php'
?>

<html> 
    <head>
        
    </head>
    
    <body>
        <h1> Create Super User</h1>
        <form method="post" action="">
            <label>Email</label>
            <input type="email"></input>
            <br> </br>
            <label>Role</label>
            <select name="role">
                <option value="Admin">Administrator</option>
                <option value="UC">Unit Coordinator</option>
            </select>
            <br> </br>
            <input type="submit" value="Create"></input>
        </form>
    </body>
</html>