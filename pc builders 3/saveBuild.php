<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db = "pcbuilder";

$con = mysqli_connect($host, $user, $password, $db);

if (!$con) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit;
}

mysqli_set_charset($con, "utf8mb4");

// Get data from request
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No data received']);
    exit;
}

$build_name = mysqli_real_escape_string($con, $data['build_name'] ?? 'My Build');
$cpu_name = mysqli_real_escape_string($con, $data['cpu_name'] ?? '');
$gpu_name = mysqli_real_escape_string($con, $data['gpu_name'] ?? '');
$ram_name = mysqli_real_escape_string($con, $data['ram_name'] ?? '');
$storage_name = mysqli_real_escape_string($con, $data['storage_name'] ?? '');
$psu_name = mysqli_real_escape_string($con, $data['psu_name'] ?? '');
$cooler_name = mysqli_real_escape_string($con, $data['cooler_name'] ?? '');
$total_price = floatval($data['total_price'] ?? 0);

// Get user_id if logged in
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Validation
if (empty($cpu_name) || empty($gpu_name) || empty($ram_name) || empty($storage_name) || empty($psu_name) || empty($cooler_name)) {
    echo json_encode(['success' => false, 'message' => 'সব কম্পোনেন্ট পূরণ করো!']);
    exit;
}

// Insert into database
$sql = "INSERT INTO user_builds (user_id, build_name, cpu_name, gpu_name, ram_name, storage_name, psu_name, cooler_name, total_price) 
        VALUES ($user_id, '$build_name', '$cpu_name', '$gpu_name', '$ram_name', '$storage_name', '$psu_name', '$cooler_name', $total_price)";

if (mysqli_query($con, $sql)) {
    $build_id = mysqli_insert_id($con);
    echo json_encode([
        'success' => true, 
        'message' => '✅ Build সফলভাবে সংরক্ষিত হয়েছে!',
        'build_id' => $build_id
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . mysqli_error($con)]);
}

mysqli_close($con);
?>