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
        <!-- ADMIN NAVBAR -->
        <?php
            include 'navbar.php';
            include 'response.php';
        ?>


        <!-- SEARCH BOX -->
        <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <input type="text" name="inp_Search" placeholder="search HR here...">
            <button type="submit" name="btn_Search">Search</button>
            <a class="link_Btn" href="all_HR.php">Clear Search Query</a>
        </form>


        <!-- HR USERS -->
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date Registered</th>
                </tr>
            </thead>
            <tbody>
                <!-- DISPLAY ALL -->
                <?php if (!isset($_GET['btn_Search'])) { ?>
                    <?php $getAll_HR = getAll_HR($pdo); ?>
                    <?php foreach ($getAll_HR as $hr) { ?>
                        <tr>
                            <td><?= $hr['id'] ?></td>
                            <td><?= $hr['username'] ?></td>
                            <td><?= $hr['first_Name'] ?></td>
                            <td><?= $hr['last_Name'] ?></td>
                            <td><?= $hr['date_Registered'] ?></td>
                        </tr>
                    <?php } ?>
                    
                <!-- SEARCH -->
                <?php } else { ?>
                    <?php $seach_HR = seach_HR($pdo, $_GET['inp_Search']); ?>
                    <?php foreach ($seach_HR as $hr) { ?>
                        <tr>
                            <td><?= $hr['id'] ?></td>
                            <td><?= $hr['username'] ?></td>
                            <td><?= $hr['first_Name'] ?></td>
                            <td><?= $hr['last_Name'] ?></td>
                            <td><?= $hr['date_Registered'] ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>