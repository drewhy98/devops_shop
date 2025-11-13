<?php
// =====================================================
// ShopSphere - User Registration Processor
// =====================================================

// Database connection settings (Azure SQL)
$serverName = "tcp:drewcardiffmet.database.windows.net,1433";
$connectionOptions = [
    "Database" => "myDatabase",
    "Uid" => "myadmin",
    "PWD" => "Abcdefgh0!",
    "Encrypt" => 1,
    "TrustServerCertificate" => 0
];

// =====================================================
// Handle Form Submission
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize & validate inputs
    $name     = trim($_POST['name'] ?? '');
    $email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    if (empty($name) || empty($email) || empty($password)) {
        header("Location: register.php?error=" . urlencode("Please fill in all required fields."));
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: register.php?error=" . urlencode("Please enter a valid email address."));
        exit();
    }

    // Connect to database
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if (!$conn) {
        $errors = sqlsrv_errors();
        $errorMessage = "Database connection failed.";
        if ($errors) {
            foreach ($errors as $error) {
                $errorMessage .= " " . $error['message'];
            }
        }
        header("Location: register.php?error=" . urlencode($errorMessage));
        exit();
    }

    // Check if email already exists
    $checkSql = "SELECT email FROM shopusers WHERE email = ?";
    $checkStmt = sqlsrv_query($conn, $checkSql, [$email]);

    if ($checkStmt && sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)) {
        sqlsrv_free_stmt($checkStmt);
        sqlsrv_close($conn);
        header("Location: register.php?error=" . urlencode("This email is already registered."));
        exit();
    }
    sqlsrv_free_stmt($checkStmt);

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $insertSql = "INSERT INTO shopusers (name, email, password) VALUES (?, ?, ?)";
    $params = [$name, $email, $hashedPassword];
    $stmt = sqlsrv_query($conn, $insertSql, $params);

    if ($stmt) {
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        header("Location: success.php");
        exit();
    } else {
        $errors = sqlsrv_errors();
        $errorMessage = "Registration failed.";
        if ($errors) {
            foreach ($errors as $error) {
                $errorMessage .= " " . $error['message'];
            }
        }
        header("Location: register.php?error=" . urlencode($errorMessage));
        exit();
    }

} else {
    // Redirect if accessed directly
    header("Location: register.php");
    exit();
}
?>
