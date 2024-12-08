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
        <title>Job applications</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="hr">

        <!-- ADMIN NAVBAR -->
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
                    <th>Applications for <?php $_GET['job_Title'] ?></th>
                </tr>
                <tr>
                    <th>Applicant</th>
                    <th>Application Status</th>
                    <th>Resume</th>
                    <th>date_Applied</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- DISPLAY ALL -->
                <?php if (!isset($_GET['btn_Search'])) { ?>
                    <?php $getAll_Applications = getAll_Applications($pdo, $_GET['job_Title']); ?>
                    <?php foreach ($getAll_Applications as $application) { ?>
                        <tr>
                            <td><?= $application['applicant'] ?></td>
                            <td><?= $application['status'] ?></td>
                            <td><a href="../uploads/<?= htmlspecialchars($application['resume']) ?>" download>Download Resume</a></td>
                            <td><?= $application['date_Applied'] ?></td>
                            <td><a class="link_Btn" href="respond_Applications.php?applicant=<?= $application['applicant']?>&job_Title=<?= $_GET['job_Title']?>">Respond</a></td>
                        </tr>
                    <?php } ?>
                    
                <!-- SEARCH -->
                <?php } else { ?>
                    <?php $search_Applications = search_Applications($pdo, $_GET['inp_Search'], $_GET['job_Title']); ?>
                    <?php foreach ($search_Applications as $application) { ?>
                        <tr>
                            <td><?= $application['applicant'] ?></td>
                            <td><?= $application['status'] ?></td>
                            <td><a href="../uploads/<?= htmlspecialchars($application['resume']) ?>" download>Download Resume</a></td>
                            <td><?= $application['date_Applied'] ?></td>
                            <td><a class="link_Btn" href="respond_Applications.php?applicant=<?= $application['applicant']?>&job_Title=<?= $_GET['job_Title']?>">Respond</a></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>