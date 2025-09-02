<?php
session_start();
include '../config.php';

// Delete product from data base
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['product_id'])) {
  $product_id = $_GET['product_id'];

  $sql = "DELETE FROM products WHERE id = ?";
  $stmt = $pdo->prepare($sql);

  // Verify if the statement was executed successfully
  if ($stmt->execute([$product_id])) {
    header("Location: products.php");
    exit();
  } else {
    echo "Erro ao excluir o produto.";
  }
}

// Fetch all products from the data base
$sql = "SELECT id, name, description, price, image, stock FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();
?>

<section>
  <div class="container text-center">
    <h1>Gestão de Produtos</h1>

    <!-- Button to add new product -->
    <a href="add_product.php" class="btn-color">Adicionar Novo Produto</a>

    <!-- Products Table -->
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Imagem</th>
            <th>Estoque</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product): ?>
            <tr>
              <td><?php echo htmlspecialchars($product['id']); ?></td>
              <td><?php echo htmlspecialchars($product['name']); ?></td>
              <td><?php echo htmlspecialchars($product['description']); ?></td>
              <td><?php echo '€' . number_format($product['price'], 2, ',', '.'); ?></td>
              <td>
                <img src="../../img/store/<?php echo htmlspecialchars($product['image']); ?>" alt="Imagem do Produto" width="50" height="50">
              </td>
              <td><?php echo htmlspecialchars($product['stock']); ?></td>
              <td>
                <!-- Edit -->
                <a href="edit_product.php?product_id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm mb-3">Editar</a>

                <!-- Delete -->
                <a href="products.php?action=delete&product_id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Confirma que deseja excluir o produto?')">Excluir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>