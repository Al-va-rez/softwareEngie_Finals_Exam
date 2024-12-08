<?php
    require_once 'core/handleForms.php';

    if (!isset($_SESSION['username']) && !isset($_SESSION['role'])) {
        header('Location: ../login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your applications</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="hr">

        <!-- APPLICANT NAVBAR -->
        <?php
            include 'navbar.php';
            include '../response.php';
        ?>


        <!-- SEARCH BOX -->
        <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <input type="text" name="inp_Search" placeholder="search applications here...">
            <button type="submit" name="btn_Search">Search</button>
            <a class="link_Btn" href="index.php">Clear Search Query</a>
        </form>


        <!-- JOB POSTS -->
        <?php $Applicant_getAll_Applications = Applicant_getAll_Applications($pdo, $_SESSION['username']); ?>
        <?php if (count($Applicant_getAll_Applications) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Your Applications</th>
                    </tr>
                    <tr>
                        <th>Job Title</th>
                        <th>Application Status</th>
                        <th>Resume</th>
                        <th>date_Applied</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DISPLAY ALL -->
                    <?php if (!isset($_GET['btn_Search'])) { ?>
                        <?php foreach ($Applicant_getAll_Applications as $application) { ?>
                            <tr>
                                <td><?= $application['job_Title'] ?></td>
                                <td><?= $application['status'] ?></td>
                                <td><a href="../uploads/<?= htmlspecialchars($application['resume']) ?>" target="_blank">View Resume</a></td>
                                <td><?= $application['date_Applied'] ?></td>
                            </tr>
                        <?php } ?>
                        
                    <!-- SEARCH -->
                    <?php } else { ?>
                        <?php $Applicant_search_Applications = Applicant_search_Applications($pdo, $_GET['inp_Search'], $_SESSION['username']); ?>
                        <?php foreach ($Applicant_search_Applications as $application) { ?>
                            <tr>
                                <td><?= $application['job_Title'] ?></td>
                                <td><?= $application['status'] ?></td>
                                <td><a href="../uploads/<?= htmlspecialchars($application['resume']) ?>" target="_blank">View Resume</a></td>
                                <td><?= $application['date_Applied'] ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>You have not applied to any jobs yet.</p>
        <?php } ?>
    </body>
</html>