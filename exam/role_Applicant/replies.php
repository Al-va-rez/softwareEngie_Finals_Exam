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
        <title>Replies</title>
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
                <input type="text" name="inp_Search" placeholder="search replies here...">
                <button type="submit" name="btn_Search">Search</button>
                <a class="link_Btn" href="index.php">Clear Search Query</a>
            </form>

            <!-- MESSAGES -->
            <?php $Applicant_getAll_Replies = getAll_Replies($pdo, $_SESSION['username'], $_GET['msg_Replying_To']); ?>
            <?php if (count($Applicant_getAll_Replies) > 0) { ?>
                <table>
                    <thead>
                        <tr colspan="4">Replies to: <?= $_GET['msg_Replying_To'] ?></tr>
                        <tr>
                            <th>From</th>
                            <th>Reply</th>
                            <th>Date Sent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DISPLAY ALL -->
                        <?php if (!isset($_GET['btn_Search'])) { ?>
                            <?php foreach ($Applicant_getAll_Replies as $reply) { ?>
                                <tr>
                                    <td><?= $reply['sender'] ?></td>
                                    <td><?= $reply['reply'] ?></td>
                                    <td><?= $reply['date_Sent'] ?></td>
                                    <td>
                                        <?php if ($_SESSION['username'] == $reply['recipient']) { ?>
                                            <a class="link_Btn" href="delete_Replies.php?reply_id=<?= $reply['id'] ?>">Delete Reply</a>
                                        <?php } ?>
                                        <a class="link_Btn" href="reply_Messages.php?recipient=<?= $reply['sender']?>&msg_Replying_To=<?= $reply['reply']?>">Reply</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            
                        <!-- SEARCH -->
                        <?php } else { ?>
                            <?php $Applicant_search_Replies = search_Replies($pdo, $_GET['inp_Search'], $_SESSION['username'], $_GET['msg_Replying_To']); ?>
                            <?php foreach ($Applicant_search_Replies as $reply) { ?>
                                <tr>
                                    <td><?= $reply['sender'] ?></td>
                                    <td><?= $reply['reply'] ?></td>
                                    <td><?= $reply['date_Sent'] ?></td>
                                    <td>
                                        <?php if ($_SESSION['username'] == $reply['recipient']) { ?>
                                            <a class="link_Btn" href="delete_Replies.php?reply_id=<?= $reply['id'] ?>">Delete Reply</a>
                                        <?php } ?>
                                        <a class="link_Btn" href="reply_Messages.php?recipient=<?= $reply['sender']?>&msg_Replying_To=<?= $reply['reply']?>">Reply</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h2 class="center_Form">Message has not received any replies yet.</h2>
            <?php } ?>
        </div>
    </body>
</html>