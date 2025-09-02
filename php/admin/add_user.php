<?php
session_start();
include '../config.php';

// AJAX response for feedback
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = htmlspecialchars(trim($_POST['username']));
  $email = htmlspecialchars(trim($_POST['email']));
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];
  $avatar = $_POST['avatar'] ?? 'avatar1.png';
  $phone = htmlspecialchars(trim($_POST['phone']));
  $address = htmlspecialchars(trim($_POST['address']));
  $user_type = htmlspecialchars(trim($_POST['user_type']));

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

  // Validate the phone number
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

  // Validate the user type (can be "client" or "admin")
  if (!in_array($user_type, ['client', 'admin'])) {
    $response['message'] = 'Invalid user type.';
    echo json_encode($response);
    exit;
  }

  // Check if the username or email already exists in the database
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ? OR email = ?');
  $stmt->execute([$username, $email]);
  $userExists = $stmt->fetchColumn() > 0;

  // If the username already exists display an error message
  if ($userExists) {
    $response['message'] = 'Username or email is already in use.';
    echo json_encode($response);
    exit;
  }

  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Insert the new user into the database, including the new fields
  $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, avatar, phone, address, user_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $success = $stmt->execute([$username, $email, $hashedPassword, $avatar, $phone, $address, $user_type]);

  // Check if the user was successfully registered
  if ($success) {
    $response['success'] = true;
    $response['message'] = 'Registration successful.';
  } else {
    $response['message'] = 'Error registering the user.';
  }

  echo json_encode($response);
  exit();
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
        <div class="row">
          <div class="register-title">
            <h1 class="heading-color">Adicionar Novo Usuário</h1>
          </div>

          <!-- Div that show the error message -->
          <div id="error-message" class="alert alert-danger text-center d-none"></div>

          <div class="form-container col-md-8 col-lg-6 mx-auto">
            <form action="add_user.php" method="post" id="register-form" class="mb-4">

              <!-- Avatar Preview -->
              <div class="mb-3 text-center">
                <img id="avatarPreview" src="../../img/avatar/avatar1.png" alt="Pré-visualização do avatar">
              </div>

              <!-- Avatar Selection -->
              <div class="mb-3">
                <label for="avatar" class="form-label">Escolhe um avatar:</label>
                <select name="avatar" id="avatar" class="form-select" onchange="updateAvatarPreview()">
                  <option value="avatar1.png">Avatar 1</option>
                  <option value="avatar2.png">Avatar 2</option>
                  <option value="avatar3.png">Avatar 3</option>
                  <option value="avatar4.png">Avatar 4</option>
                  <option value="avatar5.png">Avatar 5</option>
                  <option value="avatar6.png">Avatar 6</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required autocomplete="username">
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" required autocomplete="email">
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
              </div>

              <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required autocomplete="new-password">
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">Telefone:</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="address" class="form-label">Morada:</label>
                <input type="text" name="address" id="address" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="user_type" class="form-label">Tipo de Usuário:</label>
                <select name="user_type" id="user_type" class="form-select" required>
                  <option value="client">Cliente</option>
                  <option value="admin">Administrador</option>
                </select>
              </div>

              <input type="submit" class="btn-color" value="Registar">
              <a href="admin.php" class="btn-color">Voltar</a>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <script>
    // Change the Avatar Preview for the one selected
    function updateAvatarPreview() {
      const selected = document.getElementById('avatar').value;
      document.getElementById('avatarPreview').src = `../../img/avatar/${selected}`;
    }

    // Send form data via AJAX
    $('#register-form').submit(function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      $.ajax({
        url: 'add_user.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            // If registration is successful, redirect to admin page
            window.location.href = 'admin.php';
          } else {
            // Else show the error message in the div
            $('#error-message').removeClass('d-none alert-success').addClass('alert-danger').html(response.message);
          }
        },
        error: function() {
          $('#error-message').text('Erro ao processar o registro.');
        }
      });
    });
  </script>
</body>

</html>