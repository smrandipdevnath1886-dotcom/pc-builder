<?php
session_start();
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$password = "";
$db = "pcbuilder";

$con = mysqli_connect($host, $user, $password, $db);

if (!$con) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

mysqli_set_charset($con, "utf8mb4");

$data = json_decode(file_get_contents("php://input"), true);

$email = mysqli_real_escape_string($con, $data['email'] ?? '');
$password = mysqli_real_escape_string($con, $data['password'] ?? '');

if (!$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'Email এবং Password দাও!']);
    exit;
}

// Check user in database
$sql = "SELECT id, username, password FROM users WHERE email = '$email'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // Check password
    if ($password === $row['password']) {
        // Login successful - set session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $email;
        
        echo json_encode(['success' => true, 'message' => 'Login সফল! স্বাগতম ' . $row['username']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Password ভুল!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'এই Email এ কোনো ইউজার নেই!']);
}

mysqli_close($con);
?>