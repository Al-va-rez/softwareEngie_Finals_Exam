<?php
    require_once 'core/handleForms.php';

    if (!isset($_SESSION['username']) && !isset($_SESSION['role'])) {
        header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin View</title>
        <link rel="stylesheet" href="misc/myStyles.css">
    </head>
    <body class="admin">
        <!-- REDIRECT TO OTHER DASHBOARDS -->
        <?php
            if ($_SESSION['role'] == 'HR') {
                header("Location: role_HR/dashboard.php");
            }
            elseif ($_SESSION['role'] == 'Applicant') {
                header("Location: role_Applicant/dashboard.php");
            }
        ?>

        <!-- ADMIN NAVBAR -->
        <?php
            include 'navbar.php';
            include 'response.php';
        ?>


        <!-- SEARCH BOX -->
        <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <input type="text" name="inp_Search" placeholder="search logs here...">
            <button type="submit" name="btn_Search">Search</button>
            <a class="link_Btn" href="index.php">Clear Search Query</a>
        </form>


        <!-- ACTIVITY LOGS -->
        <table>
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>Activity</th>
                    <th>Done By</th>
                    <th>Date Committed</th>
                </tr>
            </thead>
            <tbody>
                <!-- DISPLAY ALL -->
                <?php if (!isset($_GET['btn_Search'])) { ?>
                    <?php $getAll_Logs = getAll_Logs($pdo); ?>
                    <?php foreach ($getAll_Logs as $log) { ?>
                        <tr>
                            <td><?= $log['id'] ?></td>
                            <td><?= $log['activity'] ?></td>
                            <td><?= $log['done_By'] ?></td>
                            <td><?= $log['date_Committed'] ?></td>
                        </tr>
                    <?php } ?>
                    
                <!-- SEARCH -->
                <?php } else { ?>
                    <?php $search_Logs = search_Logs($pdo, $_GET['inp_Search']); ?>
                    <?php foreach ($search_Logs as $log) { ?>
                        <tr>
                            <td><?= $log['id'] ?></td>
                            <td><?= $log['activity'] ?></td>
                            <td><?= $log['done_By'] ?></td>
                            <td><?= $log['date_Committed'] ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>