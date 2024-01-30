<?php

class Router
{
    public function handleRequest()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if (!in_array($method, ['GET','POST','OPTIONS'])) {
            echo '405 Method not allowed';
        }

        $employeeController = new EmployeeController();
        if ($method === 'GET') {
            if (preg_match('/\/employees\/?(\d?)/', $uri, $matches)) {
                $data = $employeeController->index($matches[1]);
                echo json_encode($data);
            } elseif ($uri === '/average-salary') {
                $data = $employeeController->averageSalaryByCompany();
                echo json_encode($data);
            }
            exit();
        }

        if ($method === 'POST') {
            if ($uri === '/index.php/upload') {
                $this->handleCsvUpload($employeeController);
                echo json_encode(['message' => 'File uploaded and data inserted successfully']);
            } elseif ($uri === '/update') {
                $data = json_decode(file_get_contents('php://input'));
                $employeeController->updateEmail($data->id, $data->email);
                echo json_encode(["message" => "Email updated successfully"]);
            }
            exit();
        }
    }

    private function handleCsvUpload($employeeController)
    {
        $uploadedFile = $_FILES['file'];

        $fileType = strtolower(pathinfo($uploadedFile['name'], PATHINFO_EXTENSION));
        if ($fileType !== 'csv') {
            http_response_code(400);
            echo json_encode(["error" => "Invalid file type. Please upload a CSV file."]);
            exit();
        }

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['error' => 'Error uploading file']);
            exit();
        }

        $fileName = $uploadedFile['name'];
        $filePath = __DIR__ . '/uploads/' . $fileName;

        move_uploaded_file($uploadedFile['tmp_name'], $filePath);

        $this->saveCsvDataToDatabase($filePath, $employeeController);
    }

    private function saveCsvDataToDatabase($csvFilePath, $employeeController)
    {
        $csvData = array_map('str_getcsv', file($csvFilePath));
        $headers = array_shift($csvData);
        $expectedHeaders = ["Company Name", "Employee Name", "Email Address", "Salary"];

        if ($headers === false || $headers !== $expectedHeaders) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid CSV headers. Please ensure the headers match the expected format."]);
            exit();
        }

        foreach ($csvData as $row) {
            $employee = new Employee();
            $employee->company = $row[0];
            $employee->name = $row[1];
            $employee->email = $row[2];
            $employee->salary = $row[3];

            $employeeController->saveEmployee($employee);
        }
    }
}
