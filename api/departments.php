<?php
header("Content-Type: application/json");
include('../db.php');

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// GET all or by ID
if($method == 'GET'){
    if($id){
        $stmt = $conn->prepare("SELECT * FROM departments WHERE department_id = ?");
        $stmt->execute([$id]);
    } else {
        $stmt = $conn->query("SELECT * FROM departments");
    }
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// POST - Add department
if($method == 'POST'){
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("INSERT INTO departments (department_name) VALUES (?)");
    $stmt->execute([$data['department_name']]);
    echo json_encode(["message"=>"Department added"]);
}

// PUT - Update department
if($method == 'PUT' && $id){
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("UPDATE departments SET department_name=? WHERE department_id=?");
    $stmt->execute([$data['department_name'], $id]);
    echo json_encode(["message"=>"Department updated"]);
}

// DELETE - Delete department
if($method == 'DELETE' && $id){
    $stmt = $conn->prepare("DELETE FROM departments WHERE department_id=?");
    $stmt->execute([$id]);
    echo json_encode(["message"=>"Department deleted"]);
}
?>