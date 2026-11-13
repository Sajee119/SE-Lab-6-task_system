# Lab 6 – Task 2: Distributed Task Management System (Full Stack Demo)

For a demo of a distributed enterprise software system using **Full Stack (HTML / CSS / JavaScript / PHP)**, you can create a simple yet practical **multi-user task management system**. This example simulates a basic version of software commonly used in enterprises for task tracking and collaboration.

## Project: Distributed Task Management System

### Concept

Create a web-based task management system where users can:

1. **Log in** (simulate user authentication).
2. **Create and view tasks** (tasks could be managed and assigned to different users).
3. **Mark tasks as completed.**
4. This could simulate a distributed software system where multiple users interact with a common application, typical of an enterprise solution.

### Features

- **Frontend:** Use **HTML/CSS/JavaScript** for the user interface.
- **Backend:** Use **PHP** for server-side logic to handle user requests and manage tasks.
- **No Database:** You can simulate task data using files or sessions (to keep things simple for the demo).
- **Distributed:** While not physically distributed (e.g., microservices), the demo conceptually simulates distributed enterprise software, where different users (clients) interact with the same system, which can be scaled to multiple servers in a real-world scenario.

## Step-by-Step Guide

### 1. Frontend: HTML, CSS, and JavaScript

Create a simple user interface with HTML and CSS for users to log in, create tasks, and view task lists.

#### `index.html`

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Task Management System</h2>
    <div id="login-section">
        <h3>Login</h3>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
```

#### `styles.css`

```css
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    padding: 20px;
}
h2 {
    text-align: center;
}
#login-section {
    width: 300px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
form label, form input {
    display: block;
    margin-bottom: 10px;
}
form button {
    width: 100%;
    padding: 10px;
    background: #007BFF;
    color: white;
    border: none;
    cursor: pointer;
}
form button:hover {
    background: #0056b3;
}
```

### 2. Backend: PHP Authentication and Task Handling

#### `login.php`

Simulate user authentication with hardcoded credentials and redirect users to the task dashboard after logging in.

```php
<?php
session_start();
$users = [
    'user1' => 'password1',
    'user2' => 'password2'
];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (isset($users[$username]) && $users[$username] == $password) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
    } else {
        echo "Invalid login credentials!";
    }
}
?>
```

#### `dashboard.php`

This file serves as the dashboard where users can create tasks and view the list of tasks. Tasks will be stored in a session array for simplicity.

```php
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <form method="post" action="dashboard.php">
        <input type="text" name="task" placeholder="Enter new task" required>
        <button type="submit">Add Task</button>
    </form>
    <h3>Task List</h3>
    <ul>
        <?php
        if (isset($_SESSION['tasks'])) {
            foreach ($_SESSION['tasks'] as $index => $task) {
                echo "<li>" . htmlspecialchars($task['task']) . " - " .
                    ($task['completed'] ? "Completed" : "<a href='complete_task.php?task_id=$index'>Mark as Completed</a>") .
                    "</li>";
            }
        }
        ?>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>
```

#### `complete_task.php`

This file will allow users to mark tasks as completed.

```php
<?php
session_start();
if (isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];
    if (isset($_SESSION['tasks'][$task_id])) {
        $_SESSION['tasks'][$task_id]['completed'] = true;
    }
}
header('Location: dashboard.php');
exit();
?>
```

#### `logout.php`

This script will handle user logout by destroying the session.

```php
<?php
session_start();
session_destroy();
header('Location: index.html');
?>
```

### 3. Testing and Demonstration

Steps for Students:

1. **Login:** Open `index.html`, log in using one of the hardcoded users (e.g., `user1` / `password1`).
2. **Create a Task:** On `dashboard.php`, add a new task and see it appear on the list.
3. **Mark Task as Completed:** Click the "Mark Completed" link next to a task, and the task's status will update.
4. **Multiple Users:** Since the task data is stored in a session, each user (e.g., `user1` and `user2`) will have their own isolated task list, simulating a distributed system where different users work on different sets of data.
5. **Logout:** Demonstrate how the user can log out and how their session is terminated.

## 4. Learning Outcomes

- **Frontend/Backend Integration:** Students will see how HTML, CSS, JavaScript, and PHP interact to create a full-stack web application.
- **Session Handling:** Demonstrates PHP session management to simulate user authentication and task tracking.
- **Task Management Logic:** Students will understand the basics of creating, viewing, and marking tasks as complete—an example of CRUD operations.
- **Simulated Multi-User System:** Even though the session data is isolated per user, this demo shows the idea of distributed enterprise software where multiple users work on the same system.

This simple example gives students practical experience with full-stack development concepts that can be extended to more complex systems, typical in enterprise environments.

> **Note:** The original lab handout contains a few typographical errors in the PHP code (e.g., `$_SERVER['username']` instead of `$users[$username]`, `$_SESSION['tasks'] = [...]` overwriting the array instead of appending, and quoting issue in `isset($_SESSION['tasks']['$task_id'])`). The code above has been corrected so that the demo actually works as intended.