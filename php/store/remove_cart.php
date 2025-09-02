<?php
session_start();
include '../config.php';

// Get the user id from the session
if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];

  // Check if the cart session exists
  if (isset($_SESSION['cart'][$id])) {

    // If the quantity of the item is greater than 1, decrease the quantity by 1, otherwise remove the item from the cart
    if ($_SESSION['cart'][$id]['quantity'] > 1) {
      $_SESSION['cart'][$id]['quantity']--;
    } else {
      unset($_SESSION['cart'][$id]);
    }
  }
}

header("Location: cart.php");
exit();
?>