<?php
session_start();

// Connect to database
$conn = new mysqli("localhost", "root", "", "codia_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted
if(!isset($_POST['username'], $_POST['password'])){
    $_SESSION['error'] = "Please fill in all fields.";
    header("Location: index.php");
    exit();
}

$user = trim($_POST['username']);
$password = trim($_POST['password']);

// Check user in users table
$stmt = $conn->prepare("SELECT id, first, last, username, password, role FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $user, $user);
$stmt->execute();
$result = $stmt->get_result();

$error = "";

if ($result->num_rows === 1) {

    $row = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $row['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['first'] = $row['first'];
        $_SESSION['role'] = $row['role'];

        // INSERT login record into login_logs
        $log = $conn->prepare("INSERT INTO login_logs (username, login_time) VALUES (?, NOW())");
        $log->bind_param("s", $row['username']);
        $log->execute();

        // Redirect based on role
        if($row['role'] == "admin"){
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }

        exit();

    } else {
        $error = "Incorrect password.";
    }

} else {
    $error = "Account not found.";
}

$stmt->close();
$conn->close();

// Send error back to login page
if ($error !== "") {
    $_SESSION['error'] = $error;
    header("Location: index.php");
    exit();
}
?>