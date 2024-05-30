<?php
include 'config.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="post">
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            Role:
            <select name="role">
                <option value="instructor">Instructor</option>
                <option value="student">Student</option>
            </select><br>
            <input type="submit" value="Register">
            <a href="login.php">Login</a>

        </form>
    </div>
</body>

</html>