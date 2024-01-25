<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

$data = json_decode(file_get_contents('php://input'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($data) {
        if (isset($data->id, $data->email)) {
            $id = $data->id;
            $email = $data->email;

            $query = $pdo->prepare("UPDATE employees SET email = ? WHERE id = ?");
            $query->execute([$email, $id]);

            echo json_encode(["message" => "Email updated successfully"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Invalid request. 'id' and 'email' fields are required."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Invalid request. Please provide valid JSON data."]);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
