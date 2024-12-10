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
        <title>Job applications</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="hr">

        <div class="position_Center">
            <!-- HR NAVBAR -->
            <?php
                include 'navbar.php';
                include '../response.php';
            ?>
        </div>


        <div class="position_Center">
            <!-- SEARCH BOX -->
            <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
                <input type="text" name="inp_Search" placeholder="search jobs here...">
                <button type="submit" name="btn_Search">Search</button>
                <a class="link_Btn" href="index.php">Clear Search Query</a>
            </form>


            <!-- JOB POSTS -->
            <?php $HR_getAll_Applications = HR_getAll_Applications($pdo, $_GET['job_Title']); ?>
            <?php if (count($HR_getAll_Applications) > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th class="table_Name" colspan="6">Applications for <?= $_GET['job_Title'] ?></th>
                        </tr>
                        <tr>
                            <th>Applicant</th>
                            <th>Application Status</th>
                            <th>Justification</th>
                            <th>Date Applied</th>
                            <th>Resume</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DISPLAY ALL -->
                        <?php if (!isset($_GET['btn_Search'])) { ?>
                            <?php foreach ($HR_getAll_Applications as $application) { ?>
                                <tr>
                                    <td><?= $application['applicant'] ?></td>
                                    <td
                                        <?php if ($application['status'] == 'Pending') { ?> style="color:blue"
                                        <?php } else if ($application['status'] == 'Accepted') { ?> style="color:green"
                                        <?php } else if ($application['status'] == 'Rejected') { ?> style="color:red"
                                        <?php } ?>>

                                        <?= $application['status'] ?>
                                    </td>
                                    <td><?= $application['justification'] ?></td>
                                    <td><?= $application['date_Applied'] ?></td>
                                    <?php if ($_SESSION['username'] == $_GET['posted_By']) { ?>
                                        <td><i><a href="../uploads/<?= htmlspecialchars($application['resume']) ?>" download>Download Resume</a></i></td>
                                        <td><a class="link_Btn" href="respond_Applications.php?applicant=<?= $application['applicant']?>&job_Title=<?= $_GET['job_Title']?>&posted_By=<?= $_GET['posted_By'] ?>">Respond</a></td>
                                    <?php } else { ?>
                                        <td colspan="2" style="font-weight: bold; font-style: italic;">You did not create this job</td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            
                        <!-- SEARCH -->
                        <?php } else { ?>
                            <?php $HR_search_Applications = HR_search_Applications($pdo, $_GET['inp_Search'], $_GET['job_Title']); ?>
                            <?php foreach ($HR_search_Applications as $application) { ?>
                                <tr>
                                    <td><?= $application['applicant'] ?></td>
                                    <td
                                        <?php if ($application['status'] == 'Pending') { ?> style="color:blue"
                                        <?php } else if ($application['status'] == 'Accepted') { ?> style="color:green"
                                        <?php } else if ($application['status'] == 'Rejected') { ?> style="color:red"
                                        <?php } ?>>

                                        <?= $application['status'] ?>
                                    </td>
                                    <td><?= $application['justification'] ?></td>
                                    <td><?= $application['date_Applied'] ?></td>
                                    <?php if ($_SESSION['username'] == $_GET['posted_By']) { ?>
                                        <td><i><a href="../uploads/<?= htmlspecialchars($application['resume']) ?>" download>Download Resume</a></i></td>
                                        <td><a class="link_Btn" href="respond_Applications.php?applicant=<?= $application['applicant']?>&job_Title=<?= $_GET['job_Title']?>&posted_By=<?= $_GET['posted_By'] ?>">Respond</a></td>
                                    <?php } else { ?>
                                        <td colspan="2" style="font-weight: bold; font-style: italic;">You did not create this job</td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h2 class="center_Form">No applications.</h2>
            <?php } ?>
        </div>
    </body>
</html>