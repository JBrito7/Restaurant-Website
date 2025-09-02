<?php
// JSON response header
header('Content-Type: application/json');

// Includes the configuration file for the database connection
session_start();
include '../../config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Receive form data
  $username = htmlspecialchars(trim($_POST['username']));
  $email = htmlspecialchars(trim($_POST['email']));
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];
  $avatar = $_POST['profile_pic'] ?? 'avatar1.png';
  $phone = htmlspecialchars(trim($_POST['phone']));
  $address = htmlspecialchars(trim($_POST['address']));

  // Validate the username
  if (strlen($username) < 3) {
    $response['message'] = 'Username must be at least 3 characters long.';
    echo json_encode($response);
    exit;
  }

  // Validate the email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Please enter a valid email address.';
    echo json_encode($response);
    exit;
  }

  // Validate the password
  if (strlen($password) < 6) {
    $response['message'] = 'Password must be at least 6 characters long.';
    echo json_encode($response);
    exit;
  }

  // Check if the password and confirm password match
  if ($password !== $confirmPassword) {
    $response['message'] = 'Passwords do not match.';
    echo json_encode($response);
    exit;
  }

  // Validate the phone number (optional: checks for numbers only and valid format)
  if (!preg_match("/^\+?[0-9]{10,15}$/", $phone)) {
    $response['message'] = 'Please enter a valid phone number.';
    echo json_encode($response);
    exit;
  }

  // Validate the address
  if (empty($address)) {
    $response['message'] = 'Please enter your address.';
    echo json_encode($response);
    exit;
  }

  // Check if the username or email already exists in the database
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ? OR email = ?');
  $stmt->execute([$username, $email]);
  $userExists = $stmt->fetchColumn() > 0;

  // If the username already exists
  if ($userExists) {
    $response['message'] = 'Username or email is already in use.';
    echo json_encode($response);
    exit;
  }

  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Insert the new user into the database, including the new fields
  $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, avatar, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
  $success = $stmt->execute([$username, $email, $hashedPassword, $avatar, $phone, $address]);

  // If the user was successfully inserted into the database
  if ($success) {
    $response['success'] = true;
    $response['message'] = 'Registration successful.';
  } else {
    $response['message'] = 'Error registering the user.';
  }

  echo json_encode($response);
  exit;
}
?>