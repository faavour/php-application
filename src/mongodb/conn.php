<?php
$mongo_uri = getenv('MONGO_URI');
$mongo_database = getenv('MONGO_DATABASE');

try {
    // Connect to the MongoDB database using the MongoDB extension
    $mongo_client = new MongoDB\Client($mongo_uri);
    $mongo_db = $mongo_client->$mongo_database;
} catch (MongoDB\Driver\Exception\Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}