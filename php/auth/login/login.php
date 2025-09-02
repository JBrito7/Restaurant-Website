<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

  <!-- jQuery Script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
  <link rel="stylesheet" href="../../../css/login.css">

  <title>Morgane Cocktail Bar</title>
</head>
<body>
  <header>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="../../../index.html">
          <img src="../../../img/logo-white-resto.png" alt="Logo Morgane de toi. Letter M">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../../../index.html">HOME</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../../pages/menu.html">MENU</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../../pages/reserv-contact.html">RESERVAS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../../pages/about-us.html">SOBRE NÓS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../../pages/gallery.html">GALERIA</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../../../pages/store.php">BOUTIQUE</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <hr class="hr-color">

    <main>
      <section id="login-section">
        <div class="container">
          <div class="row">
            <div class="login-title">
              <h1 class="heading-color">Login</h1>
            </div>

            <div class="form-container col-md-8 col-lg-6 mx-auto">

              <!-- Exibe aqui uma mensagem de erro em caso de falha no Login -->
              <?php
              if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
                // Limpar a mesagem após a sua exibição
                unset($_SESSION['error']);
              }
              ?>

              <form action="process_login.php" method="post" id="login-form" class="mb-4">
                <div class="mb-3">
                  <label for="username" class="form-label">Username:</label>
                  <input type="text" name="username" id="username" class="form-control" required autocomplete="username">
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Password:</label>
                  <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
                </div>

                <div class="mb-3">
                  <p class="register-link">Ainda não tem uma conta? <a href="../register/register.php">Registe-se</a></p>
                </div>

                <input type="submit" class="btn-color" value="Login">
              </form>
            </div>
          </div>
        </div>
      </section>
    </main>

    <hr class="hr-color">

    <footer>
      <section>
        <!-- Social Media -->
        <div class="container text-center">
          <div class="row align-items-center">
            <div class="col-md-4 col-12 mb-md-0">
              <div class="social-media-title">
                <h3 class="title-color">Siga-nos nas Redes Sociais</h3>
              </div>
              <div class="media-icon">
                <a
                  href="https://www.instagram.com/morganataormina/"
                  class="link-icon"
                  target="_blank"
                  rel="noopener"
                  title="Instagram Morgane de toi"
                  ><i class="fa-brands fa-instagram"></i>
                </a>
                <a
                  href="https://www.facebook.com/MorganaTaormina/?locale=pt_BR"
                  class="link-icon"
                  target="_blank"
                  rel="noopener"
                  title="Facebook Morgane de toi"
                  ><i class="fa-brands fa-square-facebook"></i>
                </a>
                <a
                  href="https://web.whatsapp.com/"
                  class="link-icon"
                  target="_blank"
                  rel="noopener"
                  title="WhatsApp Morgane de toi"
                  ><i class="fa-brands fa-whatsapp"></i>
                </a>
              </div>

              <hr class="hr-color" />

              <!-- Job Application -->
              <div class="join-us">
                <div class="join-us-title">
                  <h3 class="title-color">Junta-te a nós!</h3>
                  <p>
                    Acreditamos em uma equipa diversa e inovadora. Envia o teu
                    currículo e junte-te à nós nesta missão.
                  </p>
                </div>
                <div class="input-group mb-3">
                  <input
                    type="file"
                    class="form-control"
                    id="inputGroupFile02">
                  <label
                    class="input-group-text btn-color"
                    for="inputGroupFile02"
                    >Enviar</label>
                </div>
              </div>
            </div>

            <!-- Logo e Copyrights -->
            <div class="col-md-4 col-12 mb-4 mb-md-0">
              <div class="logo-box">
                <img
                  src="../../../img/logo-white-resto.png"
                  alt="Morgane de toi logo"
                  class="img-fluid">
                <p>
                  <strong>&copy; 2025 All Rights Reserved Morgane de Toi Lda.</strong>
                </p>
              </div>
            </div>

            <!-- Contact|Schedule|Adress -->
            <div class="col-md-4 col-12 mb-4 mb-md-0">
              <div class="contact-title">
                <h3 class="title-color">Contactos</h3>
              </div>
              <div class="contact-text">
                <ul>
                  <li><strong>Telefone:</strong> +33 987 654 321</li>
                  <li><strong>E-mail:</strong> morganedetoievents@info.com</li>
                  <li><strong>Morada:</strong> 78, Rue de Paris 2234</li>
                  <li><strong>Horário:</strong> 7/7 | 18:00 - 01:00</li>
                </ul>
              </div>

              <!-- GPS -->
              <div class="embed-responsive embed-responsive-16by9">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.317072108384!2d2.2987466258194247!3d48.8712317998036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66fc20420536f%3A0x20e94b9f4c065438!2sBrasserie%20Fouquet&#39;s%20Paris!5e0!3m2!1spt-PT!2slu!4v1736345051738!5m2!1spt-PT!2slu"
                  title="Localização do restaurante"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="origin">
                </iframe>
              </div>
            </div>
          </div>
        </div>
      </section>
    </footer>

    <!-- Bootstrap Script -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous">
    </script>
  </body>
</html>