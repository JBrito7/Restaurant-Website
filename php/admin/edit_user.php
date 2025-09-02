<?php
session_start();
include '../config.php';

// AJAX response for feedback
$response = ['success' => false, 'message' => ''];

// Verify if user_id was provided via GET
if (!isset($_GET['user_id'])) {
  echo "ID do usuário não fornecido.";
  exit();
}

$user_id = $_GET['user_id'];

// Fetch the user data from the database
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Check if the user exists
if (!$user) {
  echo "Usuário não encontrado.";
  exit();
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = htmlspecialchars(trim($_POST['username']));
  $email = htmlspecialchars(trim($_POST['email']));
  $avatar = $_POST['avatar'] ?? 'avatar1.png';
  $phone = htmlspecialchars(trim($_POST['phone']));
  $address = htmlspecialchars(trim($_POST['address']));
  $user_type = htmlspecialchars(trim($_POST['user_type']));

  // Validate the user data
  if (strlen($username) < 3) {
    $response['message'] = 'O nome de usuário deve ter pelo menos 3 caracteres.';
    echo json_encode($response);
    exit;
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Digite um endereço de e-mail válido.';
    echo json_encode($response);
    exit;
  }

  if (!preg_match("/^\+?[0-9]{10,15}$/", $phone)) {
    $response['message'] = 'Digite um número de telefone válido.';
    echo json_encode($response);
    exit;
  }

  if (empty($address)) {
    $response['message'] = 'Digite o endereço.';
    echo json_encode($response);
    exit;
  }

  // Update the new data given in the data base
  $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, avatar = ?, phone = ?, address = ?, user_type = ? WHERE id = ?");
  $success = $stmt->execute([$username, $email, $avatar, $phone, $address, $user_type, $user_id]);

  // Check if the user was successfully updated
  if ($success) {
    $response['success'] = true;
    $response['message'] = 'Usuário atualizado com sucesso.';
  } else {
    $response['message'] = 'Erro ao atualizar o usuário.';
  }

  echo json_encode($response);
  exit;
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
    <section id="register-section">
      <div class="container">
        <div class="register-title">
          <h1 class="heading-color">Editar Usuário</h1>
        </div>

        <div id="error-message" class="alert alert-danger text-center d-none"></div>

        <form action="edit_user.php?user_id=<?php echo $user_id; ?>" method="post" id="register-form" class="mb-4">
          <!-- Avatar Preview -->
          <div class="mb-3 text-center">
            <img id="avatarPreview" src="../../img/avatar/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Pré-visualização do avatar">
          </div>

          <div class="mb-3">
            <label for="avatar" class="form-label">Escolhe um Avatar:</label>
            <select name="avatar" id="avatar" class="form-select" onchange="updateAvatarPreview()">
              <option value="avatar1.png" <?php echo ($user['avatar'] == 'avatar1.png') ? 'selected' : ''; ?>>Avatar 1</option>
              <option value="avatar2.png" <?php echo ($user['avatar'] == 'avatar2.png') ? 'selected' : ''; ?>>Avatar 2</option>
              <option value="avatar3.png" <?php echo ($user['avatar'] == 'avatar3.png') ? 'selected' : ''; ?>>Avatar 3</option>
              <option value="avatar4.png" <?php echo ($user['avatar'] == 'avatar4.png') ? 'selected' : ''; ?>>Avatar 4</option>
              <option value="avatar5.png" <?php echo ($user['avatar'] == 'avatar5.png') ? 'selected' : ''; ?>>Avatar 5</option>
              <option value="avatar6.png" <?php echo ($user['avatar'] == 'avatar6.png') ? 'selected' : ''; ?>>Avatar 6</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label">Telefone:</label>
            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Morada:</label>
            <input type="text" name="address" id="address" class="form-control" value="<?php echo htmlspecialchars($user['address']); ?>" required>
          </div>

          <div class="mb-3">
            <label for="user_type" class="form-label">Tipo de Usuário:</label>
            <select name="user_type" id="user_type" class="form-select" required>
              <option value="client" <?php echo ($user['user_type'] == 'client') ? 'selected' : ''; ?>>Cliente</option>
              <option value="admin" <?php echo ($user['user_type'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
            </select>
          </div>

          <input type="submit" class="btn-color" value="Atualizar">
          <a href="admin.php" class="btn-color">Voltar</a>
        </form>
      </div>
    </section>
  </main>

  <script>
    function updateAvatarPreview() {
      const selectedAvatar = document.getElementById('avatar').value;
      document.getElementById('avatarPreview').src = `../../img/avatar/${selectedAvatar}`;
    }

    // Send form data via AJAX
    $('#register-form').submit(function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      $.ajax({
        url: 'edit_user.php?user_id=<?php echo $user_id; ?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            window.location.href = 'admin.php';
          } else {
            $('#error-message').removeClass('d-none alert-success').addClass('alert-danger').html(response.message);
          }
        },
        error: function() {
          $('#error-message').text('Erro ao processar a edição.');
        }
      });
    });
  </script>
</body>

</html>