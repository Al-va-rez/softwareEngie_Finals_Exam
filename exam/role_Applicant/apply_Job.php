<?php
    require_once 'core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Applying to Job</title>
        <link rel="stylesheet" href="misc/myStyles.css">
    </head>
    <body class="applicant">
        <div class="position_Center">

            <!-- INPUTS -->
            <h1 class="center_Form">Apply to Job</h1>
            
            <form class="center_Form" action="core/handleForms.php?job_Title=<?= $job['job_Title'] ?>" method="POST">

                <p> <!-- QUALIFICATIONS -->
                    <label for="inp_Quali">Qualifications: </label>
                    <textarea id="inp_Quali" name="applicant_Quali" placeholder="Why are you the best fit?"></textarea>
                </p>

                <input type="file" name="resume" accept="application/pdf" required>

                <!-- SUBMIT -->
                <button type="submit" value="apply" name="btn_Apply_Job">Apply</button>
            </form>

            <!-- REGISTER -->
            <i><a href="dashboard.php">Back to Home</a></i>
        </div>

        <?php include '../response.php'; ?>
    </body>
</html>