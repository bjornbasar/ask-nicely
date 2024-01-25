<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        $stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
        $stmt->execute([$id]);
    
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
    
        echo json_encode($record);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM employees");
        $stmt->execute();
    
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        echo json_encode($records);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
