<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$date = date('Y-m-d');

$stmt = $conn->prepare("SELECT * FROM attendance WHERE user_id = :user_id AND date = :date");
$stmt->execute(['user_id' => $user_id, 'date' => $date]);

if ($stmt->rowCount() === 0) {
    $stmt = $conn->prepare("INSERT INTO attendance (user_id, date) VALUES (:user_id, :date)");
    $stmt->execute(['user_id' => $user_id, 'date' => $date]);
}

echo "Your attendance for today has been logged.";
?>
