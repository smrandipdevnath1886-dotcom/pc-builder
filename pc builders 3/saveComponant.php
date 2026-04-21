<?php
header('Content-Type: application/json');

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db = "pc_builder";  

$con = mysqli_connect($host, $user, $password, $db);

if (!$con) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . mysqli_connect_error()
    ]);
    exit;
}

mysqli_set_charset($con, "utf8mb4");

// Input data নিো
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($data['category']) || !isset($data['name']) || !isset($data['specs']) || !isset($data['price'])) {
    echo json_encode([
        'success' => false,
        'message' => 'সব ফিল্ড প্রয়োজন!'
    ]);
    exit;
}

$category = trim($data['category']);
$name = trim($data['name']);
$specs = trim($data['specs']);
$price = floatval($data['price']);

if (empty($category) || empty($name) || empty($specs) || $price <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'সব ফিল্ড সঠিকভাবে পূরণ করো!'
    ]);
    exit;
}

// Check if component already exists
$check_sql = "SELECT id FROM components WHERE LOWER(name) = LOWER(?) AND LOWER(category) = LOWER(?)";
$check_stmt = $con->prepare($check_sql);

if (!$check_stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Query error: ' . $con->error
    ]);
    exit;
}

$check_stmt->bind_param("ss", $name, $category);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        'success' => false,
        'message' => 'এই component ইতিমধ্যে আছে!'
    ]);
    $check_stmt->close();
    exit;
}
$check_stmt->close();

// Insert new component
$insert_sql = "INSERT INTO components (category, name, specs, price) VALUES (?, ?, ?, ?)";
$insert_stmt = $con->prepare($insert_sql);

if (!$insert_stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Insert error: ' . $con->error
    ]);
    exit;
}

$insert_stmt->bind_param("sssd", $category, $name, $specs, $price);

if ($insert_stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Component সফলভাবে যোগ হয়েছে'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Insert failed: ' . $insert_stmt->error
    ]);
}

$insert_stmt->close();
mysqli_close($con);
?>