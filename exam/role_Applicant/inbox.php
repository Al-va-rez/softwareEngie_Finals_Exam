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

        <!-- HR NAVBAR: enclosed in div for design -->
        <div class="main">
            <?php
                include 'navbar.php';
                include '../response.php';
            ?>
        </div>


        <!-- enclosed in div for design -->
        <div class="contain_Table">
            <!-- SEARCH BOX -->
            <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
                <input type="text" name="inp_Search" placeholder="search messages here..." required>
                <button type="submit" name="btn_Search">Search</button>
                
                <!-- class makes the <a> element look like a button -->
                <a class="link_Btn" href="inbox.php">Clear Search Query</a>
            </form>

            <!-- these are for accessing the functions for creating a new message and viewing messages the current user has sent -->
            <p class="msg_Funcs">
                <!-- first class makes the <a> element look like a button -->
                <!-- second class is used to distinguish the two buttons -->
                <a class="link_Btn write" href="create_Message.php">Write a Message to HR</a>
                <a class="link_Btn switch" href="messages_Sent.php">View Messages Sent</a>
            </p>

            <!-- MESSAGES -->
            <?php $Applicant_getAll_Messages = getAll_Messages_Received($pdo, $_SESSION['username']); ?>
            <!-- check first if there are any -->
            <?php if (count($Applicant_getAll_Messages) > 0) { ?>
                <table>
                    <thead>
                        <!-- TABLE NAME -->
                        <tr>
                            <th class="table_Name" colspan="5">ALL MESSAGES RECEIVED</th>
                        </tr>
                        <!-- COLUMN NAMES -->
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
                                    <!-- class prevents all characters of long texts from displaying in the table -->
                                    <td class="long_Text"><?= $msg['message'] ?></td>
                                    <td><?= $msg['date_Sent'] ?></td>
                                    <td>
                                        <!-- first class makes the <a> element look like a button -->
                                        <!-- second class is used to distinguish the two buttons -->
                                        <a class="link_Btn" href="messages.php?sender=<?= $msg['sender'] ?>&msg_Subject=<?= $msg['subject']?>">Expand</a>
                                        <a class="link_Btn btn_Del" href="delete_Messages.php?msg_id=<?= $msg['id'] ?>">Delete Message</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            
                        <!-- SEARCH: everything should look and work the same as displaying all records -->
                        <?php } else { ?>
                            <?php $Applicant_search_Messages = search_Messages_Received($pdo, $_GET['inp_Search'], $_SESSION['username']); ?>
                            <?php foreach ($Applicant_search_Messages as $msg) { ?>
                                <tr>
                                    <td><?= $msg['sender'] ?></td>
                                    <td><?= $msg['subject'] ?></td>
                                    <td class="long_Text"><?= $msg['message'] ?></td>
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
            <?php } else { ?> <!-- otherwise, show this -->
                <h2 class="center_Form">You have not received any message yet.</h2>
            <?php } ?>
        </div>
    </body>
</html>