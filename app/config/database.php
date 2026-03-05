<?php

function getPDO() {
    static $pdo = null; // Singleton to reuse the connection

    if ($pdo === null) {
        $host = '...';      	// Server Host
        $dbname = '...'; 	    // Database Name
        $username = '...';      // Database User
        $password = '...';		// Database Password

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Error mode: throw exceptions
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch as associative array
            // Optional: Persistent connection for performance (not recommended in shared environments)
            // $pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
        } catch (PDOException $e) {
            die("Database connection error: " . $e->getMessage());
        }
    }

    return $pdo;
}