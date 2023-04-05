<?php
require_once "../vendor/autoload.php";

$mongo_uri = getenv('MONGO_URI');

echo $mongo_uri;
echo "my name is james";

$mongo_database = getenv('MONGO_INITDB_DATABASE');

try {
    // Connect to the MongoDB database using the MongoDB extension
    $mongo_client = new MongoDB\Client($mongo_uri);
    $mongo_db = $mongo_client->$mongo_database;
} catch (MongoDB\Driver\Exception\Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}