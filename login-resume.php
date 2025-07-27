<?php
// Show all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$host = "localhost";
$username = "root";
$password = "";
$dbname = "project2db";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = clean_input($_POST['email']);
    $inputpassword = clean_input($_POST['password']);

    // Prepare and bind
    $stmt = $conn->prepare("SELECT user_id,password FROM tbl_user WHERE email = ? AND status = 1");
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();
        $storedHashedPassword = $row['password'];

        if (password_verify($inputpassword, $storedHashedPassword)) {
            $user_id = $row['user_id'];
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['guid'] = $guid;
            header("Location:resume.php");
            exit();
        } else {
           header("Location: login-signup-resume.html?message=" . urlencode("Invalid email or password") . "&type=error");
        }
    } else {
        header("Location: login-signup-resume.html?message=" . urlencode("User Not Found ! Signup First") . "&type=error");
    }

    // Close the statement
    
}$stmt->close();
?>