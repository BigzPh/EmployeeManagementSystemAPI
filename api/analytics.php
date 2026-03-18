<?php
header("Content-Type: application/json");
include('../db.php');

// Employees per department
$stmt = $conn->query("
    SELECT d.department_name, COUNT(e.employee_id) AS total_employees
    FROM departments d
    LEFT JOIN employees e ON d.department_id = e.department_id
    GROUP BY d.department_name
");
$employees_per_dept = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Average salary per department
$stmt = $conn->query("
    SELECT d.department_name, AVG(e.salary) AS avg_salary
    FROM departments d
    JOIN employees e ON d.department_id = e.department_id
    GROUP BY d.department_name
");
$avg_salary_per_dept = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Projects per department
$stmt = $conn->query("
    SELECT d.department_name, COUNT(p.project_id) AS total_projects
    FROM departments d
    LEFT JOIN projects p ON d.department_id = p.department_id
    GROUP BY d.department_name
");
$projects_per_dept = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "employees_per_department" => $employees_per_dept,
    "average_salary_per_department" => $avg_salary_per_dept,
    "projects_per_department" => $projects_per_dept
]);
?>