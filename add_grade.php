<?php
include 'config.php';
session_start();

if ($_SESSION['role'] != 'instructor') {
    header("Location: login.php");
    exit();
}

$message = "";
$messageType = "";

// Fetch courses taught by the instructor
$sql_courses = "SELECT id, name FROM courses WHERE instructor_id = {$_SESSION['userid']}";
$result_courses = $conn->query($sql_courses);
$course_options = "";
if ($result_courses->num_rows > 0) {
    while ($row_course = $result_courses->fetch_assoc()) {
        $course_options .= "<option value='" . $row_course['id'] . "'>" . $row_course['name'] . "</option>";
    }
} else {
    $message = "No courses found.";
}

// Fetch students for the dropdown menu
$sql_students = "SELECT id, username FROM users WHERE role = 'student'";
$result_students = $conn->query($sql_students);
$student_options = "";
if ($result_students->num_rows > 0) {
    while ($row_student = $result_students->fetch_assoc()) {
        $student_options .= "<option value='" . $row_student['id'] . "'>" . $row_student['username'] . "</option>";
    }
} else {
    $message = "No students found.";
    $messageType = "error";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $grade = $_POST['grade'];
    $course_id = $_POST['course_id'];

    // Check if the student already has a grade for the course
    $check_existing_grade_sql = "SELECT id FROM grades WHERE student_id = $student_id AND course_id = $course_id";
    $result_check_existing_grade = $conn->query($check_existing_grade_sql);

    if ($result_check_existing_grade->num_rows > 0) {
        // Grade already exists, display an error message
        $message = "Error: This student already has a grade for this course.";
        $messageType = "error";
    } else {
        // Insert the grade into the database
        $sql = "INSERT INTO grades (student_id, course_id, course, grade) VALUES ('$student_id', '$course_id', (SELECT name FROM courses WHERE id = '$course_id'), '$grade')";

        if ($conn->query($sql) === TRUE) {
            $message = "Grade added successfully!";
            $messageType = "success";
        } else {
            $message = "Error adding grade: " . $conn->error;
            $messageType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add Grade</h2>

        <?php if (!empty($message)) : ?>
            <p class="<?php echo isset($messageType) ? $messageType : ''; ?>"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="post">
            Student:
            <select name="student_id" required>
                <?php echo $student_options; ?>
            </select><br>
            Course:
            <select name="course_id" required>
                <?php echo $course_options; ?>
            </select><br>
            Grade: <input type="number" max="10" min="5" name="grade" required><br>
            <input type="submit" value="Add Grade">
            <a href="logout.php">Logout</a>
        </form>
    </div>
</body>

</html>