<?php
header("Content-Type: application/json");
include('../db.php');

$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$dept_id = isset($_GET['department_id']) ? intval($_GET['department_id']) : null;

// GET all projects or by ID
if($method == 'GET'){
    if($id){
        $stmt = $conn->prepare("SELECT * FROM projects WHERE project_id=?");
        $stmt->execute([$id]);
    } elseif($dept_id){
        $stmt = $conn->prepare("SELECT * FROM projects WHERE department_id=?");
        $stmt->execute([$dept_id]);
    } else {
        $stmt = $conn->query("SELECT * FROM projects");
    }
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// POST - Add project
if($method == 'POST'){
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("INSERT INTO projects (project_name, department_id) VALUES (?, ?)");
    $stmt->execute([$data['project_name'], $data['department_id']]);
    echo json_encode(["message"=>"Project added"]);
}

// PUT - Update project
if($method == 'PUT' && $id){
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("UPDATE projects SET project_name=?, department_id=? WHERE project_id=?");
    $stmt->execute([$data['project_name'], $data['department_id'], $id]);
    echo json_encode(["message"=>"Project updated"]);
}

// DELETE - Delete project
if($method == 'DELETE' && $id){
    $stmt = $conn->prepare("DELETE FROM projects WHERE project_id=?");
    $stmt->execute([$id]);
    echo json_encode(["message"=>"Project deleted"]);
}
?>