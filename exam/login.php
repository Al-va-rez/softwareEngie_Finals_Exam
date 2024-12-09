<?php
    require_once 'core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="misc/myStyles.css">
    </head>
    <body class="login">
        <div class="position_Center">

            <!-- INPUTS -->
            <h1 class="center_Form">LOGIN</h1>
            
            <form class="center_Form" action="core/handleForms.php" method="POST">

                <p> <!-- USERNAME -->
                    <label for="inp_uName">Username: </label>
                    <input type="text" id="inp_uName" name="username">
                </p>
                
                <p> <!-- PASSWORD -->
                    <label for="inp_uPass">Password: </label>
                    <input type="password" id="inp_uPass" name="password">
                </p>

                <!-- SUBMIT -->
                <button type="submit" value="login" name="btn_Login">Login</button>
            </form>

            <!-- REGISTER -->
            <i><a href="register.php">Register</a></i>
        </div>

        <?php include 'response.php'; ?>
    </body>
</html>