<?php
require_once 'conn.php';

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_todo'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $due_date = new MongoDB\BSON\UTCDateTime(strtotime($_POST['due_date']) * 1000);
        $status = $_POST['status'];
        $created_at = new MongoDB\BSON\UTCDateTime(time() * 1000);

        try {
            // Insert the new todo item into MongoDB database using the MongoDB extension
            $result = $mongo_db->todos->insertOne([
                'title' => $title,
                'description' => $description,
                'due_date' => $due_date,
                'status' => $status,
                'created_at' => $created_at,
            ]);

            $success_message = 'Todo item added successfully.';
        } catch (MongoDB\Driver\Exception\Exception $e) {
            $error_message = 'Error adding todo item to MongoDB database: ' . $e->getMessage();
        }
    } else if (isset($_POST['edit_todo'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $due_date = new MongoDB\BSON\UTCDateTime(strtotime($_POST['due_date']) * 1000);
        $status = $_POST['status'];

        try {
            // Update the todo item in MongoDB database using the MongoDB extension
            $result = $mongo_db->todos->updateOne(
                ['_id' => new MongoDB\BSON\ObjectID($id)],
                ['$set' => [
                    'title' => $title,
                    'description' => $description,
                    'due_date' => $due_date,
                    'status' => $status,
                ]]
            );

            $success_message = 'Todo item updated successfully.';
        } catch (MongoDB\Driver\Exception\Exception $e) {
            $error_message = 'Error updating todo item in MongoDB database: ' . $e->getMessage();
        }
    } else if (isset($_POST['delete_todo'])) {
        $id = $_POST['id'];

        try {
            // Delete the todo item from MongoDB database using the MongoDB extension
            $result = $mongo_db->todos->deleteOne(['_id' => new MongoDB\BSON\ObjectID($id)]);

            $success_message = 'Todo item deleted successfully.';
        } catch (MongoDB\Driver\Exception\Exception $e) {
            $error_message = 'Error deleting todo item from MongoDB database: ' . $e->getMessage();
        }
    }
}

// Retrieve all todo items from MongoDB database using the MongoDB extension
try {
    $cursor = $mongo_db->todos->find();
    $todos = [];
    foreach ($cursor as $document) {
        $document['_id'] = (string)$document['_id'];
        $document['due_date'] = $document['due_date']->toDateTime()->format('Y-m-d');
        $document['created_at'] = $document['created_at']->toDateTime()->format('Y-m-d H:i:s');
        $todos[] = $document;
    }
} catch (MongoDB\Driver\Exception\Exception $e) {
    $error_message = 'Error retrieving todo items from MongoDB database: ' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Todo App with MongoDB</title>
        <style>
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }

            h1 {
                text-align: center;
            }

            form {
                display: flex;
                flex-direction: column;
                margin-bottom: 20px;
            }

            label {
                margin-bottom: 5px;
            }

            input, textarea, select {
                margin-bottom: 10px;
                padding: 5px;
                font-size: 16px;
            }

            button[type="submit"] {
                padding: 10px;
                font-size: 16px;
                cursor: pointer;
            }

            .success {
                color: green;
                margin-bottom: 10px;
            }

            .error {
                color: red;
                margin-bottom: 10px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid black;
                padding: 10px;
            }

            th {
                background-color: #ddd;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            tr:hover {
                background-color: #ddd;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Todo App with MongoDB</h1>

            <?php if ($success_message !== ''): ?>
                <p class="success"><?php echo $success_message; ?></p>
            <?php endif; ?>

            <?php if ($error_message !== ''): ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="id" value="<?php echo isset($_POST['id']) ? $_POST['id'] : ''; ?>">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : ''; ?>" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" required><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>

                <label for="due_date">Due Date</label>
                <input type="date" id="due_date" name="due_date" value="<?php echo isset($_POST['due_date']) ? $_POST['due_date'] : ''; ?>" required>

                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="" disabled selected>Select a status</option>
                    <option value="todo" <?php echo (isset($_POST['status']) && $_POST['status'] === 'todo') ? 'selected' : ''; ?>>Todo</option>
                    <option value="doing" <?php echo (isset($_POST['status']) && $_POST['status'] === 'doing') ? 'selected' : ''; ?>>Doing</option>
                    <option value="done" <?php echo (isset($_POST['status']) && $_POST['status'] === 'done') ? 'selected' : ''; ?>>Done</option>
                </select>

                <?php if (isset($_POST['edit_todo'])): ?>
                    <button type="submit" name="edit_todo">Update Todo</button>
                <?php else: ?>
                    <button type="submit" name="add_todo">Add Todo</button>
                <?php endif ?>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todos as $todo): ?>
                        <tr>
                            <td><?php echo $todo['title']; ?></td>
                            <td><?php echo $todo['description']; ?></td>
                            <td><?php echo $todo['due_date']; ?></td>
                            <td><?php echo ucfirst($todo['status']); ?></td>
                            <td><?php echo $todo['created_at']; ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo $todo['_id']; ?>">
                                    <input type="hidden" name="title" value="<?php echo $todo['title']; ?>">
                                    <input type="hidden" name="description" value="<?php echo $todo['description']; ?>">
                                    <input type="hidden" name="due_date" value="<?php echo $todo['due_date']; ?>">
                                    <input type="hidden" name="status" value="<?php echo $todo['status']; ?>">
                                    <button type="submit" name="edit_todo">Edit</button>
                                </form>
                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo $todo['_id']; ?>">
                                    <button type="submit" name="delete_todo" onclick="return confirm('Are you sure you want to delete this todo item?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>




