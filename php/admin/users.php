<?php
session_start();
include '../config.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
  header('Location: ../auth/login/login.php');
  exit();
}

// Delete user account
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];

  // Delete user account from data base
  $sql = "DELETE FROM users WHERE id = ?";
  $stmt = $pdo->prepare($sql);

  // Verify if the statemente was executed successfully
  if ($stmt->execute([$user_id])) {
    // Reedirect to admin page if deletion was successful
    header("Location: admin.php");
    exit();
  } else {
    // Show error message if deletion was not well executed
    echo "Erro ao excluir o usuário.";
  }
}

// Fetch all users from the database
$sql = "SELECT id, username, email, user_type, avatar, address, phone FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();
?>

<section>
  <div class="container text-center">
    <h1>Gestão de Utilizadores</h1>

    <a href="add_user.php" class="btn-color">Adicionar Novo Usuário</a>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Avatar</th>
            <th>Morada</th>
            <th>Telefone</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr>
              <td><?php echo htmlspecialchars($user['id']); ?></td>
              <td><?php echo htmlspecialchars($user['username']); ?></td>
              <td><?php echo htmlspecialchars($user['email']); ?></td>
              <td><?php echo htmlspecialchars($user['user_type']); ?></td>
              <td>
                <img src="../../img/avatar/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" width="50" height="50" class="rounded-circle">
              </td>
              <td><?php echo htmlspecialchars($user['address']); ?></td>
              <td><?php echo htmlspecialchars($user['phone']); ?></td>
              <td>
                <!-- Edit user info -->
                <a href="edit_user.php?user_id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm mb-3 d-block">Editar</a>

                <!-- Delete user from data base -->
                <a href="users.php?action=delete&user_id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm d-block" onclick="return confirm('Confirma que deseja excluir o usuário?')">Excluir</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>