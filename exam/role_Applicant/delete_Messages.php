<?php 
    require_once '../core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Deleting message</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="applicant">
        
        <?php $getSepecific_Message = getSepecific_Message($pdo, $_GET['msg_id']); ?>

        <!-- encolsed in div for design -->
        <div class="delete_Container">
            <h1>Delete Message?</h1>
            <h3>From: <?= $getSepecific_Message['sender']; ?></h3>
            <h3>Subject: <?= $getSepecific_Message['subject']; ?></h3>
            <h3>Message: <?= $getSepecific_Message['message']; ?></h3>
            <h3>Date Sent: <?= $getSepecific_Message['date_Sent']; ?></h3>

            <!-- DELETE: encolsed in div for design -->
            <div class="deleteBtn">
                <form action="../core/handleForms.php?msg_id=<?= $_GET['msg_id'] ?>" method="POST">
                    <button type="submit" value="delete" name="btn_Delete_Applicant_Message">Delete Message</button>
                </form>

                <!-- HOME -->
                <p><a href="messages_Received.php">Back to Inbox</a></p>	
            </div>
        </div>
    </body>
</html>