<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "ttc";

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement
    $stmt = $pdo->prepare("SELECT * FROM user WHERE Username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Check if user exists
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verify password
        if (password_verify($password, $row['Password'])) {
            // Password is correct, store user details in session and redirect
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: User.php"); // Replace with your desired destination
            exit();
        } else {
            // Password is incorrect
            $_SESSION['error'] = "Incorrect username or password.";
            header("Location: loginModal.php"); // Redirect back to login page
            exit();
        }
    } else {
        // Username does not exist
        $_SESSION['error'] = "Username or Password is Incorrect! Please try again.";
        header("Location: Index.php"); // Redirect back to index page
        exit();
    }
} catch (PDOException $e) {
    // Database connection error
    $_SESSION['error'] = "Database connection error: " . $e->getMessage();
    header("Location: loginModal.php"); // Redirect back to login page
    exit();
}
?>
