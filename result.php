<?php
// Database connection
include 'db_connect.php';

// Get user input
$roll_no = $_POST['roll_no'];
$enrollment_year = $_POST['enrollment_year'];
$enrollment_no = $_POST['enrollment_no'];

// सुरक्षित SQL क्वेरी
$sql = "SELECT * FROM student_results WHERE roll_no = ? AND enrollment_year = ? AND enrollment_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $roll_no, $enrollment_year, $enrollment_no);
$stmt->execute();
$result = $stmt->get_result();

// Query to fetch student result
$sql = "SELECT * FROM student_results WHERE roll_no='$roll_no' AND enrollment_year='$enrollment_year' AND enrollment_no='$enrollment_no'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Result</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
            }
            table {
                width: 80%;
                margin: auto;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid black;
                padding: 10px;
                text-align: center;
            }
            th {
                background: #ddd;
            }
        </style>
    </head>
    <body>
        <h2>RAJASTHAN UNIVERSITY OF HEALTH SCIENCES, JAIPUR</h2>
        <h3>D. PHARMACY (New Scheme) PART-I (MAIN) EXAM. JAN-2024</h3>

        <table>
            <tr>
                <th>Student Name</th>
                <td><?php echo $row['student_name']; ?></td>
                <th>Roll Number</th>
                <td><?php echo $row['roll_no']; ?></td>
            </tr>
            <tr>
                <th>Father's Name</th>
                <td><?php echo $row['father_name']; ?></td>
                <th>Enrollment No</th>
                <td><?php echo $row['enrollment_no']; ?></td>
            </tr>
            <tr>
                <th>Mother's Name</th>
                <td><?php echo $row['mother_name']; ?></td>
                <th>Attempt</th>
                <td><?php echo $row['attempt']; ?></td>
            </tr>
        </table>

        <br>
        <table>
            <tr>
                <th>Subject Code</th>
                <th>Subject</th>
                <th>Theory</th>
                <th>Internal</th>
                <th>Theory Total</th>
                <th>Practical Ext.</th>
                <th>Practical Int.</th>
                <th>Practical Total</th>
                <th>Total</th>
            </tr>
            <?php
            // Fetch subject-wise marks
            $sql_marks = "SELECT * FROM student_marks WHERE roll_no='$roll_no'";
            $marks_result = $conn->query($sql_marks);

            while ($marks = $marks_result->fetch_assoc()) {
                echo "<tr>
                        <td>{$marks['subject_code']}</td>
                        <td>{$marks['subject_name']}</td>
                        <td>{$marks['theory']}</td>
                        <td>{$marks['internal']}</td>
                        <td>{$marks['theory_total']}</td>
                        <td>{$marks['prac_ext']}</td>
                        <td>{$marks['prac_int']}</td>
                        <td>{$marks['practical_total']}</td>
                        <td>{$marks['final_total']}</td>
                      </tr>";
            }
            ?>
        </table>

        <h3>Result: <?php echo $row['result']; ?></h3>
        <h3>Total Marks: <?php echo $row['total_marks']; ?>/1000</h3>

    </body>
    </html>
    <?php
} else {
    echo "<script>alert('No Record Found!'); window.location.href='index.html';</script>";
}

$conn->close();
?>
