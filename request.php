<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "ttc"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Execute a SELECT query
$sql = "SELECT * FROM post";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $post = $result->fetch_assoc();
    $post_id = $post['post_id'];
} else {
    die("No posts found.");
}

// Fetch the username from session
$usernames = $_SESSION['username'];

// Prepare and execute the SELECT query to fetch user details
$stmt = $conn->prepare("SELECT * FROM user WHERE Username = ?");
$stmt->bind_param("s", $usernames);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];
} else {
    die("User not found.");
}

// Insert into req_pending table
$status = 'pending';
$stmt = $conn->prepare("INSERT INTO req_pending (post_id, user_id, status) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $post_id, $user_id, $status);
$stmt->execute();

$stmt->close();
$conn->close();

echo "Request submitted successfully.";
?>
