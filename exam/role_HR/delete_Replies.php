<?php 
    require_once '../core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Deleting reply</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="hr">
        
        <?php $getSepecific_Reply = getSepecific_Reply($pdo, $_GET['reply_id']); ?>

        <div class="delete_Container">
            <h1>Delete Reply?</h1>
            <h3>From: <?= $getSepecific_Reply['sender']; ?></h3>
            <h3>Original Message: <?= $getSepecific_Reply['original_Message']; ?></h3>
            <h3>Reply: <?= $getSepecific_Reply['reply']; ?></h3>
            <h3>Date Sent: <?= $getSepecific_Reply['date_Sent']; ?></h3>

            <!-- DELETE -->
            <div class="deleteBtn">
                <form action="../core/handleForms.php?reply_id=<?= $_GET['reply_id'] ?>" method="POST">
                    <button type="submit" value="delete" name="btn_Delete_HR_Reply">Delete Reply</button>
                </form>
                <p><a href="replies.php">Back to Replies</a></p>	
            </div>
        </div>
    </body>
</html>