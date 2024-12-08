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

        <!-- APPLICANT NAVBAR -->
        <?php
            include 'navbar.php';
            include '../response.php';
        ?>


        <!-- SEARCH BOX -->
        <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <input type="text" name="inp_Search" placeholder="search messages here...">
            <button type="submit" name="btn_Search">Search</button>
            <a class="link_Btn" href="index.php">Clear Search Query</a>
        </form>

        <!-- update: (1) messages received and sent (2) delete messages -->
        <!-- MESSAGES -->
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
                    <?php $Applicant_getAll_Messages = getAll_Messages($pdo, $_SESSION['username']); ?>
                    <?php foreach ($Applicant_getAll_Messages as $msg) { ?>
                        <tr>
                            <td><?= $msg['sender'] ?></td>
                            <td><?= $msg['message'] ?></td>
                            <td><?= $msg['date_Sent'] ?></td>
                            <td><a class="link_Btn" href="reply_Messages.php?recipient=<?= $msg['sender']?>&msg_Replying_To=<?= $msg['message']?>">Reply</a></td>
                        </tr>
                    <?php } ?>
                    
                <!-- SEARCH -->
                <?php } else { ?>
                    <?php $Applicant_search_Messages = search_Messages($pdo, $_GET['inp_Search'], $_SESSION['username']); ?>
                    <?php foreach ($Applicant_search_Messages as $msg) { ?>
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
    </body>
</html>