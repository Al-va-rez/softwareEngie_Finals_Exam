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
    <body class="applicant">

        <?php $getAll_Subject_Messages = getAll_Subject_Messages($pdo, $_GET['msg_Subject']); ?>

        <div class="contain_Table">
            <!-- HOME -->
            <i><a href="inbox.php">Back to Messages</a></i>
            <table>
                <thead>
                    <tr>
                        <th class="table_Name" colspan="4">
                            <p>To: <?= $_GET['sender'] ?></p>
                            <p>Subject: <?= $_GET['msg_Subject'] ?></p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($getAll_Subject_Messages as $msg) { ?>
                        <?php if ($msg['sender'] != $_SESSION['username']) { ?>
                            <tr class="contact" >
                                <td>
                                    <i><?= $msg['date_Sent'] ?></i>
                                    <b><?= $msg['sender'] ?>:</b>
                                </td>
                                <td colspan="2">
                                    <?= $msg['message'] ?>
                                </td>
                                <td></td>
                            </tr>
                        <?php } else { ?>
                            <tr class="user">
                                <td></td>
                                <td colspan="2">
                                    <?= $msg['message'] ?>
                                </td>
                                <td>
                                    <b>:<?= $msg['sender'] ?></b>
                                    <i><?= $msg['date_Sent'] ?></i>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>

                    <tr class="messenger">
                        <td>Reply:</td>
                        <td colspan="3">
                            <form action="../core/handleForms.php?recipient=<?= $_GET['sender']?>&msg_Subject=<?= $_GET['msg_Subject']?>" method="POST">
                                <textarea id="inp_Msg" name="reply"></textarea>
                                <!-- SUBMIT -->
                                <button type="submit" value="reply" name="btn_Reply_Applicant">Send Reply</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <?php include '../response.php'; ?>
    </body>
</html>