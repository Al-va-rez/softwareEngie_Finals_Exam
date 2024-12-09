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
    <body class="hr">

        <div class="position_Center">
            <?php
                include 'navbar.php';
                include '../response.php';
            ?>
        </div>
        <!-- HR NAVBAR -->
        

        <div class="position_Center">
            <!-- SEARCH BOX -->
            <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
                <input type="text" name="inp_Search" placeholder="search messages here...">
                <button type="submit" name="btn_Search">Search</button>
                <a class="link_Btn" href="index.php">Clear Search Query</a>
            </form>

            <p>
                <a class="link_Btn" href="create_Message.php">Send a Message to Applicant</a>
            </p>

            <!-- MESSAGES -->
            <?php $HR_getAll_Messages = getAll_Messages($pdo, $_SESSION['username']); ?>
            <?php if (count($HR_getAll_Messages) > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Message</th>
                            <th>Date Sent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DISPLAY ALL -->
                        <?php if (!isset($_GET['btn_Search'])) { ?>
                            <?php foreach ($HR_getAll_Messages as $msg) { ?>
                                <tr>
                                    <td><?= $msg['sender'] ?></td>
                                    <td><?= $msg['message'] ?></td>
                                    <td><?= $msg['date_Sent'] ?></td>
                                    <td><a class="link_Btn" href="reply_Messages.php?recipient=<?= $msg['sender']?>&msg_Replying_To=<?= $msg['message']?>">Reply</a></td>
                                </tr>
                            <?php } ?>
                            
                        <!-- SEARCH -->
                        <?php } else { ?>
                            <?php $HR_search_Messages = search_Messages($pdo, $_GET['inp_Search'], $_SESSION['username']); ?>
                            <?php foreach ($HR_search_Messages as $msg) { ?>
                                <tr>
                                    <td><?= $msg['sender'] ?></td>
                                    <td><?= $msg['message'] ?></td>
                                    <td><?= $msg['date_Sent'] ?></td>
                                    <td><a class="link_Btn" href="reply_Messages.php?recipient=<?= $msg['sender']?>&msg_Replying_To=<?= $msg['message']?>">Reply</a></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h2 class="center_Form">No messages.</h2>
            <?php } ?>
        </div>
    </body>
</html>