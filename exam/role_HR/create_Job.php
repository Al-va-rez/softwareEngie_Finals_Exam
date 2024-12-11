<?php
    require_once '../core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Creating Job</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="hr">
        <div class="alt_Main">

            <!-- INPUTS -->
            <h1 class="center_Form">Create New Job</h1>
            <p>Job will automatically appear in applicants' dashboards once created.</p>
            
            <form class="center_Form" action="../core/handleForms.php" method="POST">

                <p> <!-- JOB TITLE -->
                    <label for="inp_jTitle">Job Title: </label>
                    <input type="text" id="inp_jTitle" name="job_Title">
                </p>
                
                <!-- JOB DESCRIPTION -->
                <div class="inp_Textarea">
                    <label for="inp_jDesc">Job Description:</label>
                    <textarea id="inp_jDesc" name="job_Desc"></textarea>
                </div>

                <!-- SUBMIT -->
                <button type="submit" value="create" name="btn_Create_Job">Create Job</button>
            </form>

            <!-- HOME -->
            <i><a href="dashboard.php">Back to Home</a></i>
        </div>

        <?php include '../response.php'; ?>
    </body>
</html>