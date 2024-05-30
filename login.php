<?php
include 'config.php';
session_start();

if (isset($_SESSION['userid'])) {
    header("Location: dashboard.php");
    exit();
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password, role FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['userid'] = $row['id'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            header("Location: add_grade.php");
        } else {
            $message = "Invalid password.";
            $messageType = "error";
        }
    } else {
        $message = "No user found.";
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
        <h2>Login</h2>

        <?php if (!empty($message)) : ?>
            <p class="error"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="post">
            Username: <input type="text" name="username" required><br>
            Password: <input type="password" name="password" required><br>
            <input type="submit" value="Login">
            <a href="register.php">Register</a>
        </form>
    </div>
</body>

</html>