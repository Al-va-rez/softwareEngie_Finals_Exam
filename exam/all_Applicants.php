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

        <!-- ADMIN NAVBAR: enclosed in div for design -->
        <div class="main">
            <?php
                include 'navbar.php';
                include 'response.php';
            ?>
        </div>

        
        <!-- enclosed in div for design -->
        <div class="contain_Table">
            <!-- SEARCH BOX -->
            <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
                <input type="text" name="inp_Search" placeholder="search applicants here..." required>
                <button type="submit" name="btn_Search">Search</button>
                
                <!-- class makes the <a> element look like a button -->
                <a class="link_Btn" href="all_Applicants.php">Clear Search Query</a>
            </form>


            <!-- APPLICANTS -->
            <?php $getAll_Applicants = getAll_Applicants($pdo); ?>
            <!-- check first if there are any -->
            <?php if (count($getAll_Applicants) > 0) { ?>
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
            <?php } else { ?> <!-- otherwise, show this -->
                <h2 class="center_Form">No Aplicants registered yet.</h2>
            <?php } ?>
        </div>
    </body>
</html>