<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

// Create a PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

// Fetch company statistics with average salary
$stmt = $pdo->query("SELECT company, AVG(salary) AS averageSalary FROM employees GROUP BY company");
$companyStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return company statistics as JSON
echo json_encode($companyStats);
