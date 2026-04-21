<?php
header('Content-Type: application/json');
session_start();

$host = "localhost";
$user = "root";
$password = "";
$db = "test";

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login']);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT id, build_name, total_price, created_at FROM user_builds WHERE user_id = $user_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$builds = [];
while($row = mysqli_fetch_assoc($result)) {
    $builds[] = $row;
}

echo json_encode(['success' => true, 'builds' => $builds]);
mysqli_close($conn);
?>