<?php
$dbhost = getenv('MYSQL_HOST');
$dbuser = getenv('MYSQL_USER');
$dbpass = getenv('MYSQL_PASSWORD');
$dbname = getenv('MYSQL_DATABASE');

// Connect to MySQL
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die('Could not connect: ' . mysql_error());
}

// Select database
// mysql_select_db($dbname);

function init($conn) {
    // Create table if table does not exist.
    $result = mysqli_query($conn, "SELECT EXISTS (SELECT 1 FROM information_schema.tables WHERE table_name = 'todos')");
    // print_r($result->num_rows);
    if (!$result->num_rows) {
        # code...
        $result = mysqli_query($conn, "CREATE TABLE todos (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            description VARCHAR(255) NOT NULL,
            completed TINYINT(1) NOT NULL DEFAULT '0',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );");
    }

}

init($conn);

function get_todo_items($conn) {
    $result = mysqli_query($conn, "SELECT * FROM todos");

    $todos = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $todos[] = $row;
    }

    return $todos;
}

function add_todo_item($conn, $description) {
    $description = mysqli_real_escape_string($conn, $description);

    $sql = "INSERT INTO todos (description) VALUES ('$description')";
    mysqli_query($conn, $sql);
}

function delete_todo_item($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);

    $sql = "DELETE FROM todos WHERE id = '$id'";
    mysqli_query($conn, $sql);
}

function update_todo_item($conn, $id) {
    $id = mysqli_real_escape_string($conn, $id);

    $sql = "UPDATE todos SET completed = NOT completed WHERE id = '$id'";
    mysqli_query($conn, $sql);
}