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
    <body class="hr">
        <div class="main">

            <!-- INPUTS -->
            <h1 class="center_Form">Create a Message</h1>
            
            <form class="center_Form" action="../core/handleForms.php" method="POST">

                <p> <!-- RECIPIENT -->
                    <label for="inp_Recieve">To: </label>
                    <select id="inp_Recieve" name="recipient">
                        <?php $applicants = getAll_Applicants($pdo); ?>
                        <?php foreach ($applicants as $applicant) { ?>
                            <option value="<?= $applicant['username'] ?>"><?= $applicant['username'] ?></option>
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
                <button type="submit" value="message" name="btn_Message_Applicant">Send</button>
            </form>

            <!-- HOME -->
            <i><a href="inbox.php">Back to Inbox</a></i>
        </div>

        <?php include '../response.php'; ?>
    </body>
</html>