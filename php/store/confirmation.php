<?php
session_start();
include '../config.php';

// Verify if the last order ID and total price are fetch from the session
if (!isset($_SESSION['last_order_id'], $_SESSION['last_order_total'])) {
  header("Location: ../../pages/store.php");
  exit();
}

// Get the last order info drom the session
$order_id = $_SESSION['last_order_id'];
$total_price = $_SESSION['last_order_total'];

// Clear the session data for the last order and prevent reusing the same order ID
unset($_SESSION['last_order_id'], $_SESSION['last_order_total']);
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
  <main class="confirmation container text-center mt-5">
    <div class="confirmation-box">
      <h1 class="heading-color">Obrigado pela sua encomenda!</h1>
      <p class="lead">O seu pedido <strong>#<?php echo htmlspecialchars($order_id); ?></strong> foi recebido com sucesso.</p>
      <p>Total pago: <strong>€<?php echo number_format($total_price, 2, ',', '.'); ?></strong></p>

      <hr class="hr-color">

      <a href="../../pages/store.php" class="btn-color">Voltar à Loja</a>
      <a href="../auth/profile.php" class="btn-color">Ver Encomendas</a>
    </div>
  </main>

</body>

</html>