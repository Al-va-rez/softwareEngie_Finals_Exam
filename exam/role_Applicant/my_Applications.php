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
        <title>Your applications</title>
        <link rel="stylesheet" href="../misc/myStyles.css">
    </head>
    <body class="applicant">

        <!-- HR NAVBAR: enclosed in div for design -->
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
                <input type="text" name="inp_Search" placeholder="search applications here..." required>
                <button type="submit" name="btn_Search">Search</button>
                
                <!-- class makes the <a> element look like a button -->
                <a class="link_Btn" href="my_Applications.php">Clear Search Query</a>
            </form>


            <!-- JOB POSTS -->
            <?php $Applicant_getAll_Applications = Applicant_getAll_Applications($pdo, $_SESSION['username']); ?>
            <!-- check first if there are any -->
            <?php if (count($Applicant_getAll_Applications) > 0) { ?>
                <table>
                    <thead>
                        <!-- TABLE NAME -->
                        <tr>
                            <th class="table_Name" colspan="5">Your Applications</th>
                        </tr>
                        <!-- COLUMN NAMES -->
                        <tr>
                            <th>Job Title</th>
                            <th>Application Status</th>
                            <th>Remarks from HR</th>
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
                                    
                                    <!-- change text color based on conditions -->
                                    <td
                                        <?php if ($application['status'] == 'Pending') { ?> style="color:blue"
                                        <?php } else if ($application['status'] == 'Accepted') { ?> style="color:green"
                                        <?php } else if ($application['status'] == 'Rejected') { ?> style="color:red"
                                        <?php } ?>>

                                        <!-- actual text -->
                                        <?= $application['status'] ?>
                                    </td>

                                    <!-- class prevents all characters of long texts from displaying in the table -->
                                    <td class="long_Text"><?= $application['remarks'] ?></td>
                                    <td><i><a href="../uploads/<?= htmlspecialchars($application['resume']) ?>" target="_blank">View Resume</a></i></td>
                                    <td><?= $application['date_Applied'] ?></td>
                                </tr>
                            <?php } ?>
                            
                        <!-- SEARCH: everything should look and work the same as displaying all records -->
                        <?php } else { ?>
                            <?php $Applicant_search_Applications = Applicant_search_Applications($pdo, $_GET['inp_Search'], $_SESSION['username']); ?>
                            <?php foreach ($Applicant_search_Applications as $application) { ?>
                                <tr>
                                    <td><?= $application['job_Title'] ?></td>
                                    
                                    <!-- change text color based on conditions -->
                                    <td
                                        <?php if ($application['status'] == 'Pending') { ?> style="color:blue"
                                        <?php } else if ($application['status'] == 'Accepted') { ?> style="color:green"
                                        <?php } else if ($application['status'] == 'Rejected') { ?> style="color:red"
                                        <?php } ?>>

                                        <!-- actual text -->
                                        <?= $application['status'] ?>
                                    </td>

                                    <!-- class prevents all characters of long texts from displaying in the table -->
                                    <td class="long_Text"><?= $application['remarks'] ?></td>
                                    <td><i><a href="../uploads/<?= htmlspecialchars($application['resume']) ?>" target="_blank">View Resume</a></i></td>
                                    <td><?= $application['date_Applied'] ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h2 class="center_Form">You have not applied to any jobs yet.</h2>
            <?php } ?>
        </div>
    </body>
</html>