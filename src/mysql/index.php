<?php
require_once 'conn.php';

if (isset($_POST['description'])) {
    add_todo_item($conn, $_POST['description']);
}

if (isset($_POST['delete'])) {
    delete_todo_item($conn, $_POST['delete']);
}

if (isset($_POST['update'])) {
    update_todo_item( $conn, $_POST['update']);
}

$todos = get_todo_items($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Todo App</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>PHP Todo App</h1>

    <form action="index.php" method="post">
        <input type="text" name="description" placeholder="Enter a Todo item description...">
        <button type="submit">Add New Todo</button>
    </form>

    <?php if (!empty($todos)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todos as $todo): ?>
                    <tr>
                        <td><?php echo $todo['id']; ?></td>
                        <td><?php echo htmlspecialchars($todo['description']); ?></td>
                        <td><?php echo $todo['created_at']; ?></td>
                        <td>
                            <form action="index.php" method="post">
                                <input type="hidden" name="delete" value="<?php echo $todo['id']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No Todo items found.</p>
    <?php endif; ?>

</body>
</html>