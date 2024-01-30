<?php

class EmployeeController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function index($id = null)
    {
        $query = 'SELECT * FROM employees';
        $params = [];
        $method = 'fetchAll';
        if ($id != null) {
            $query .= ' WHERE id = ?';
            $params[] = $id;
            $method = 'fetch';
        }
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->$method(PDO::FETCH_ASSOC);
    }

    public function updateEmail($id, $email)
    {
        $query = $this->db->prepare("UPDATE employees SET email = ? WHERE id = ?");
        $query->execute([$email, $id]);
    }

    public function averageSalaryByCompany()
    {
        $stmt = $this->db->query("SELECT company, AVG(salary) AS averageSalary FROM employees GROUP BY company");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveEmployee(Employee $employee)
    {
        $stmt = $this->db->prepare("INSERT INTO employees (company, name, email, salary) VALUES (?, ?, ?, ?)");
        $stmt->execute([$employee->company, $employee->name, $employee->email, $employee->salary]);
    }
}
