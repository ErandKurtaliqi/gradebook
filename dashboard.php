<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is a student
if ($_SESSION['role'] != 'student') {
    header("Location: login.php"); // Redirect to appropriate page for non-students
    exit();
}

// Fetch the student's grades
$student_id = $_SESSION['userid'];
$sql_grades = "SELECT courses.name AS course_name, grades.grade 
               FROM grades 
               INNER JOIN courses ON grades.course_id = courses.id 
               WHERE grades.student_id = $student_id";
$result_grades = $conn->query($sql_grades);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .failed-grade {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        <h3>Your Grades</h3>

        <?php if ($result_grades->num_rows > 0) : ?>
            <table>
                <tr>
                    <th>Course</th>
                    <th>Grade</th>
                </tr>
                <?php while ($row = $result_grades->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                        <td class="<?php echo $row['grade'] == 5 ? 'failed-grade' : ''; ?>">
                            <?php echo htmlspecialchars($row['grade']); ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else : ?>
            <p style="color: red;">No grades found.</p>
        <?php endif; ?>

        <a href="logout.php">Logout</a>
    </div>
</body>

</html>