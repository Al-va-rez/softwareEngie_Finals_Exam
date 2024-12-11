<?php
    require_once 'core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="misc/myStyles.css">
    </head>
    <body class="register">
        
        <!-- encolsed in div for design -->
        <div class="main">

            <h1 class="center_Form">REGISTER</h1>
            
            <form class="center_Form" action="core/handleForms.php" method="POST">

                <p> <!-- USER ROLE -->
                    <label for="inp_uRole">Role: </label>
                    <select id="inp_uRole" name="role">
                        <option value="HR">HR</option>
                        <option value="Applicant">Applicant</option>
                        <option value="Admin">Admin</option>
                    </select>
                </p>


                <p> <!-- USERNAME -->
                    <label for="inp_uName">Username: </label>
                    <input type="text" id="inp_uName" name="username">
                </p>


                <p> <!-- FIRST NAME -->
                    <label for="inp_fName">First Name: </label>
                    <input type="text" id="inp_fName" name="first_Name">
                </p>


                <p> <!-- LAST NAME -->
                    <label for="inp_lName">Last Name: </label>
                    <input type="text" id="inp_lName" name="last_Name">
                </p>

                
                <p> <!-- PASSWORD -->
                    <label for="inp_Pass">Password: </label>
                    <input type="password" id="inp_Pass" name="password">
                </p>


                <p> <!-- CONFIRM PASSWORD -->
                    <label for="inp_Pass_Confirm">Confirm Password: </label>
                    <input type="password" id="inp_Pass_Confirm" name="password_conf">
                </p>


                <!-- SUBMIT -->
                <button type="submit" value="Register" name="btn_Register">Register</button>
            </form>

             <!-- LOGIN -->
            <i><a href="login.php">Back to login</a></i>
        </div>

        <!-- RESPONSE placed here to avoid design changes in div above -->
        <?php include 'response.php'; ?>
    </body>
</html>