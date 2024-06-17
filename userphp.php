<?php
// Database connection parameters
$servername = "localhost";  
$username = "root";
$password = "";
$dbname = "ttc";

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Retrieve form data
    $username = $_POST['signup-username'];
    $password = $_POST['signup-password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $email = $_POST['email'];
    
    // Hash the password for security
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO user (Username, Password, First_Name, Last_Name, Age, Sex, Email) 
                            VALUES (:username, :password, :firstname, :lastname, :age, :sex, :email)");
    
    // Bind parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password_hashed);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':email', $email);
    
    // Execute the prepared statement
    $stmt->execute();
    
    // Close connection
    $pdo = null;
    
    // Echo a success message and trigger modal display using JavaScript
    echo '<script>alert("New record created successfully");';
    echo 'window.location.href = "Index.php";</script>';
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
