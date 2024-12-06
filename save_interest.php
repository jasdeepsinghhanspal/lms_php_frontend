<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $stmt = $conn->prepare("INSERT INTO course_interest (name, email, course) VALUES (:name, :email, :course)");
    $stmt->execute(['name' => $name, 'email' => $email, 'course' => $course]);

    echo "Thank you for your interest!";
}
?>
