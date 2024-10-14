<?php

include "partials/header.php";
include "config/Database.php";

include "classes/Task.php";

session_start();

$database = new Database;
$db = $database->connect();

$todo = new Task($db);

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //detect add_task submitted
    if (isset($_POST['add_task'])) {
        $todo->task = htmlspecialchars(trim($_POST['task']));
        $todo->create();
        $_SESSION['message'] = "Task added successfully";
        $_SESSION['msg_type'] = "success";
    }

    //detect complete_task submitted
    if (isset($_POST['complete_task'])) {
        $todo->id = $_POST['id'];
        $todo->is_completed = 1;
        $todo->update($_POST['id']);
        $_SESSION['message'] = "Task updated";
        $_SESSION['msg_type'] = "success";
    }

    //detect undo_complete_task submitted
    if (isset($_POST['undo_complete_task'])) {
        $todo->id = $_POST['id'];
        $todo->is_completed = 0;
        $todo->update($_POST['id']);
        $_SESSION['message'] = "Task updated";
        $_SESSION['msg_type'] = "success";
    }

    //detect delete_task submitted
    if (isset($_POST['delete_task'])) {
        $todo->id = $_POST['id'];
        $todo->delete($_POST['id']);
        $_SESSION['message'] = "Task deleted";
        $_SESSION['msg_type'] = "success";
    }
}

//fetch tasks
$tasks = $todo->read();

?>

<?php include "partials/notifications.php"; ?>

<!-- Main Content Container -->
<div class="container">
    <h1>Todo App</h1>

    <!-- Add Task Form -->
    <form method="POST">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit" name="add_task">Add Task</button>
    </form>

    <!-- Display Tasks -->
    <ul>
        <!-- if task is completed, use this structure: -->
        <?php while ($task = $tasks->fetch_assoc()): ?>

            <li class="completed">
                <span class="<?php echo $task['is_completed'] ? 'completed' : '' ?>">
                    <?php echo $task['task']; ?>
                </span>
                <div>
                    <!-- Complete Task -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $task['id'] ?>">
                        <button class="complete" type="submit" name="complete_task">Complete</button>
                    </form>

                    <?php if ($task['is_completed']): ?>
                        <!-- Undo Completed Task -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $task['id'] ?>">
                            <button class="undo" type="submit" name="undo_complete_task">Undo</button>
                        </form>
                    <?php endif; ?>

                    <!-- Delete Task -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $task['id'] ?>">
                        <button class="delete" type="submit" name="delete_task">Delete</button>
                    </form>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php include "partials/footer.php"; ?>