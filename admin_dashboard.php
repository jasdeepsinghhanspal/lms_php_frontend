<?php
require 'config.php';
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$view = isset($_GET['view']) ? $_GET['view'] : 'attendance'; // Default to attendance
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        nav {
            margin-top: 20px;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: blue;
            font-weight: bold;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <nav>
        <a href="admin_dashboard.php?view=attendance">View Attendance</a>
        <a href="admin_dashboard.php?view=interest">View Interested Students</a>
    </nav>

    <?php
    if ($view === 'attendance') {
        echo "<h2>Attendance Records (This Month)</h2>";
        $stmtStudents = $conn->query("SELECT users.name, COUNT(attendance.id) AS days_present 
                                      FROM attendance 
                                      JOIN users ON attendance.user_id = users.id 
                                      WHERE users.role = 'student' 
                                      AND MONTH(attendance.date) = MONTH(CURDATE()) 
                                      AND YEAR(attendance.date) = YEAR(CURDATE())
                                      AND attendance.status = 'present'
                                      GROUP BY users.id");
        $studentAttendance = $stmtStudents->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>Student Attendance</h3>";
        echo "<table>
                <tr>
                    <th>Name</th>
                    <th>Days Present</th>
                </tr>";
        foreach ($studentAttendance as $student) {
            echo "<tr>
                    <td>{$student['name']}</td>
                    <td>{$student['days_present']}</td>
                  </tr>";
        }
        echo "</table>";

        $stmtTeachers = $conn->query("SELECT users.name, COUNT(attendance.id) AS days_present 
                                      FROM attendance 
                                      JOIN users ON attendance.user_id = users.id 
                                      WHERE users.role = 'teacher' 
                                      AND MONTH(attendance.date) = MONTH(CURDATE()) 
                                      AND YEAR(attendance.date) = YEAR(CURDATE())
                                      AND attendance.status = 'present'
                                      GROUP BY users.id");
        $teacherAttendance = $stmtTeachers->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>Teacher Attendance</h3>";
        echo "<table>
                <tr>
                    <th>Name</th>
                    <th>Days Present</th>
                </tr>";
        foreach ($teacherAttendance as $teacher) {
            echo "<tr>
                    <td>{$teacher['name']}</td>
                    <td>{$teacher['days_present']}</td>
                  </tr>";
        }
        echo "</table>";
    } elseif ($view === 'interest') {
        echo "<h2>Interested Students</h2>";

        $stmt = $conn->query("SELECT * FROM course_interest");
        $interestedStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                </tr>";
        foreach ($interestedStudents as $student) {
            echo "<tr>
                    <td>{$student['name']}</td>
                    <td>{$student['email']}</td>
                    <td>{$student['course']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Invalid view selected.</p>";
    }
    ?>
    <nav>
    <a href="admin_dashboard.php?view=attendance">View Attendance</a>
    <a href="admin_dashboard.php?view=interest">View Interested Students</a>
    <a href="change_password.php">Change Password</a>
</nav>

</body>
</html>
