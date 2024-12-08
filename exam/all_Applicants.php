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
            <input type="text" name="inp_Search" placeholder="search applicants here...">
            <button type="submit" name="btn_Search">Search</button>
            <a class="link_Btn" href="all_Applicants.php">Clear Search Query</a>
        </form>


        <!-- APPLICANTS -->
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
                    <?php $getAll_Applicants = getAll_Applicants($pdo); ?>
                    <?php foreach ($getAll_Applicants as $applicant) { ?>
                        <tr>
                            <td><?= $applicant['id'] ?></td>
                            <td><?= $applicant['username'] ?></td>
                            <td><?= $applicant['first_Name'] ?></td>
                            <td><?= $applicant['last_Name'] ?></td>
                            <td><?= $applicant['date_Registered'] ?></td>
                        </tr>
                    <?php } ?>
                    
                <!-- SEARCH -->
                <?php } else { ?>
                    <?php $search_Applicant = search_Applicant($pdo, $_GET['inp_Search']); ?>
                    <?php foreach ($search_Applicant as $applicant) { ?>
                        <tr>
                            <td><?= $applicant['id'] ?></td>
                            <td><?= $applicant['username'] ?></td>
                            <td><?= $applicant['first_Name'] ?></td>
                            <td><?= $applicant['last_Name'] ?></td>
                            <td><?= $applicant['date_Registered'] ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>