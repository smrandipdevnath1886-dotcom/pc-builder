<?php
header('Content-Type: application/json');

// Database কানেকশন
$host = "localhost";
$user = "root";
$password = "";
$db = "pc_builder";

$con = mysqli_connect($host, $user, $password, $db);

if (!$con) {
    echo json_encode(['success' => false, 'message' => 'DB Error']);
    exit;
}

mysqli_set_charset($con, "utf8mb4");


$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'No data received']);
    exit;
}

$category = $data['category'] ?? '';
$name = $data['name'] ?? '';
$specs = $data['specs'] ?? '';
$price = $data['price'] ?? 0;

// Empty check
if (empty($category) || empty($name) || empty($specs) || empty($price)) {
    echo json_encode(['success' => false, 'message' => 'সব ফিল্ড ভরো!']);
    exit;
}

// Insert করো
$sql = "INSERT INTO components (category, name, specs, price) VALUES (?, ?, ?, ?)";
$stmt = $con->prepare($sql);
$stmt->bind_param("sssd", $category, $name, $specs, $price);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Database এ save হয়েছে!']);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$con->close();
?>