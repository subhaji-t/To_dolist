<?php

$sName = "localhost";   // The server name (usually 'localhost')
$uName = "root";        // The username for the database
$pass = "";             // The password for the database
$db_name = "to_do_list"; // The name of the database you want to connect to

// Create a MySQLi object and establish the connection
$conn = new mysqli($sName, $uName, $pass, $db_name);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully!";

// Close the connection when done
$conn->close();
?>
