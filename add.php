<?php
include 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $course = trim($_POST['course']);
    $year = (int)$_POST['year'];

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $course === '' || $year < 1 || $year > 4) {
        $error = "Please fill all fields with valid values.";
    } else {
        $stmt = $conn->prepare("INSERT INTO students (name, email, course, year) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $email, $course, $year);
        if ($stmt->execute()) {
            header("Location: index.php?msg=" . urlencode("Student added"));
            exit;
        }
        $error = ($conn->errno === 1062) ? "That email already exists." : "Could not save the record.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Add Student</h1>
    <?php if ($error): ?><div class="msg err"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
        <label>Name</label>
        <input type="text" name="name" required value="<?= e($_POST['name'] ?? '') ?>">
        <label>Email</label>
        <input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>">
        <label>Course</label>
        <input type="text" name="course" required value="<?= e($_POST['course'] ?? 'BCA') ?>">
        <label>Year</label>
        <select name="year">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>
        <p><button type="submit">Save</button> <a class="btn danger" href="index.php">Cancel</a></p>
    </form>
</div>
</body>
</html>
