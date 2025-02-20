<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load .env only in local environment
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Fetch environment variables (ECS, Docker, or local)
$host = getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? null;
$username = getenv('DB_USER') ?: $_ENV['DB_USER'] ?? null;
$password = getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'] ?? null;
$dbname = getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? null;

// Ensure variables are set
if (!$host || !$username || !$password || !$dbname) {
    die("Missing database environment variables");
}

// Connect without specifying a database (for creating DB if needed)
$conn = new mysqli($host, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($sqlCreateDB)) {
    die("Database creation failed: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create tasks table if not exists
$sqlCreateTable = "
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(255) NOT NULL,
    is_completed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($sqlCreateTable)) {
    die("Table creation failed: " . $conn->error);
}


?>
