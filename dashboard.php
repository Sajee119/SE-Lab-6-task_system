<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.html');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'])) {
    $task = htmlspecialchars($_POST['task']);
    if (!isset($_SESSION['tasks'])) {
        $_SESSION['tasks'] = [];
    }
    $_SESSION['tasks'][] = ['task' => $task, 'completed' => false];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <form method="post" action="dashboard.php">
        <input type="text" name="task" placeholder="Enter new task" required>
        <button type="submit">Add Task</button>
    </form>
    <h3>Task List</h3>
    <ul>
        <?php
        if (!empty($_SESSION['tasks'])) {
            foreach ($_SESSION['tasks'] as $index => $task) {
                echo "<li>" . htmlspecialchars($task['task']) . " - " .
                     ($task['completed']
                        ? "Completed"
                        : "<a href='complete_task.php?task_id=$index'>Mark as Completed</a>")
                     . "</li>";
            }
        } else {
            echo "<li>No tasks yet.</li>";
        }
        ?>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>