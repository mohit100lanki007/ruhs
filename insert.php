<?php
include 'db_connect.php'; // Database connection file

// ✅ Function to Clean Input Without Changing Values
function cleanInput($value) {
    return trim($value);  // Remove spaces but keep original value
}

if (isset($_POST['submit'])) {
    // Student Details
    $roll_no = cleanInput($_POST['roll_no']);
    $student_name = cleanInput($_POST['student_name']);
    $father_name = cleanInput($_POST['father_name']);
    $mother_name = cleanInput($_POST['mother_name']);
    $enrollment_no = cleanInput($_POST['enrollment_no']);
    $enrollment_year = cleanInput($_POST['enrollment_year']);
    $attempt = cleanInput($_POST['attempt']);
    $total_marks = cleanInput($_POST['total_marks']);
    $result = cleanInput($_POST['result']);

    // ✅ Step 1: Insert Student Details
    $stmt1 = $conn->prepare("INSERT INTO student_results (roll_no, student_name, father_name, mother_name, enrollment_no, enrollment_year, attempt, total_marks, result) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt1) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt1->bind_param("sssssssss", $roll_no, $student_name, $father_name, $mother_name, $enrollment_no, $enrollment_year, $attempt, $total_marks, $result);
    $stmt1->execute();
    $stmt1->close();

    // ✅ Step 2: Insert Marks for Each Subject
    $subject_codes = $_POST['subject_code'];
    $subject_names = $_POST['subject_name'];
    $theories = $_POST['theory'];
    $internals = $_POST['internal'];
    $theory_totals = $_POST['theory_total'];
    $prac_exts = $_POST['prac_ext'];
    $prac_ints = $_POST['prac_int'];
    $practical_totals = $_POST['practical_total'];
    $final_totals = $_POST['final_total'];

    $stmt2 = $conn->prepare("INSERT INTO student_marks (roll_no, subject_code, subject_name, theory, internal, theory_total, prac_ext, prac_int, practical_total, final_total) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt2) {
        die("Prepare failed: " . $conn->error);
    }

    for ($i = 0; $i < count($subject_codes); $i++) {
        $theory = cleanInput($theories[$i]);
        $internal = cleanInput($internals[$i]);
        $theory_total = cleanInput($theory_totals[$i]);
        $prac_ext = cleanInput($prac_exts[$i]);
        $prac_int = cleanInput($prac_ints[$i]);
        $practical_total = cleanInput($practical_totals[$i]);
        $final_total = cleanInput($final_totals[$i]);

        // ✅ Use "s" (string) so that all values remain as they are
        $stmt2->bind_param("ssssssssss", $roll_no, $subject_codes[$i], $subject_names[$i], 
            $theory, $internal, $theory_total, 
            $prac_ext, $prac_int, $practical_total, $final_total);
        $stmt2->execute();
    }

    $stmt2->close();
    $conn->close();

    // ✅ Success Message
    echo "<script>alert('All Data Inserted Successfully!'); window.location.href='insert.html';</script>";
}
?>
