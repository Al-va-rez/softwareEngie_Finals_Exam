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
        <title>Dashboard</title>
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
            <input type="text" name="inp_Search" placeholder="search jobs here...">
            <button type="submit" name="btn_Search">Search</button>
            <a class="link_Btn" href="index.php">Clear Search Query</a>
        </form>


        <!-- JOB POSTS -->
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Job Description</th>
                    <th>Posted By</th>
                    <th>Date Posted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- DISPLAY ALL -->
                <?php if (!isset($_GET['btn_Search'])) { ?>
                    <?php $getAll_Jobs = getAll_Jobs($pdo); ?>
                    <?php foreach ($getAll_Jobs as $job) { ?>
                        <tr>
                            <td><?= $job['title'] ?></td>
                            <td><?= $job['description'] ?></td>
                            <td><?= $job['posted_By'] ?></td>
                            <td><?= $job['date_Posted'] ?></td>
                            <td><a class="link_Btn" href="apply_Job.php?job_Title=<?= $job['title']?>">Apply to Job</a></td>
                        </tr>
                    <?php } ?>
                    
                <!-- SEARCH -->
                <?php } else { ?>
                    <?php $search_Jobs = search_Jobs($pdo, $_GET['inp_Search']); ?>
                    <?php foreach ($search_Jobs as $log) { ?>
                        <tr>
                            <td><?= $job['title'] ?></td>
                            <td><?= $job['description'] ?></td>
                            <td><?= $job['posted_By'] ?></td>
                            <td><?= $job['date_Posted'] ?></td>
                            <td><a class="link_Btn" href="apply_Job.php?job_Title=<?= $job['title'] ?>">Apply to Job</a></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>