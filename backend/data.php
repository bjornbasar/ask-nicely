<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

// Create a PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve data from MySQL
    $stmt = $pdo->query("SELECT * FROM your_table_name");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
