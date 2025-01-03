<?php
    require_once '../core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Responding to Application</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="hr">
        
        <!-- encolsed in div for design -->
        <div class="alt_Main">

            <!-- INPUTS -->
            <h1 class="center_Form">Accept or Deny <?= $_GET['applicant']?></h1>
            
            <form class="center_Form" action="../core/handleForms.php?applicant=<?= $_GET['applicant']?>&job_Title=<?= $_GET['job_Title']?>&posted_By=<?= $_GET['posted_By'] ?>" method="POST">

                <p> <!-- APPLICATION STATUS -->
                    <label for="inp_Status">Verdict: </label>
                    <select id="inp_Status" name="status">
                        <option value="Accepted">Accept</option>
                        <option value="Rejected">Reject</option>
                    </select>
                </p>
                
                <!-- MESSAGE: encolsed in div for desi -->
                <div class="inp_Textarea">
                    <label for="inp_Msg">Remarks: </label>
                    <textarea id="inp_Msg" name="message"></textarea>
                </div>

                <!-- SUBMIT -->
                <button type="submit" value="respond" name="btn_Respond_Application">Done</button>
            </form>

            <!-- HOME -->
            <i><a href="view_Applications.php?job_Title=<?= $_GET['job_Title']?>&posted_By=<?= $_GET['posted_By'] ?>">Back to Applications</a></i>
        </div>

        <!-- RESPONSE placed here to avoid design changes in div above -->
        <?php include '../response.php'; ?>
    </body>
</html>