<?php
    require_once '../core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Applying to Job</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="applicant">
        <div class="main">

            <!-- INPUTS -->
            <h1 class="center_Form">Applying as <?= $_GET['job_Title'] ?></h1>
            <p><b>Description:</b> <?= $_GET['job_Desc'] ?></p>
            
            <form class="center_Form" action="../core/handleForms.php?job_Title=<?= $_GET['job_Title'] ?>" method="POST" enctype="multipart/form-data">

                <!-- QUALIFICATIONS -->
                <div class="inp_Textarea">
                    <label for="inp_Quali">Qualifications: </label>
                    <textarea id="inp_Quali" name="applicant_Quali" placeholder="Why are you the best fit?"></textarea>
                </div>

                <p> <!-- RESUME -->
                    <input type="file" name="resume" accept="application/pdf" required>
                </p>

                <!-- SUBMIT -->
                <button type="submit" value="apply" name="btn_Apply_Job">Apply</button>
            </form>

            <!-- HOME -->
            <i><a href="dashboard.php">Back to Home</a></i>
        </div>

        <?php include '../response.php'; ?>
    </body>
</html>