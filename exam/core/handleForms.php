<?php
    require_once 'dbConfig.php';
    require_once 'functions.php';


    /* --- USERS --- */
    // register
    if (isset($_POST['btn_Register'])) {

        if (!empty($_POST['username']) && !empty($_POST['first_Name']) && !empty($_POST['last_Name']) && !empty($_POST['password'])) {

            $role = $_POST['role'];
            $username = sanitizeInput($_POST['username']);
            $first_Name = sanitizeInput($_POST['first_Name']);
            $last_Name = sanitizeInput($_POST['last_Name']);

            if ($_POST['password'] == $_POST['password_conf']) {

                if (validatePassword(sanitizeInput($_POST['password']))) { // check password strength

                    $password = password_hash(sanitizeInput($_POST['password']), PASSWORD_DEFAULT); // encrypt password

                    $result = register($pdo, $role, $username, $first_Name, $last_Name, $password); // add user

                    $_SESSION['status'] = $result['status'];
                    $_SESSION['message'] = $result['message'];
                    header("Location: ../login.php");

                } else { // weak password
                    $_SESSION['status'] = "400";
                    $_SESSION['message'] = "Password must be more than 8 characters consisted of uppercase and lowercase letters and numbers.";
                    header("Location: ../register.php");
                }
            } else { // passwords not the same
                $_SESSION['status'] = "400";
                $_SESSION['message'] = "Passwords are not the same";
                header("Location: ../register.php");
            }
        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../register.php");
        }
    }

    // login
    if (isset($_POST['btn_Login'])) {

        if (!empty($_POST['username']) && !empty($_POST['password'])) {

            $username = sanitizeInput($_POST['username']);
            $password = sanitizeInput($_POST['password']);

            $check_User = check_UserExists($pdo, $username); 

            if ($check_User['status'] == '200') { // user found in database
                $username_FromDB = $check_User['userInfo']['username'];
                $role_FromDB = $check_User['userInfo']['role'];
                $password_FromDB = $check_User['userInfo']['password'];

                if (password_verify($password, $password_FromDB)) {

                    $_SESSION['username'] = $username_FromDB;
                    $_SESSION['role'] = $role_FromDB;
                    header('Location: ../index.php');
                    
                } else { // wrong password
                    $_SESSION['status'] = "400";
                    $_SESSION['message'] = "Wrong password.";
                    header("Location: ../login.php");
                }
            } else { // wrong username
                $_SESSION['status'] = $check_User['status'];
                $_SESSION['message'] = $check_User['message'];
                header("Location: ../login.php");
            }
        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../login.php");
        }
    }

    // logout
    if (isset($_GET['btn_Logout'])) {
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: ../index.php');
    }




    /* --- JOBS (HR ONLY) --- */
    // create 
    if (isset($_GET['btn_Create_Job'])) {

        if (!empty($_POST['job_Title']) && !empty($_POST['job_Desc'])) {

            $job_Title = sanitizeInput($_POST['job_Title']);
            $job_Desc = sanitizeInput($_POST['job_Desc']);
            $posted_By = $_SESSION['username'];


            $result = create_Job($pdo, $job_Title, $job_Desc, $posted_By);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_HR/dashboard.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_HR/create_Job.php");
        }
    }

    // update
    // delete




    /* --- APPLICATIONS --- */
    // create (applicants apply to jobs)
    if (isset($_GET['btn_Apply_Job'])) {

        if (!empty($_POST['applicant_Quali']) && !empty($_POST['resume'])) {

            $job_Title = sanitizeInput($_POST['job_Title']);
            $justification = sanitizeInput($_POST['applicant_Quali']);
            $resume = $_FILES['resume'];
            $applicant = $_SESSION['username'];

            $resume_name = time() . "_" . $resume['name'];
            move_uploaded_file($resume['tmp_name'], "../uploads/$resume_name");


            $result = create_Application($pdo, $job_Title, $applicant, $justification, $resume);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_HR/dashboard.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_HR/create_Job.php");
        }
    }

    // update (hr accepts or denies applications)
    if (isset($_GET['btn_Respond_Application'])) {

        if (!empty($_POST['status']) && !empty($_POST['message'])) {

            $application_Status = sanitizeInput($_POST['status']);
            $message = sanitizeInput($_POST['message']);
            $applicant = $_GET['applicant'];
            $done_By = $_SESSION['username'];
            

            $result = update_Application($pdo, $application_Status, $message, $applicant, $done_By);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_HR/view_Application.php?job_Title=" . $_GET['job_Title']);

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_HR/respond_Application.php?applicant=" . $_GET['applicant'] . "&job_Title=" . $_GET['job_Title']);
        }
    }




    /* --- MESSAGES --- */
    // hr side
    if (isset($_GET['btn_Reply_Message'])) {

        if (!empty($_POST['message'])) {

            $recipient = $_GET['recipient'];
            $message = sanitizeInput($_POST['message']);
            $sender = $_SESSION['username'];
            

            $result = update_Application($pdo, $application_Status, $message, $applicant, $done_By);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_HR/messages.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_HR/reply_Messages.php?recipient=" . $msg['sender'] . "&msg_Replying_To=" . $msg['message']);
        }
    }

    // applicant side
    if (isset($_GET['btn_Send_Message'])) {

        if (!empty($_POST['message'])) {

            $recipient = $_GET['recipient'];
            $message = sanitizeInput($_POST['message']);
            $sender = $_SESSION['username'];
            

            $result = update_Application($pdo, $application_Status, $message, $applicant, $done_By);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_Applicant/messages.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_Applicant/reply_Messages.php?recipient=" . $msg['sender'] . "&msg_Replying_To=" . $msg['message']);
        }
    }
?>