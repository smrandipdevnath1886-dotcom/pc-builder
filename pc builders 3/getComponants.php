<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$password = "";
$db = "pc_builder";

$con = mysqli_connect($host, $user, $password, $db);

if (!$con) {
    echo json_encode([
        'CPU' => [],
        'GPU' => [],
        'RAM' => [],
        'Storage' => [],
        'PSU' => [],
        'Cooler' => []
    ]);
    exit;
}

mysqli_set_charset($con, "utf8mb4");

$sql = "SELECT id, category, name, specs, price FROM components ORDER BY category, name";
$result = mysqli_query($con, $sql);

$components = [
    'CPU' => [],
    'GPU' => [],
    'RAM' => [],
    'Storage' => [],
    'PSU' => [],
    'Cooler' => []
];

if ($result) {
    while($row = mysqli_fetch_assoc($result)) {
        $category = $row['category'];
        if (isset($components[$category])) {
            $components[$category][] = [
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'specs' => $row['specs'],
                'price' => (float)$row['price']
            ];
        }
    }
}

echo json_encode($components);
mysqli_close($con);
?>