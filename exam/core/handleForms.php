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
    if (isset($_POST['btn_Create_Job'])) {

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
    if (isset($_POST['btn_Edit_Job'])) {

        if (!empty($_POST['job_Title']) && !empty($_POST['job_Desc'])) {

            $job_Title = sanitizeInput($_POST['job_Title']);
            $job_Desc = sanitizeInput($_POST['job_Desc']);
            $job_id = $_GET['job_id'];


            $result = update_Job($pdo, $job_Title, $job_Desc, $job_id);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_HR/dashboard.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_HR/edit.php?job_id=" . $_GET['job_id']);
        }
    }

    // delete
    if (isset($_POST['btn_Delete_Job'])) {

        $job_id = $_GET['job_id'];

        $result = delete_Job($pdo, $job_id);

        $_SESSION['status'] = $result['status'];
        $_SESSION['message'] = $result['message'];
        header("Location: ../role_HR/dashboard.php");
    }




    /* --- APPLICATIONS --- */
    // create (applicants apply to jobs)
    if (isset($_POST['btn_Apply_Job'])) {

        if (!empty($_POST['applicant_Quali'])) {

            $job_Title = $_GET['job_Title'];
            $justification = sanitizeInput($_POST['applicant_Quali']);
            $resume = $_FILES['resume'];
            $applicant = $_SESSION['username'];

            $resume_name = time() . "_" . $resume['name'];
            move_uploaded_file($resume['tmp_name'], "../uploads/$resume_name");


            $result = create_Application($pdo, $job_Title, $applicant, $justification, $resume_name);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_Applicant/dashboard.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_Applicant/create_Job.php?job_Title=" . $_GET['job_Title']);
        }
    }

    // update (hr accepts or denies applications)
    if (isset($_POST['btn_Respond_Application'])) {

        if (!empty($_POST['message'])) {

            $application_Status = $_POST['status'];
            $message = sanitizeInput($_POST['message']);
            $applicant = $_GET['applicant'];
            $done_By = $_SESSION['username'];
            

            $result = update_Application($pdo, $application_Status, $message, $applicant, $done_By);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_HR/view_Applications.php?job_Title=" . $_GET['job_Title']);

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_HR/respond_Applications.php?applicant=" . $_GET['applicant'] . "&job_Title=" . $_GET['job_Title']);
        }
    }




    /* --- MESSAGES --- */
    // hr side
    // >> create and send new message
    if (isset($_POST['btn_Message_Applicant'])) {

        if (!empty($_POST['message'])) {

            $subject = $_POST['subject'];
            $recipient = $_POST['recipient'];
            $message = sanitizeInput($_POST['message']);
            $sender = $_SESSION['username'];
            

            $result = send_Message($pdo, $sender, $recipient, $subject, $message);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_HR/messages_Received.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_HR/create_Message.php");
        }
    }

    // >> reply to message received
    if (isset($_POST['btn_Reply_Applicant'])) {

        if (!empty($_POST['reply'])) {

            $subject = $_GET['msg_Subject'];
            $recipient = $_GET['recipient'];
            $original_Message = $_GET['msg_Replying_To'];
            $reply = "RE: " . sanitizeInput($_POST['reply']);
            $sender = $_SESSION['username'];
            

            $result = send_Reply($pdo, $sender, $recipient, $original_Message, $reply);
            $result = send_Message($pdo, $sender, $recipient, $subject, $reply);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_HR/messages_Received.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_HR/reply_Messages.php?recipient=" . $_GET['recipient'] . "&msg_Replying_To=" . $_GET['msg_Replying_To'] . "&msg_Subject=" . $_GET['msg_Subject']);
        }
    }

    // delete message
    if (isset($_POST['btn_Delete_HR_Message'])) {

        $msg_id = $_GET['msg_id'];

        $result = delete_Message($pdo, $msg_id);

        $_SESSION['status'] = $result['status'];
        $_SESSION['message'] = $result['message'];
        header("Location: ../role_HR/messages_Received.php");
    }

    // delete reply
    if (isset($_POST['btn_Delete_HR_Reply'])) {

        $reply_id = $_GET['reply_id'];

        $result = delete_Reply($pdo, $reply_id);

        $_SESSION['status'] = $result['status'];
        $_SESSION['message'] = $result['message'];
        header("Location: ../role_HR/messages_Sent.php");
    }


    // applicant side
    // >> create and send new message
    if (isset($_POST['btn_Message_HR'])) {

        if (!empty($_POST['message'])) {

            $subject = $_POST['subject'];
            $recipient = $_POST['recipient'];
            $message = sanitizeInput($_POST['message']);
            $sender = $_SESSION['username'];
            

            $result = send_Message($pdo, $sender, $recipient, $subject, $message);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_Applicant/messages_Received.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_Applicant/create_Message.php");
        }
    }

    // >> reply to message received
    if (isset($_POST['btn_Reply_HR'])) {

        if (!empty($_POST['reply'])) {

            $subject = $_GET['msg_Subject'];
            $recipient = $_GET['recipient'];
            $original_Message = $_GET['msg_Replying_To'];
            $reply =  "RE: " . sanitizeInput($_POST['reply']);
            $sender = $_SESSION['username'];
            

            $result = send_Reply($pdo, $sender, $recipient, $original_Message, $reply);
            $result = send_Message($pdo, $sender, $recipient, $subject, $reply);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../role_Applicant/messages_Received.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../role_Applicant/reply_Messages.php?recipient=" . $_GET['recipient'] . "&msg_Replying_To=" . $_GET['msg_Replying_To'] . "&msg_Subject=" . $_GET['msg_Subject']);
        }
    }

    // delete message
    if (isset($_POST['btn_Delete_Applicant_Message'])) {

        $msg_id = $_GET['msg_id'];

        $result = delete_Message($pdo, $msg_id);

        $_SESSION['status'] = $result['status'];
        $_SESSION['message'] = $result['message'];
        header("Location: ../role_Applicant/messages_Received.php");
    }

    // delete reply
    if (isset($_POST['btn_Delete_Applicant_Reply'])) {

        $reply_id = $_GET['reply_id'];

        $result = delete_Reply($pdo, $reply_id);

        $_SESSION['status'] = $result['status'];
        $_SESSION['message'] = $result['message'];
        header("Location: ../role_Applicant/messages_Sent.php");
    }
    
?>