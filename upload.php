<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";   
$dbname = "ttc";  
 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = sanitize_input($_POST["title"]);
    $description = sanitize_input($_POST["description"]);
    $organization_name = "OROQUIETA MTB";

    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        $file_name = basename($_FILES["file"]["name"]);
        $file_tmp_name = $_FILES["file"]["tmp_name"];
        $file_path = $upload_dir . $file_name;

        // Move the file to the upload directory
        if (move_uploaded_file($file_tmp_name, $file_path)) {
            $conn->begin_transaction();

            try {
                $stmt = $conn->prepare("INSERT INTO uploads (title, udescription, file_uploaded) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $title, $description, $file_path);

                if ($stmt->execute()) {
                    $upload_id = $stmt->insert_id;

                    $stmt_post = $conn->prepare("INSERT INTO post (upload_id, title, time_posted, pdescription, file_uploaded, organization_name) VALUES (?, ?, CURRENT_TIMESTAMP, ?, ?, ?)");
                    $stmt_post->bind_param("issss", $upload_id, $title, $description, $file_path, $organization_name);

                    if ($stmt_post->execute()) {
                        $conn->commit();
                        header("Location: admin.php");
                        exit();
                    } else {
                        throw new Exception("Error inserting into posts table: " . $stmt_post->error);
                    }

                    $stmt_post->close();
                } else {
                    throw new Exception("Error: " . $stmt->error);
                }

                $stmt->close();
            } catch (Exception $e) {
                $conn->rollback();
                $error_message = $e->getMessage();
                echo "<script>alert('$error_message');</script>";
            }
        } else {
            $error_message = "Error moving uploaded file.";
            echo "<script>alert('$error_message');</script>";
        }
    } else {
        $error_message = "Error uploading file.";
        echo "<script>alert('$error_message');</script>";
    }
}

$conn->close();

?>
