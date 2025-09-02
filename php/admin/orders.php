<?php
session_start();
include '../config.php';

// Delete order from data base
if (isset($_POST['delete_order_id'])) {
  $order_id = $_POST['delete_order_id'];

  $sql = "DELETE FROM orders WHERE id = ?";
  $stmt = $pdo->prepare($sql);

  // If the order is deleted sucessfully
  if ($stmt->execute([$order_id])) {
    echo "deleted";
  } else {
    echo "error";
  }
  exit();
}

// Update the order status
if (isset($_POST['order_id']) && isset($_POST['status'])) {
  $order_id = $_POST['order_id'];
  $status = $_POST['status'];

  $sql = "UPDATE orders SET status = ? WHERE id = ?";
  $stmt = $pdo->prepare($sql);

  // If the order status is updated sucessfully
  if ($stmt->execute([$status, $order_id])) {
    echo "success";
  } else {
    echo "error";
  }
  exit();
}

// Fetch all orders from the data base
$sql = "SELECT orders.id, orders.user_id, orders.total_price, orders.status, orders.order_date, users.username, users.address 
        FROM orders 
        JOIN users ON orders.user_id = users.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll();
?>

<section>
  <div class="container text-center">
    <h1>Gestão das Encomendas</h1>

    <!-- Tabela de pedidos -->
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Morada</th>
            <th>Total</th>
            <th>Status</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order): ?>
            <tr>
              <td><?php echo htmlspecialchars($order['id']); ?></td>
              <td><?php 
                  // Fecth the data of the user who made the order and the order data
                  $sql_user = "SELECT username FROM users WHERE id = ?";
                  $stmt_user = $pdo->prepare($sql_user);
                  $stmt_user->execute([ $order['user_id'] ]);
                  $user = $stmt_user->fetch();
                  echo htmlspecialchars($user['username']); 
                ?></td>
              <td><?php echo htmlspecialchars($order['address']); ?></td>
              <td><?php echo '€' . number_format($order['total_price'], 2, ',', '.'); ?></td>
              <td>
                <form action="orders.php" method="POST" class="update-order-status">
                  <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                  <select name="status" class="form-select" required>
                    <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pendente</option>
                    <option value="completed" <?php echo ($order['status'] == 'completed') ? 'selected' : ''; ?>>Concluída</option>
                  </select>
                  <button type="submit" class="btn-color btn-sm m-3">Atualizar</button>
                </form>
              </td>
              <td><?php echo htmlspecialchars($order['order_date']); ?></td>
              <td>
                <!-- Excluir -->
<button class="btn btn-danger btn-delete-order" data-id="<?php echo $order['id']; ?>" onclick="return confirm('Confirma que deseja excluir a encomenda?')">Excluir</button>

              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
