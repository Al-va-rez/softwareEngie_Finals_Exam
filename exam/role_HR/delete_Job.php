<?php 
    require_once '../core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Deleting job</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="hr">
        
        <?php $specific_Job = getSepecific_Job($pdo, $_GET['job_id']); ?>

        <div class="delete_Container">
            <h1>Delete Job?</h1>
            <p><b>Title:</b> <?= $specific_Job['title']; ?></p>
            <p><b>Description:</b> <?= $specific_Job['description']; ?></p>
            <p><b>Date Posted:</b> <?= $specific_Job['date_Posted']; ?></p>

            <!-- DELETE -->
            <div class="deleteBtn">
                <form action="../core/handleForms.php?job_id=<?= $_GET['job_id'] ?>" method="POST">
                    <button type="submit" value="delete" name="btn_Delete_Job">Delete Job</button>
                </form>
                <p><a href="dashboard.php">Back to home</a></p>	
            </div>
        </div>
    </body>
</html>