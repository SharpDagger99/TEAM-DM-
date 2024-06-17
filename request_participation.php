<?php
// request_participation.php
session_start();
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "ttc";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $user_id = $_GET['user_id'];
    $status = 'pending';
    // Insert into req_pending table
    $sql = "INSERT INTO req_pending (upload_id, user_id, status) VALUES (?, ? ,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $post_id , $user_id , $status);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Request to participate sent successfully!']);
        header('location: ./user.php');
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send request.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid post ID.']);
}

$conn->close();
?>
