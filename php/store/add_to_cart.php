<?php
session_start();
include '../config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: ../auth/login/login.php');
  exit();
}

// Check if productId is provided via GET
$productId = $_GET['productId'] ?? null;

if (!$productId) {
  echo "ID do produto não foi especificado!";
  exit();
}

// Fetch the product info from the database
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if a session in the cart already exists
if ($product) {
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  // Add the product to the cart session
  // If the product already exists in the cart, increase the quantity
  if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity']++;
  } else {
    $_SESSION['cart'][$productId] = [
      'id' => $product['id'],
      'name' => $product['name'],
      'price' => $product['price'],
      'quantity' => 1
    ];
  }

  header('Location: cart.php');
  exit();
} else {
  echo "O produto selecionado não foi encontrado!";
}
