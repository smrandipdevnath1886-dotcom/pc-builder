<?php
header('Content-Type: application/json');
include 'connect.php';

$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';

if (empty($category)) {
    echo json_encode(['error' => 'Category not specified']);
    exit;
}


$products = array(
    'CPU' => array(
        array('id' => 1, 'name' => 'Intel Core i9-13900K', 'price' => 589, 'specs' => '24 cores, 5.8 GHz'),
        array('id' => 2, 'name' => 'AMD Ryzen 9 7950X', 'price' => 549, 'specs' => '16 cores, 5.7 GHz'),
        array('id' => 3, 'name' => 'Intel Core i7-13700K', 'price' => 419, 'specs' => '16 cores, 5.4 GHz')
    ),
    'GPU' => array(
        array('id' => 4, 'name' => 'NVIDIA RTX 4090', 'price' => 1599, 'specs' => '24GB GDDR6X'),
        array('id' => 5, 'name' => 'NVIDIA RTX 4080', 'price' => 1199, 'specs' => '16GB GDDR6X'),
        array('id' => 6, 'name' => 'AMD RX 7900 XTX', 'price' => 899, 'specs' => '24GB GDDR6')
    ),
    'RAM' => array(
        array('id' => 7, 'name' => 'Corsair Vengeance RGB Pro 32GB', 'price' => 149, 'specs' => 'DDR5, 5600MHz'),
        array('id' => 8, 'name' => 'G.Skill Trident Z5 32GB', 'price' => 159, 'specs' => 'DDR5, 6000MHz'),
        array('id' => 9, 'name' => 'Kingston Fury Beast 32GB', 'price' => 129, 'specs' => 'DDR5, 5600MHz')
    ),
    'Storage' => array(
        array('id' => 10, 'name' => 'Samsung 990 Pro 2TB', 'price' => 199, 'specs' => 'NVMe SSD, PCIe 4.0'),
        array('id' => 11, 'name' => 'Corsair MP600 CORE XT 2TB', 'price' => 149, 'specs' => 'NVMe SSD, PCIe 4.0'),
        array('id' => 12, 'name' => 'WD Black SN850X 2TB', 'price' => 179, 'specs' => 'NVMe SSD, PCIe 4.0')
    ),
    'PSU' => array(
        array('id' => 13, 'name' => 'Corsair RM1000e 1000W', 'price' => 179, 'specs' => 'Gold, Modular'),
        array('id' => 14, 'name' => 'EVGA SuperNOVA 850W', 'price' => 119, 'specs' => 'Gold, Modular'),
        array('id' => 15, 'name' => 'Seasonic FOCUS 850W', 'price' => 139, 'specs' => 'Gold, Modular')
    ),
    'Cooler' => array(
        array('id' => 16, 'name' => 'Noctua NH-D15', 'price' => 99, 'specs' => 'Air Cooler, 140mm'),
        array('id' => 17, 'name' => 'Corsair H150i Elite', 'price' => 189, 'specs' => 'Liquid Cooler, 360mm'),
        array('id' => 18, 'name' => 'ASUS ROG Strix LC 360', 'price' => 249, 'specs' => 'Liquid Cooler, 360mm')
    )
);

if (isset($products[$category])) {
    echo json_encode($products[$category]);
} else {
    echo json_encode(array());
}
?>