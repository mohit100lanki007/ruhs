<?php
// 1️⃣ Database Connection
include 'db_connect.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// 2️⃣ Receive Data from AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $rollno = $_POST['rollno'];
    $enrollno = $_POST['enrollno'];
    $resid = $_POST['resid'];

    // 3️⃣ Insert Data into Database
    $sql = "INSERT INTO result_logs (action, rollno, enrollno, resid, log_time) 
            VALUES ('$action', '$rollno', '$enrollno', '$resid', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Data Saved Successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// 4️⃣ Close Connection
$conn->close();
?>
