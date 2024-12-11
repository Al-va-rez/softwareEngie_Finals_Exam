<?php
    require_once '../core/handleForms.php';

    if (!isset($_SESSION['username']) && !isset($_SESSION['role'])) {
        if ($_SESSION['role'] != 'Applicant') {
            header('Location: ../login.php');
        }
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

        <!-- APPLICANT NAVBAR: enclosed in div for design -->
        <div class="main">
            <?php
                include 'navbar.php';
                include '../response.php';
            ?>
        </div>

        
        <!-- enclosed in div for design -->
        <div class="contain_Table">
            <!-- SEARCH BOX -->
            <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
                <input type="text" name="inp_Search" placeholder="search jobs here..." requried>
                <button type="submit" name="btn_Search">Search</button>
                
                <!-- class makes the <a> element look like a button -->
                <a class="link_Btn" href="dashboard.php">Clear Search Query</a>
            </form>


            <!-- JOB POSTS -->
            <?php $getAll_Jobs = getAll_Jobs($pdo); ?>
            <!-- check first if there are any -->
            <?php if (count($getAll_Jobs) > 0) { ?>
                <table>
                    <thead>
                        <!-- TABLE NAME -->
                        <tr>
                            <th class="table_Name" colspan="5">LIST OF AVAILABLE JOBS</th>
                        </tr>
                        <!-- COLUMN NAMES -->
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
                            <?php foreach ($getAll_Jobs as $job) { ?>
                                <tr>
                                    <td><?= $job['title'] ?></td>
                                    <!-- class prevents all characters of long texts from displaying in the table -->
                                    <td class="long_Text"><?= $job['description'] ?></td>
                                    <td><?= $job['posted_By'] ?></td>
                                    <td><?= $job['date_Posted'] ?></td>
                                    <td><a class="link_Btn" href="apply_Job.php?job_Title=<?= $job['title']?>&job_Desc=<?= $job['description'] ?>">Apply to Job</a></td>
                                </tr>
                            <?php } ?>
                            
                        <!-- SEARCH: everything should look and work the same as displaying all records -->
                        <?php } else { ?>
                            <?php $search_Jobs = search_Jobs($pdo, $_GET['inp_Search']); ?>
                            <?php foreach ($search_Jobs as $job) { ?>
                                <tr>
                                    <td><?= $job['title'] ?></td>
                                    <td class="long_Text"><?= $job['description'] ?></td>
                                    <td><?= $job['posted_By'] ?></td>
                                    <td><?= $job['date_Posted'] ?></td>
                                    <td><a class="link_Btn" href="apply_Job.php?job_Title=<?= $job['title'] ?>&job_Desc=<?= $job['description'] ?>">Apply to Job</a></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?> <!-- otherwise, show this -->
                <h2 class="center_Form">No jobs available.</h2>
            <?php } ?>
        </div>
    </body>
</html>