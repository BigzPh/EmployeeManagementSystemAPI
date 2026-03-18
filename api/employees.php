<?php
header("Content-Type: application/json");
include('../db.php');

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$dept_id = isset($_GET['department_id']) ? intval($_GET['department_id']) : null;

// GET all employees or by ID
if($method == 'GET'){
    if($id){
        $stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = ?");
        $stmt->execute([$id]);
    } elseif($dept_id){
        $stmt = $conn->prepare("SELECT * FROM employees WHERE department_id = ?");
        $stmt->execute([$dept_id]);
    } else {
        $stmt = $conn->query("SELECT * FROM employees");
    }
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// POST - Add employee
if($method == 'POST'){
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("INSERT INTO employees (employee_name, salary, department_id) VALUES (?, ?, ?)");
    $stmt->execute([$data['employee_name'], $data['salary'], $data['department_id']]);
    echo json_encode(["message"=>"Employee added"]);
}

// PUT - Update employee
if($method == 'PUT' && $id){
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("UPDATE employees SET employee_name=?, salary=?, department_id=? WHERE employee_id=?");
    $stmt->execute([$data['employee_name'], $data['salary'], $data['department_id'], $id]);
    echo json_encode(["message"=>"Employee updated"]);
}

// DELETE - Delete employee
if($method == 'DELETE' && $id){
    $stmt = $conn->prepare("DELETE FROM employees WHERE employee_id=?");
    $stmt->execute([$id]);
    echo json_encode(["message"=>"Employee deleted"]);
}
?>