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

        <!-- get all messages regarding the specific subject -->
        <?php $getAll_Subject_Messages = getAll_Subject_Messages($pdo, $_GET['msg_Subject']); ?>

        <!-- enclosed in div for design -->
        <div class="contain_Table">
            <!-- BACK TO INBOX -->
            <i><a href="inbox.php">Back to Inbox</a></i>

            <!-- the design is inspired by the Messenger app -->
            <table>
                <thead>
                    <!-- table name acting as the "To: " and "Subject: " lines -->
                    <tr>
                        <th class="table_Name" colspan="4">
                            <p>To: <?= $_GET['sender'] ?></p>
                            <p>Subject: <?= $_GET['msg_Subject'] ?></p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($getAll_Subject_Messages as $msg) { ?>
                        <!-- it is possible for different messages to have the same subject by coincidence -->

                        <!-- so if message was sent by the current user's specific contact, align the data to the left -->
                        <?php if ($msg['sender'] == $_GET['sender']) { ?>
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
                        <!-- and if message was sent by the current user itself, align the data to the right -->
                        <?php } elseif ($msg['sender'] == $_SESSION['username']) { ?>
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
                        <!-- otherwise, the message will not be displayed -->
                    <?php } ?>


                    <!-- MESSAGE/REPLY -->
                    <tr class="messenger">
                        <td>Reply:</td>
                        <td colspan="3">
                            <form action="../core/handleForms.php?recipient=<?= $_GET['sender']?>&msg_Subject=<?= $_GET['msg_Subject']?>" method="POST">
                                <!-- MESSAGE/REPLY -->
                                <textarea id="inp_Msg" name="reply"></textarea>
                                <!-- SUBMIT -->
                                <button type="submit" value="reply" name="btn_Reply_Applicant">Send Reply</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- RESPONSE placed here to avoid design changes in above div -->
        <?php include '../response.php'; ?>
    </body>
</html>