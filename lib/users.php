<?php
require_once 'db.php';

function getUserById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
function getAdminUser() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE is_admin = 1 LIMIT 1");
    $stmt->execute();
    return $stmt->fetch();
}
function getUserByUsername($username) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch();
}

function createUser($username, $password, $email, $isAdmin = false) {
    global $pdo;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, is_admin) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$username, $hashedPassword, $email, $isAdmin]);
}

function updateUser($id, $username, $email, $isAdmin) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, is_admin = ? WHERE id = ?");
    return $stmt->execute([$username, $email, $isAdmin, $id]);
}

function deleteUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}

function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}
function isUserAdmin($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch();
    return $result && $result['is_admin'] == 1;
}
function registerUser($username, $email, $password, $is_admin = 0) {
    global $pdo;
    
    // Kiểm tra xem username đã tồn tại chưa
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        return "Tên đăng nhập đã tồn tại";
    }
    
    // Kiểm tra xem email đã tồn tại chưa
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return "Email đã tồn tại";
    }
    
    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Thêm user mới vào database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashed_password, $is_admin])) {
        return true;
    } else {
        return "Đăng ký thất bại. Vui lòng thử lại.";
    }
}