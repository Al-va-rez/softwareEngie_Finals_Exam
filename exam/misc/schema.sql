CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('HR', 'Applicant', 'Admin') NOT NULL,
    username VARCHAR(50) NOT NULL,
    first_Name VARCHAR(50) NOT NULL,
    last_Name VARCHAR(50) NOT NULL,
    password TEXT NOT NULL,
    date_Registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE job_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    posted_By VARCHAR(50) NOT NULL,
    date_Posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_Title VARCHAR(50) NOT NULL,
    job_Desc TEXT NOT NULL,
    applicant VARCHAR(50) NOT NULL,
    status ENUM('Pending', 'Accepted', 'Rejected') NOT NULL DEFAULT 'Pending',
    remarks TEXT DEFAULT 'Application still pending',
    resume VARCHAR(255) NOT NULL,
    date_Applied TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender VARCHAR(50) NOT NULL,
    recipient VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    date_Sent TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE activity_Logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
	activity VARCHAR(255),
    done_By VARCHAR(255),
    user_Role ENUM('HR', 'Applicant', 'Admin') NOT NULL,
	date_Committed TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);