<?php
    require_once '../core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Creating message</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="applicant">
        <div class="position_Center">

            <!-- INPUTS -->
            <h1 class="center_Form">Create a Message</h1>
            
            <form class="center_Form" action="../core/handleForms.php" method="POST">

                <p> <!-- RECIPIENT -->
                    <label for="inp_Recieve">To: </label>
                    <select id="inp_Recieve" name="recipient">
                        <?php $hr_Users = getAll_HR($pdo); ?>
                        <?php foreach ($hr_Users as $hr) { ?>
                            <option value="<?= $hr['username'] ?>"><?= $hr['username'] ?></option>
                        <?php } ?>
                    </select>
                </p>

                <p> <!-- SUBJECT -->
                    <label for="inp_Subject">Subject: </label>
                    <input type="text" id="inp_Subject" name="subject">
                </p>
                
                <!-- MESSAGE -->
                <div class="inp_Textarea"> 
                    <label for="inp_Msg">Message: </label>
                    <textarea id="inp_Msg" name="message"></textarea>
                </div>

                <!-- SUBMIT -->
                <button type="submit" value="message" name="btn_Message_HR">Send</button>
            </form>

            <!-- HOME -->
            <i><a href="dashboard.php">Back to Home</a></i>
        </div>

        <?php include '../response.php'; ?>
    </body>
</html>