<?php
// admin_login.php

// Check if form is submitted   
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve entered email and password from form
    $email = $_POST['admin-username'];
    $password = $_POST['admin-password'];

    // Your database connection code goes here
    // Replace placeholders with your actual database credentials
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "ttc";

    // Create connection
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL query to check if the entered credentials exist in the database
    $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Admin credentials are correct, you may redirect here if needed
         header("Location: Admin.php");
         exit();
    } else {
        // Admin credentials are incorrect, display an error message or handle it as you see fit
        echo 'Error';
    }

    // Close database connection
    $conn->close();
    
}

    
?>
