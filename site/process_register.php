<?php
// =====================================================
// ShopSphere - User Registration Processor (MySQL version)
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $servername = getenv('DB_SERVER') ?: 'db';
    $username   = getenv('DB_USER') ?: 'root';
    $password   = getenv('DB_PASS') ?: 'root';
    $database   = getenv('DB_NAME') ?: 'shopdb';

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        header("Location: register.php?error=" . urlencode("DB connection failed: " . $conn->connect_error));
        exit();
    }

    $name     = trim($_POST['name'] ?? '');
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $passwordInput = trim($_POST['password'] ?? '');

    if (empty($name) || empty($email) || empty($passwordInput)) {
        header("Location: register.php?error=" . urlencode("Please fill in all fields."));
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: register.php?error=" . urlencode("Invalid email address."));
        exit();
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM shopusers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header("Location: register.php?error=" . urlencode("Email already registered."));
        exit();
    }
    $stmt->close();

    // Hash and insert new user
    $hashed = password_hash($passwordInput, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO shopusers (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed);

    if ($stmt->execute()) {
        header("Location: success.php");
    } else {
        header("Location: register.php?error=" . urlencode("Registration failed: " . $conn->error));
    }

    $stmt->close();
    $conn->close();
    exit();
} else {
    header("Location: register.php");
    exit();
}
?>

