<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, role, username, password) VALUES (:name, :role, :username, :password)");
    $stmt->execute([
        'name' => $name,
        'role' => $role,
        'username' => $username,
        'password' => $password
    ]);

    echo "Registration successful. <a href='login.php'>Login here</a>";
}
?>

<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <select name="role" required>
        <option value="" disabled selected>Select Role</option>
        <option value="admin">Admin</option>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>
