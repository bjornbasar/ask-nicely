<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadedFile = $_FILES['file'];

    $fileType = strtolower(pathinfo($uploadedFile['name'], PATHINFO_EXTENSION));
    if ($fileType !== 'csv') {
        http_response_code(400);
        echo json_encode(["error" => "Invalid file type. Please upload a CSV file."]);
        exit();
    }

    if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
        $fileName = $uploadedFile['name'];
        $filePath = __DIR__ . '/uploads/' . $fileName;

        move_uploaded_file($uploadedFile['tmp_name'], $filePath);

        $csvData = array_map('str_getcsv', file($filePath));
        $headers = array_shift($csvData);
        $expectedHeaders = ["Company Name", "Employee Name", "Employee Email", "Salary"];

        if ($headers === false || $headers !== $expectedHeaders) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid CSV headers. Please ensure the headers match the expected format."]);
            exit();
        }

        foreach ($csvData as $row) {
            $data = array_combine($headers, $row);

            $query = $pdo->prepare("
                INSERT INTO employees
                    (company, name, email, salary)
                VALUES (?, ?, ?, ?)");
            $query->execute([$data['Company Name'], $data['Employee Name'], $data['Email Address'], $data['Salary']]);
        }

        echo json_encode(['message' => 'File uploaded and data inserted successfully']);
    } else {
        echo json_encode(['error' => 'Error uploading file']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
