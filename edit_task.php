<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $task = $_POST['task'];

    $sql = "UPDATE tasks SET name=?, subject=?, task=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $subject, $task, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
