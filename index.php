<?php
include 'config.php';
$search = trim($_GET['q'] ?? '');
if ($search !== '') {
    $like = "%$search%";
    $stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE ? OR email LIKE ? OR course LIKE ? ORDER BY id DESC");
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Record Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Student Record Manager</h1>
    <?php if (isset($_GET['msg'])): ?>
        <div class="msg ok"><?= e($_GET['msg']) ?></div>
    <?php endif; ?>
    <form method="get" style="display:flex; gap:8px;">
        <input type="text" name="q" placeholder="Search name, email or course" value="<?= e($search) ?>">
        <button type="submit">Search</button>
    </form>
    <p><a class="btn" href="add.php">+ Add Student</a></p>
    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Year</th><th>Actions</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= (int)$row['id'] ?></td>
            <td><?= e($row['name']) ?></td>
            <td><?= e($row['email']) ?></td>
            <td><?= e($row['course']) ?></td>
            <td><?= (int)$row['year'] ?></td>
            <td>
                <a class="btn edit" href="edit.php?id=<?= (int)$row['id'] ?>">Edit</a>
                <a class="btn danger" href="delete.php?id=<?= (int)$row['id'] ?>" onclick="return confirm('Delete this student?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
