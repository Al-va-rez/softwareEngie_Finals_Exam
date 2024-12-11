<?php
    require_once '../core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editing Job</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="hr">
        <div class="main">

            <!-- INPUTS -->
            <?php $specific_Job = getSepecific_Job($pdo, $_GET['job_id']); ?>
            <h1 class="center_Form">Edit</h1>
            
            <form class="center_Form" action="../core/handleForms.php?job_id=<?= $_GET['job_id'] ?>" method="POST">

                <p> <!-- JOB TITLE -->
                    <label for="inp_jTitle">Job Title: </label>
                    <input type="text" id="inp_jTitle" name="job_Title" value="<?= $specific_Job['title']; ?>">
                </p>
                
                <!-- JOB DESCRIPTION -->
                <div class="inp_Textarea">
                    <label for="inp_jDesc">Job Description: </label>
                    <textarea id="inp_jDesc" name="job_Desc"><?= $specific_Job['description']; ?></textarea>
                </div>

                <!-- SUBMIT -->
                <button type="submit" value="edit" name="btn_Edit_Job">Save Changes</button>
            </form>

            <!-- HOME -->
            <i><a href="dashboard.php">Back to Home</a></i>
        </div>

        <?php include '../response.php'; ?>
    </body>
</html>