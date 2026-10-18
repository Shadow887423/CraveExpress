<?php
// Backend/signup.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

require_once __DIR__ . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName      = trim($_POST['fullName'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $plainPassword = trim($_POST['password'] ?? '');

    // Validation
    if (empty($fullName) || empty($email) || empty($plainPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }

    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // 1. Try SQL Server if connected
    if ($conn !== false) {
        // Check if email already exists
        $checkSql = "SELECT Email FROM Users WHERE Email = ?";
        $checkStmt = sqlsrv_query($conn, $checkSql, array($email));
        if ($checkStmt !== false && sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)) {
            echo json_encode(['status' => 'error', 'message' => 'An account with this email already exists.']);
            sqlsrv_free_stmt($checkStmt);
            sqlsrv_close($conn);
            exit;
        }

        $sql = "INSERT INTO Users (FullName, Email, PhoneNumber, PasswordHash) VALUES (?, ?, ?, ?)";
        $params = array($fullName, $email, $phone, $hashedPassword);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt !== false) {
            // Retrieve created UserID
            $idSql = "SELECT @@IDENTITY AS NewID";
            $idStmt = sqlsrv_query($conn, $idSql);
            $newId = 1;
            if ($idStmt !== false && ($idRow = sqlsrv_fetch_array($idStmt, SQLSRV_FETCH_ASSOC))) {
                $newId = $idRow['NewID'];
            }

            $_SESSION['user_id'] = $newId;
            $_SESSION['user_name'] = $fullName;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_phone'] = $phone;

            echo json_encode(['status' => 'success', 'message' => 'Account created successfully!']);
            sqlsrv_close($conn);
            exit;
        } else {
            // If DB insert failed
            $errors = sqlsrv_errors();
            $errMessage = 'Database insertion failed.';
            if (!empty($errors)) {
                $errMessage = $errors[0]['message'] ?? $errMessage;
            }
            echo json_encode(['status' => 'error', 'message' => $errMessage]);
            sqlsrv_close($conn);
            exit;
        }
    }

    // 2. Fallback for testing when DB is offline
    if (!isset($_SESSION['registered_users'])) {
        $_SESSION['registered_users'] = [];
    }

    $_SESSION['registered_users'][$email] = [
        'UserID' => count($_SESSION['registered_users']) + 1,
        'FullName' => $fullName,
        'Email' => $email,
        'PhoneNumber' => $phone,
        'PasswordHash' => $hashedPassword
    ];

    $_SESSION['user_id'] = $_SESSION['registered_users'][$email]['UserID'];
    $_SESSION['user_name'] = $fullName;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_phone'] = $phone;

    echo json_encode(['status' => 'success', 'message' => 'Account created successfully!']);
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>