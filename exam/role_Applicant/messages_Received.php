<?php
    require_once '../core/handleForms.php';

    if (!isset($_SESSION['username']) && !isset($_SESSION['role'])) {
        header('Location: ../login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Messages</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="applicant">

        <div class="position_Center">
            <!-- APPLICANT NAVBAR -->
            <?php
                include 'navbar.php';
                include '../response.php';
            ?>
        </div>


        <div class="position_Center">
            <!-- SEARCH BOX -->
            <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
                <input type="text" name="inp_Search" placeholder="search messages here...">
                <button type="submit" name="btn_Search">Search</button>
                <a class="link_Btn" href="index.php">Clear Search Query</a>
            </form>

            <p>
                <a class="link_Btn" href="create_Message.php">Send a Message to HR</a>
                <a class="link_Btn" href="messages_Sent.php">Messages Sent</a>
            </p>

            <!-- MESSAGES -->
            <?php $Applicant_getAll_Messages = getAll_Messages_Received($pdo, $_SESSION['username']); ?>
            <?php if (count($Applicant_getAll_Messages) > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date Sent</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DISPLAY ALL -->
                        <?php if (!isset($_GET['btn_Search'])) { ?>
                            <?php foreach ($Applicant_getAll_Messages as $msg) { ?>
                                <tr>
                                    <td><?= $msg['sender'] ?></td>
                                    <td><?= $msg['subject'] ?></td>
                                    <td><?= $msg['message'] ?></td>
                                    <td><?= $msg['date_Sent'] ?></td>
                                    <td>
                                        <?php if ($_SESSION['username'] == $msg['recipient']) { ?>
                                            <a class="link_Btn" href="delete_Messages.php?msg_id=<?= $msg['id'] ?>">Delete Message</a>
                                        <?php } ?>
                                        <a class="link_Btn" href="reply_Messages.php?recipient=<?= $msg['sender']?>&msg_Replying_To=<?= $msg['message']?>&msg_Subject=<?= $msg['subject']?>">Reply</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            
                        <!-- SEARCH -->
                        <?php } else { ?>
                            <?php $Applicant_search_Messages = search_Messages_Received($pdo, $_GET['inp_Search'], $_SESSION['username']); ?>
                            <?php foreach ($Applicant_search_Messages as $msg) { ?>
                                <tr>
                                    <td><?= $msg['sender'] ?></td>
                                    <td><?= $msg['subject'] ?></td>
                                    <td><?= $msg['message'] ?></td>
                                    <td><?= $msg['date_Sent'] ?></td>
                                    <td>
                                        <?php if ($_SESSION['username'] == $msg['recipient']) { ?>
                                            <a class="link_Btn" href="delete_Messages.php?msg_id=<?= $msg['id'] ?>">Delete Message</a>
                                        <?php } ?>
                                        <a class="link_Btn" href="reply_Messages.php?recipient=<?= $msg['sender']?>&msg_Replying_To=<?= $msg['message']?>&msg_Subject=<?= $msg['subject']?>">Reply</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h2 class="center_Form">You have not received any message yet.</h2>
            <?php } ?>
        </div>
    </body>
</html>