<?php
    require_once '../core/handleForms.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Replying to Message</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="hr">
        <div class="position_Center">
            <table>
                <tbody>
                    <tr>
                        <td>From:</td>
                        <td><?= $_GET['recipient']?></td>
                    </tr>
                    <tr>
                        <td>Message:</td>
                        <td><?= $_GET['msg_Replying_To']?></td>
                    </tr>
                    <tr>
                        <td>Reply:</td>
                        <td>
                            <form class="center_Form" action="core/handleForms.php?recipient=<?= $_GET['recipient']?>&msg_Replying_To=<?= $_GET['msg_Replying_To']?>" method="POST">

                                <p><textarea id="inp_Msg" name="message"></textarea></p>

                                <!-- SUBMIT -->
                                <button type="submit" value="reply" name="btn_Reply_Message">Send Reply</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <!-- HOME -->
                        <i><a href="dashboard.php">Back to Home</a></i>
                    </tr>
                </tbody>
            </table>
        </div>

        <?php include '../response.php'; ?>
    </body>
</html>