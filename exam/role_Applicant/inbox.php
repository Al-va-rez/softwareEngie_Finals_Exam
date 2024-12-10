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

        <div class="main">
            <!-- APPLICANT NAVBAR -->
            <?php
                include 'navbar.php';
                include '../response.php';
            ?>
        </div>


        <div class="contain_Table">
            <!-- SEARCH BOX -->
            <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
                <input type="text" name="inp_Search" placeholder="search messages here...">
                <button type="submit" name="btn_Search">Search</button>
                <a class="link_Btn" href="index.php">Clear Search Query</a>
            </form>

            <p class="msg_Funcs">
                <a class="link_Btn write" href="create_Message.php">Write a Message to HR</a>
                <a class="link_Btn switch" href="messages_Sent.php">View Messages Sent</a>
            </p>

            <!-- MESSAGES -->
            <?php $Applicant_getAll_Messages = getAll_Messages_Received($pdo, $_SESSION['username']); ?>
            <?php if (count($Applicant_getAll_Messages) > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th class="table_Name" colspan="5">ALL MESSAGES RECEIVED</th>
                        </tr>
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
                                    <td class="inbox"><?= $msg['message'] ?></td>
                                    <td><?= $msg['date_Sent'] ?></td>
                                    <td>
                                        <a class="link_Btn" href="messages.php?sender=<?= $msg['sender'] ?>&msg_Subject=<?= $msg['subject']?>">Expand</a>
                                        <a class="link_Btn btn_Del" href="delete_Messages.php?msg_id=<?= $msg['id'] ?>">Delete Message</a>
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
                                    <td class="inbox"><?= $msg['message'] ?></td>
                                    <td><?= $msg['date_Sent'] ?></td>
                                    <td>
                                        <a class="link_Btn" href="messages.php?sender=<?= $msg['sender'] ?>&msg_Subject=<?= $msg['subject']?>">Expand</a>
                                        <a class="link_Btn btn_Del" href="delete_Messages.php?msg_id=<?= $msg['id'] ?>">Delete Message</a>
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