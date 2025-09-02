<?php
session_start();
include '../config.php';

// verify if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // if not logged in redirect to the login page
  header("Location: login.php");
  exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Verify if the cart session exists and is not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
  header("Location: cart.php");
  exit();
}

// Fetch the products that are in the cart
// Calculate the total price of the products
$products = $_SESSION['cart'];
$total_price = 0;

foreach ($products as $product) {
  $total_price += $product['price'] * $product['quantity'];
}

// Submission of the checkout form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $address = $_POST['address'] ?? '';
  $phone = $_POST['phone'] ?? '';

  // Validate the form data
  if (empty($address) || empty($phone)) {
    $error_message = "Por favor, preencha todos os campos.";
  } else {
    // INsert the order into the data base and link it to the user with the status 'pending'
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'pending')");
    $stmt->execute([$user_id, $total_price]);
    $order_id = $pdo->lastInsertId();

    // Insert the order itemns into the order_items table in the data base
    foreach ($products as $product) {
      $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
      $stmt->execute([$order_id, $product['id'], $product['quantity'], $product['price']]);
    }

    // Clean the cart session after the order is placed sucessfully
    unset($_SESSION['cart']);

// Store the last order ID and total price for the confirmation.php
$_SESSION['last_order_id'] = $order_id;
$_SESSION['last_order_total'] = $total_price;

// Redirect to the confirmation page after the order is placed and saved in the data base sucessfully
header("Location: confirmation.php");
exit();
}
}
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta
    name="description"
    content="Descubra o Morgane de toi, um cocktail bar único que combina mixologia criativa com a sofisticação da fusion French cuisine. Um ambiente elegante para desfrutar de coquetéis artesanais e uma experiência gastronômica inesquecível.">
  <meta
    name="keywords"
    content="cocktail bar, Morgane de toi, French cuisine, fusion cuisine, mixology, fine dining, bar elegante, cocktails artesanais, cozinha francesa moderna, gastronomia, bar exclusivo, coquetéis premium, experiência gourmet">
  <meta name="author" content="Morgane de toi Cocktail Bar">

  <!-- Bootstrap Script -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">

  <!-- JQuery / Ajax Script -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Unica+One&display=swap"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- CSS File -->
  <link rel="stylesheet" href="../../css/admin.css">

  <title>Morgane Cocktail Bar</title>
</head>

<body>
  <main>
    <section class="checkout">
      <?php if (isset($error_message)): ?>
        <div class="alert alert-danger">
          <?php echo $error_message; ?>
        </div>
      <?php endif; ?>

      <form action="checkout.php" method="POST">
        <h1 class="heading-color">Finalizar a sua Compra</h1>
        <div class="form-group">
          <label for="address">Nome:</label>
          <input type="text" name="name" id="name" class="form-control" placeholder="Insira o seu nome completo" required>
        </div>
        <div class="form-group">
          <label for="address">Morada:</label>
          <input type="text" name="address" id="address" class="form-control" placeholder="Insira a sua morada completa" required>
        </div>
        <div class="form-group">
          <label for="phone">Telefone:</label>
          <input type="text" name="phone" id="phone" class="form-control" placeholder="Insira o seu contacto telefónico" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="Insira o seu e-mail" required>
        </div>

        <hr class="hr-color">

        <h2 class="heading-color">Resumo do seu Pedido</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Produto</th>
              <th>Preço</th>
              <th>Quantidade</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $total = 0;
            foreach ($products as $product):
              $preco = (float) $product['price'];
              $quantidade = (int) $product['quantity'];
              $subtotal = $preco * $quantidade;
              $total += $subtotal;
            ?>
              <tr>
                <td> <?php echo htmlspecialchars($product['name']); ?> </td>
                <td> <?php echo number_format($preco, 2, ',', '.'); ?> </td>
                <td> <?php echo $quantidade; ?> </td>
                <td> <?php echo number_format($subtotal, 2, ',', '.'); ?> </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="form-group">
          <label for="total_price">Total: </label>
          <input type="text" name="total_price" id="total_price" class="form-control" value="€<?php echo number_format($total_price, 2, ',', '.'); ?>" disabled>
        </div>

        <button type="submit" class="btn-color">Confirmar Pedido</button>
        <a href="./cart.php" class="btn-color">Voltar</a>
      </form>
    </section>
  </main>

</body>

</html>