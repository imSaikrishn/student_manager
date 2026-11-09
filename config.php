<?php
// PHP 8.1+ throws exceptions on SQL errors by default; turn that off so the
// duplicate-email check ($conn->errno === 1062) works as written.
mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli("localhost", "root", "", "student_db");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

function e($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
