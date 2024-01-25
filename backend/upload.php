<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// Database configuration
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

// Create a PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

// File upload handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadedFile = $_FILES['file'];

    if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
        $fileName = $uploadedFile['name'];
        $filePath = __DIR__ . '/uploads/' . $fileName;

        // Move the uploaded file to the target directory
        move_uploaded_file($uploadedFile['tmp_name'], $filePath);

        // CSV parsing and database insertion
        $csvData = array_map('str_getcsv', file($filePath));
        $headers = array_shift($csvData); // Extract headers

        foreach ($csvData as $row) {
            $data = array_combine($headers, $row);

            // Insert data into MySQL
            $stmt = $pdo->prepare("
                INSERT INTO your_table_name
                    (companyName, employeeName, employeeEmail, salary)
                VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['Company Name'], $data['Employee Name'], $data['Employee Email'], $data['Salary']]);
        }

        echo json_encode(['message' => 'File uploaded and data inserted successfully']);
    } else {
        echo json_encode(['error' => 'Error uploading file']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
