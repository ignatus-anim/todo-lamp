<?php

require_once __DIR__ . '/vendor/autoload.php';

// Only load .env when testing locally
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Use environment variables from ECS, Docker, or local .env
$host = getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? null;
$username = getenv('DB_USER') ?: $_ENV['DB_USER'] ?? null;
$password = getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'] ?? null;
$dbname = getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? null;

// Ensure required variables are set
if (!$host || !$username || !$password || !$dbname) {
    die("Missing database environment variables");
}

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully!";
?>
