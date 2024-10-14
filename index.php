<?php
include "partials/header.php";
include "config/Database.php";
include "partials/notifications.php";

include "classes/Task.php";

$database = new Database;
$db = $database->connect();

$todo = new Task($db);

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //detect add_task submitted
    if (isset($_POST['add_task'])) {
        $todo->task = htmlspecialchars(trim($_POST['task']));
        $todo->create();
    }

    //detect complete_task submitted
    if (isset($_POST['complete_task'])) {
        $todo->update($_POST['id']);
    }
}

//fetch tasks
$tasks = $todo->read();

?>

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
                <span class="<?php $task['is_completed'] ? 'completed' : '' ?>"><?php echo $task['task']; ?></span>
                <div>
                    <!-- Complete Task -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php $task['id'] ?>">
                        <button class="complete" type="submit" name="complete_task">Complete</button>
                    </form>

                    <?php if($task['is_completed']): ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php $task['id'] ?>">
                        <button class="undo" type="submit" name="undo_complete_task">Undo</button>
                    </form>
                    <?php endif; ?>

                    <!-- Delete Task -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php $task['id'] ?>">
                        <button class="delete" type="submit" name="delete_task">Delete</button>
                    </form>
                </div>
            </li>

        <?php endwhile; ?>
    </ul>
</div>

<?php include "partials/footer.php"; ?>