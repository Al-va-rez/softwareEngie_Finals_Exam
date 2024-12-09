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
    <body>
        <?php $specific_Job = getSepecific_Job($pdo, $_GET['job_id']); ?>

        <h1>Delete Job?</h1>

        <div class="delete_Container">
            <h3>First Name: <?= $specific_Job['title']; ?></h3>
            <h3>Last Name: <?= $specific_Job['description']; ?></h3>
            <h3>Date of Birth: <?= $specific_Job['date_Posted']; ?></h3>

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