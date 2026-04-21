<?php
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

$username = mysqli_real_escape_string($con, $data['username'] ?? '');
$email = mysqli_real_escape_string($con, $data['email'] ?? '');
$password = mysqli_real_escape_string($con, $data['password'] ?? '');

// Validation
if (!$username || !$email || !$password) {
    echo json_encode(['success' => false, 'message' => 'সব ফিল্ড পূরণ করো!']);
    exit;
}

if (strlen($username) < 3) {
    echo json_encode(['success' => false, 'message' => 'Username কমপক্ষে 3 অক্ষর হতে হবে!']);
    exit;
}

if (strlen($password) < 5) {
    echo json_encode(['success' => false, 'message' => 'Password কমপক্ষে 5 অক্ষর হতে হবে!']);
    exit;
}

// Check if email already exists
$check_sql = "SELECT id FROM users WHERE email = '$email'";
$result = mysqli_query($con, $check_sql);

if (mysqli_num_rows($result) > 0) {
    echo json_encode(['success' => false, 'message' => 'এই Email ইতিমধ্যে ব্যবহৃত হয়েছে!']);
    exit;
}

// Check if username already exists
$check_sql2 = "SELECT id FROM users WHERE username = '$username'";
$result2 = mysqli_query($con, $check_sql2);

if (mysqli_num_rows($result2) > 0) {
    echo json_encode(['success' => false, 'message' => 'এই Username ইতিমধ্যে নেওয়া হয়েছে!']);
    exit;
}

// Insert new user
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

if (mysqli_query($con, $sql)) {
    echo json_encode(['success' => true, 'message' => 'অ্যাকাউন্ট তৈরি সফল! এখন login করো।']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($con)]);
}

mysqli_close($con);
?>