<?php

    /* --- INPUT SECURITY --- */
    function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validatePassword($password) {
        if (strlen($password) > 8) { // longer than 8 char
            $hasLower = false;
            $hasUpper = false;
            $hasNumber = false;

            for ($i = 0; $i < strlen($password); $i++) {
                if (ctype_lower($password[$i])) { // has lower case
                    $hasLower = true; 
                }
                elseif (ctype_upper($password[$i])) { // has upper case
                    $hasUpper = true; 
                }
                elseif (ctype_digit($password[$i])) { // has numbers
                    $hasNumber = true;
                }
                
                if ($hasLower && $hasUpper && $hasNumber) {
                    return true; 
                }
            }
        } else {
            return false; 
        }
    }




    /* --- USER ACCOUNTS --- */
    // CHECK IF ALREADY REGISTERED
    function check_UserExists($pdo, $username) {
        $response = array();

        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$username])) {

            $userInfo = $stmt->fetch();

            if ($stmt->rowCount() > 0) { // user already in database
                $response = array(
                    "result" => true,
                    "status" => "200",
                    "userInfo" => $userInfo
                );
            } else { // green light for adding user
                $response = array(
                    "status" => "400",
                    "message" => "User not found in database"
                );
            }
        }

        return $response;
    }

    // REGISTER
    function register($pdo, $role, $username, $first_Name, $last_Name, $password) {

        $response = array();
        $check_User = check_UserExists($pdo, $username);

        
        if (!$check_User['result']) { // add user to database

            $sql = "INSERT INTO users (role, username, first_Name, last_Name, password) VALUES (?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$role, $username, $first_Name, $last_Name, $password])) {
                $response = array(
                    "status" => "200",
                    "message" => "User added"
                );
            }

        } else { // user already registered
            $response = array(
                "status" => "400",
                "message" => "User already registered"
            );
        }

        return $response;
    }

    // all hr
    function getAll_HR($pdo) {
        $sql = "SELECT * FROM users WHERE role = 'HR'";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute();
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // search hr
    function seach_HR($pdo, $searchQuery) {
        $sql = "SELECT * FROM users WHERE CONCAT(username, first_Name, last_Name, date_Registered) COLLATE utf8mb4_bin LIKE ? AND role = 'HR'";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute(["%" . $searchQuery . "%"]);
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // all applicants
    function getAll_Applicants($pdo) {
        $sql = "SELECT * FROM users WHERE role = 'Applicant'";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute();
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // search applicants
    function search_Applicant($pdo, $searchQuery) {
        $sql = "SELECT * FROM users WHERE CONCAT(username, first_Name, last_Name, date_Registered) COLLATE utf8mb4_bin LIKE ? AND role = 'Applicant'";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute(["%" . $searchQuery . "%"]);
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }




    /* --- ACTIVITY LOGS --- */
    // FETCH ALL
    function getAll_Logs($pdo) {
        $sql = "SELECT * FROM activity_logs";

        $query = $pdo->prepare($sql);

        if ($query->execute()) {
            return $query->fetchAll();
        }
    }

    // SEARCH
    function search_Logs($pdo, $searchQuery) {
        $sql = "SELECT * FROM activity_Logs WHERE CONCAT(operation, applicant_id, first_Name, last_Name, email, done_By, date_Committed) COLLATE utf8mb4_bin LIKE ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute(["%" . $searchQuery . "%"]);

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // LOG
    function log_Activity($pdo, $activity, $affected_Entity, $done_By, $user_Role) {
        $sql = "INSERT INTO activity_Logs (activity, affected_Entity, done_By, user_Role) VALUES (?,?,?,?)";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$activity, $affected_Entity, $done_By, $user_Role]);

        if ($executeQuery) {
            return true;
        }
    }




    /* --- JOB POSTS --- */
    // all jobs
    function getAll_Jobs($pdo) {
        $sql = "SELECT * FROM job_posts";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute();
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // specific jobs
    function getSepecific_Job($pdo, $job_id) {
        $sql = "SELECT * FROM job_posts WHERE job_id = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$job_id]);
    
        if ($executeQuery) {
            return $query->fetch();
        }
    }

    // search jobs
    function search_Jobs($pdo, $searchQuery) {
        $sql = "SELECT * FROM job_posts WHERE CONCAT(title, posted_By, date_Posted) COLLATE utf8mb4_bin LIKE ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute(["%" . $searchQuery . "%"]);
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // create
    function create_Job($pdo, $job_Title, $job_Desc, $posted_By) {
        $response = array();

        $sql = "INSERT INTO job_posts (title, description, posted_By) VALUES (?,?,?)";   

        $query = $pdo->prepare($sql);
        $job_Created = $query->execute([$job_Title, $job_Desc, $posted_By]);

        if ($job_Created) {

            $activity_Log = log_Activity($pdo, "Posted a Job", $job_Title, $posted_By, $_SESSION['role']);


            if ($activity_Log) {
                $response = array(
                    "status"=>"200",
                    "message"=>"Job Created!"
                );
            } else {
                $response = array(
                    "status"=>"400",
                    "message"=>"Activity failed to save."
                );
            }
        } else {
            $response = array(
                "status"=>"400",
                "message"=>"Something went wrong. Job could not be created."
            );
        }
        
        return $response;
    }

    // update
    function update_Job($pdo, $job_Title, $job_Desc, $job_id) {
        $response = array();

        $sql = "UPDATE job_posts
                SET
                    title = ?,
                    description = ?
                WHERE id = ?";   

        $query = $pdo->prepare($sql);
        $job_Updated = $query->execute([$job_Title, $job_Desc, $job_id]);

        if ($job_Updated) {

            $activity_Log = log_Activity($pdo, "Updated a Job", $job_Title, $_SESSION['username'], $_SESSION['role']);


            if ($activity_Log) {
                $response = array(
                    "status"=>"200",
                    "message"=>"Job Updated!"
                );
            } else {
                $response = array(
                    "status"=>"400",
                    "message"=>"Activity failed to save."
                );
            }
        } else {
            $response = array(
                "status"=>"400",
                "message"=>"Something went wrong. Job could not be updated."
            );
        }
        
        return $response;
    }

    // delete
    function delete_Job($pdo, $job_id) {

        $response = array();

        $log_Sql = "SELECT * FROM job_posts WHERE id = ?";
        
        $log_Query = $pdo->prepare($log_Sql);
        $log_Query->execute([$job_id]);

        $job_To_Delete = $log_Query->fetch();


        $activity_Log = log_Activity($pdo, "Deleted a job", $job_To_Delete['title'], $_SESSION['username'], $_SESSION['role']);


        if ($activity_Log) {

            $sql = "DELETE FROM job_posts WHERE id = ?";

            $query = $pdo->prepare($sql);
            $executeQuery = $query->execute([$job_id]);

            if ($executeQuery) {
                $response = array(
                    "status"=>"200",
                    "message"=>"Job Deleted!"
                );
            } else {
                $response = array(
                    "status"=>"400",
                    "message"=>"Activity could not be recorded."
                );
            }
            
        } else {
            $response = array(
                "status"=>"400",
                "message"=>"Something went wrong. Job could not be deleted."
            );
        }

        return $response;
    }




    /* --- APPLICATIONS --- */
    // hr side
    // >> hr gets all applications
    function HR_getAll_Applications($pdo, $job_Title) {
        $sql = "SELECT * FROM applications WHERE job_Title = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$job_Title]);
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // >> hr searches applications
    function HR_search_Applications($pdo, $searchQuery, $job_Title) {
        $sql = "SELECT * FROM job_posts WHERE CONCAT(applicant, status, date_Applied) COLLATE utf8mb4_bin LIKE ? AND job_Title = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute(["%" . $searchQuery . "%", $job_Title]);
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }


    // applicant side
    // >> applicant gets all of their applications
    function Applicant_getAll_Applications($pdo, $applicant) {
        $sql = "SELECT * FROM applications WHERE applicant = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$applicant]);
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // >> applicant searches their own applications
    function Applicant_search_Applications($pdo, $searchQuery, $applicant) {
        $sql = "SELECT * FROM job_posts WHERE CONCAT(job_Title, status, date_Applied) COLLATE utf8mb4_bin LIKE ? AND applicant = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute(["%" . $searchQuery . "%", $applicant]);
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }


    // create (applicants apply to jobs)
    function create_Application($pdo, $job_Title, $applicant, $justification, $resume) {
        $response = array();

        $sql = "INSERT INTO applications (job_Title, applicant, justification, resume) VALUES (?,?,?,?)";   

        $query = $pdo->prepare($sql);
        $applied_To_Job = $query->execute([$job_Title, $applicant, $justification, $resume]);

        if ($applied_To_Job) {

            $activity_Log = log_Activity($pdo, "Applied to Job", $job_Title, $applicant, $_SESSION['role']);


            if ($activity_Log) {
                $response = array(
                    "status"=>"200",
                    "message"=>"Applied to job!"
                );
            } else {
                $response = array(
                    "status"=>"400",
                    "message"=>"Activity failed to save."
                );
            }
        } else {
            $response = array(
                "status"=>"400",
                "message"=>"Something went wrong. Could not apply to job."
            );
        }
        
        return $response;
    }

    // update (hr accepts or denies applications)
    function update_Application($pdo, $status, $remarks, $applicant, $done_By) {
        $response = array();

        $sql = "UPDATE applications
                SET
                    status = ?,
                    remarks = ?
                WHERE applicant = ?";   

        $query = $pdo->prepare($sql);
        $application_Updated = $query->execute([$status, $remarks, $applicant]);

        if ($application_Updated) {

            if ($status == 'Accepted') {
                $activity_Log = log_Activity($pdo, "Accepted Applicant", $applicant, $done_By, $_SESSION['role']);
            } else {
                $activity_Log = log_Activity($pdo, "Rejected Applicant", $applicant, $done_By, $_SESSION['role']);
            }


            if ($activity_Log) {
                $response = array(
                    "status"=>"200",
                    "message"=>"Application Updated!"
                );
            } else {
                $response = array(
                    "status"=>"400",
                    "message"=>"Activity failed to save."
                );
            }
        } else {
            $response = array(
                "status"=>"400",
                "message"=>"Something went wrong. Application could not be updated."
            );
        }
        
        return $response;
    }




    /* --- MESSAGES --- */
    // get all messages received
    function getAll_Messages($pdo, $user) {
        $sql = "SELECT * FROM messages WHERE recipient = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$user]);
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // search messages received
    function search_Messages($pdo, $searchQuery, $user) {
        $sql = "SELECT * FROM messages WHERE CONCAT(sender, message, date_Sent) COLLATE utf8mb4_bin LIKE ? AND recipient = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute(["%" . $searchQuery . "%", $user]);
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // create (send message)
    function send_Message($pdo, $sender, $recipient, $message) {
        $response = array();

        $sql = "INSERT INTO messages (sender, recipient, message) VALUES (?,?,?)";   

        $query = $pdo->prepare($sql);
        $message_Sent = $query->execute([$sender, $recipient, $message]);

        if ($message_Sent) {

            $activity_Log = log_Activity($pdo, "Sent a message", $recipient, $sender, $_SESSION['role']);


            if ($activity_Log) {
                $response = array(
                    "status"=>"200",
                    "message"=>"Message sent!"
                );
            } else {
                $response = array(
                    "status"=>"400",
                    "message"=>"Activity failed to save."
                );
            }
        } else {
            $response = array(
                "status"=>"400",
                "message"=>"Something went wrong. Message could not be sent."
            );
        }
        
        return $response;
    }
?>