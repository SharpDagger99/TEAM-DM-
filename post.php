<?php
// Initialize $organization_name variable
$organization_name = "Default Organization Name"; 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $input_data = $_POST["OROQUIETA MTB"]; // Replace "input_data" with the actual name attribute of your form input field
    
    // Process the retrieved data as needed
    // You can perform validation, sanitation, or further processing here
    
    // Assign the retrieved data to the organization name variable
    $organization_name = $input_data;
}

// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ttc";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch organization name from admin table
$sql = "SELECT organization_name FROM admin LIMIT 1"; // Assuming you only need one row

$result = $conn->query($sql);

if ($result) {
    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // Output data of the first row
        while($row = $result->fetch_assoc()) {
            $organization_name = $row["organization_name"];
        }
    } else {
        // No rows returned, use default value
        $organization_name = "Default Organization Name";
    }
} else {
    // Query execution failed, handle error
    echo "Error executing query: " . $conn->error;
}

$conn->close();
?>
