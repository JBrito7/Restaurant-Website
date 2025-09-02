<?php
session_start();
include '../config.php';

// Verify if product_id was provided via GET
if (!isset($_GET['product_id'])) {
  echo "ID do produto não fornecido.";
  exit();
}

$product_id = $_GET['product_id'];

// Fecth the product data from the data base
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$product_id]);
$product = $stmt->fetch();

// Check if the product exists
if (!$product) {
  echo "Produto não encontrado.";
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $stock = $_POST['stock'];
  $image = $_FILES['image'];

  // Validate the product data for the stock and price
  if (!is_numeric($price) || !is_numeric($stock)) {
    echo "Preço e estoque devem ser números válidos.";
    exit();
  }

  // Upload the product image
  $image_name = $product['image'];
  if ($image['error'] === UPLOAD_ERR_OK) {
    // Generate a unique name for the image
    $image_name = time() . '_' . basename($image['name']);
    $target_dir = '../../img/store/';
    move_uploaded_file($image['tmp_name'], $target_dir . $image_name);

    // Delete the old image if a new one is uploaded
    unlink($target_dir . $product['image']);
  }

  // Update the new data given in the data base
  $sql = "UPDATE products SET name = ?, description = ?, price = ?, image = ?, stock = ? WHERE id = ?";
  $stmt = $pdo->prepare($sql);

  // Verify if the statement was executed successfully
  if ($stmt->execute([$name, $description, $price, $image_name, $stock, $product_id])) {
    header("Location: admin.php");
    exit();
  } else {
    echo "Erro ao editar o produto.";
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
    <section id="edit-product-section">
      <div class="container edit-product">
        <h1 class="heading-color">Editar Produto</h1>

        <form method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">Nome do Produto:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
          </div>

          <div class="form-group">
            <label for="description">Descrição:</label>
            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
          </div>

          <div class="form-group">
            <label for="price">Preço (€):</label>
            <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
          </div>

          <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
          </div>

          <div class="form-group">
            <label for="image">Imagem do Produto: (Deixar em branco para manter a mesma imagem)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <br>
            <img src="../../img/store/<?php echo htmlspecialchars($product['image']); ?>" alt="Imagem do Produto Atual" id="image-preview">
          </div>
          <div class="buttons-container">
          <button type="submit" class="btn-color">Atualizar</button>
          <a href="admin.php" class="btn-color">Voltar</a>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>
<html>