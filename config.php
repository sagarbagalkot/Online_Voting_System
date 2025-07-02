<?php

// Database Configuration
$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_evoting";

// Create a connection to the database
$conn = @mysqli_connect($hostname, $username, $password, $database) 
    or die("Couldn't connect to database. Please check your connection details.");

// User Input Sanitization Function
if (!function_exists('test_input')) {
    function test_input($data) {
        // Trim the input to remove extra spaces
        $data = trim($data);
        
        // Remove any backslashes from the input
        $data = stripslashes($data);
        
        // Convert special characters to HTML entities to prevent XSS attacks
        $data = htmlspecialchars($data);
        
        return $data;
    }
}

?>
