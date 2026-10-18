<?php
// Backend/update_profile.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/db_connect.php';

$userId = $_SESSION['user_id'] ?? null;
$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') 
    || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'update_profile';

    if ($action === 'update_profile') {
        $fullName = trim($_POST['full_name'] ?? '');
        $phone = trim($_POST['phone_number'] ?? '');

        if (empty($fullName)) {
            if ($isAjax) {
                echo json_encode(['status' => 'error', 'message' => 'Full Name cannot be empty.']);
                exit;
            }
            header("Location: ../profile_settings.php?status=error&msg=Name+required");
            exit;
        }

        // Update in DB if connected
        if ($conn !== false && $userId) {
            $sql = "UPDATE Users SET FullName = ?, PhoneNumber = ? WHERE UserID = ? OR ID = ?";
            $params = array($fullName, $phone, $userId, $userId);
            sqlsrv_query($conn, $sql, $params);
            sqlsrv_close($conn);
        }

        // Update session
        $_SESSION['user_name'] = $fullName;
        $_SESSION['user_phone'] = $phone;

        if ($isAjax) {
            echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully!']);
            exit;
        }

        header("Location: ../profile_settings.php?status=success");
        exit;
    }

    if ($action === 'update_security') {
        $currentPass = $_POST['current_password'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        $confirmPass = $_POST['confirm_password'] ?? '';

        if (empty($newPass) || strlen($newPass) < 6) {
            if ($isAjax) {
                echo json_encode(['status' => 'error', 'message' => 'New password must be at least 6 characters long.']);
                exit;
            }
            header("Location: ../profile_settings.php?tab=security&status=error&msg=Password+too+short");
            exit;
        }

        if ($newPass !== $confirmPass) {
            if ($isAjax) {
                echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
                exit;
            }
            header("Location: ../profile_settings.php?tab=security&status=error&msg=Passwords+do+not+match");
            exit;
        }

        $newHash = password_hash($newPass, PASSWORD_DEFAULT);

        if ($conn !== false && $userId) {
            $sql = "UPDATE Users SET PasswordHash = ? WHERE UserID = ? OR ID = ?";
            sqlsrv_query($conn, $sql, array($newHash, $userId, $userId));
            sqlsrv_close($conn);
        }

        if ($isAjax) {
            echo json_encode(['status' => 'success', 'message' => 'Password updated successfully!']);
            exit;
        }

        header("Location: ../profile_settings.php?tab=security&status=success");
        exit;
    }

    if ($action === 'save_address') {
        $label = trim($_POST['address_label'] ?? 'Home');
        $address = trim($_POST['address_text'] ?? '');

        if (!empty($address)) {
            if (!isset($_SESSION['saved_addresses'])) {
                $_SESSION['saved_addresses'] = [];
            }
            $_SESSION['saved_addresses'][] = [
                'id' => uniqid(),
                'label' => $label,
                'address' => $address,
                'is_default' => empty($_SESSION['saved_addresses'])
            ];
        }

        if ($isAjax) {
            echo json_encode(['status' => 'success', 'message' => 'Address saved successfully!']);
            exit;
        }

        header("Location: ../profile_settings.php?tab=addresses&status=success");
        exit;
    }
}

header("Location: ../profile_settings.php");
exit;
?>
