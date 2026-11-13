<?php
session_start();
if (isset($_GET['task_id'])) {
    $task_id = (int)$_GET['task_id'];
    if (isset($_SESSION['tasks'][$task_id])) {
        $_SESSION['tasks'][$task_id]['completed'] = true;
    }
}
header('Location: dashboard.php');
exit();
?>