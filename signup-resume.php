<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guid = bin2hex(random_bytes(16));
    $email = clean_input($_POST["new-email"]);
    $password = clean_input($_POST["new-password"]);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $ipaddress=getUserIP();

    // --- Add detection code here ---

    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if (strpos($user_agent, 'Firefox') !== false) {
        $browser = 'Firefox';
    } elseif (strpos($user_agent, 'Chrome') !== false) {
        $browser = 'Chrome';
    } elseif (strpos($user_agent, 'Safari') !== false) {
        $browser = 'Safari';
    } elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident') !== false) {
        $browser = 'Internet Explorer';
    } else {
        $browser = 'Other';
    }

    if (preg_match('/linux/i', $user_agent)) {
        $platform = 'Linux';
    } elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
        $platform = 'Mac';
    } elseif (preg_match('/windows|win32/i', $user_agent)) {
        $platform = 'Windows';
    } else {
        $platform = 'Other';
    }
    // --- End detection code ---

    // Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM tbl_user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: login-signup-resume.html?message=" . urlencode("Email Already Exist") . "&type=error");
        exit();
    } else {
        // Insert new user
        $stmt->close(); // Close previous statement
        $stmt = $conn->prepare("INSERT INTO tbl_user ( email, password,guid,browser_name,browser_platform,ip_address) VALUES ( ?, ?,?,?,?,?)");
        $stmt->bind_param("ssssss", $email, $hashed_password, $guid,$browser,$platform,$ipaddress);
        if ($stmt->execute()) {
            header("Location: login-signup-resume.html?message=". urlencode("Signup Successfully") . "&type=success");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}
$conn->close();
?>
