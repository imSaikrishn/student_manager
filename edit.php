<?php
include 'config.php';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$error = '';

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
if (!$student) { die("Student not found."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $year = (int)$_POST['year'];

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $course === '' || $year < 1 || $year > 4) {
        $error = "Please fill all fields with valid values.";
    } else {
        $stmt = $conn->prepare("UPDATE students SET name=?, email=?, course=?, year=? WHERE id=?");
        $stmt->bind_param("sssii", $name, $email, $course, $year, $id);
        if ($stmt->execute()) {
            header("Location: index.php?msg=" . urlencode("Student updated"));
            exit;
        }
        $error = ($conn->errno === 1062) ? "That email already exists." : "Could not update the record.";
    }
    $student = ['name' => $name, 'email' => $email, 'course' => $course, 'year' => $year];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Edit Student</h1>
    <?php if ($error): ?><div class="msg err"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label>Name</label>
        <input type="text" name="name" required value="<?= e($student['name']) ?>">
        <label>Email</label>
        <input type="email" name="email" required value="<?= e($student['email']) ?>">
        <label>Course</label>
        <input type="text" name="course" required value="<?= e($student['course']) ?>">
        <label>Year</label>
        <select name="year">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <option value="<?= $i ?>" <?= ((int)$student['year'] === $i) ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
        <p><button type="submit">Update</button> <a class="btn danger" href="index.php">Cancel</a></p>
    </form>
</div>
</body>
</html>
