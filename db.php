<?php
$host = "localhost";
$port = "5432";
$dbname = "EmployeeManagementSystem";
$user = "postgres";
$password = "carlo"; // replace with your actual password

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch(PDOException $e) {
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}
?>