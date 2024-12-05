<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/login.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <title>Document</title>
  </head>
  <body>
    <div class="container">
      <header class="header">
        <a href="../index.html"
          ><img class="logo" src="../img/Logo.png" alt="Logo"
        /></a>
        <nav class="nav">
          <ul class="navItems">
            <li class="navItem">
              <a class="linkNav" href="../index.html">Quem Somos</a>
            </li>
            <li class="navItem">
              <a class="linkNav" href="../index.html#sectionII">Game Code</a>
            </li>
            <li class="navItem">
              <a class="linkNav" href="register.php">Criar Conta</a>
            </li>
            <li class="navItem">
              <a class="linkLogin" href="login.php">Fazer Login</a>
            </li>
          </ul>
        </nav>
      </header>
      <main class="main">
        <section class="section">
          <form class="form" action="../php/login.php" method="get">
            <h2>Login</h2>
            <div class="input-group">
              <input
                class="input-form"
                type="text"
                id="email"
                name="email"
                placeholder="E-mail"
                autocomplete="off"
              />
            </div>
            <div class="input-group">
              <input
                class="input-form"
                type="password"
                id="password"
                name="password"
                placeholder="Senha"
                autocomplete="off"
              />
            </div>
            <input class="button-login" type="submit" value="Login" />
            <div class="redirect">
              <a href="./register.html">Criar Conta</a>
              <span class="space-redirect">|</span>
              <a href="">Redifinir senha</a>
            </div>
          </form>
          <div class="contentText">
            <h1 class="title">Abrace a jornada e deixe sua imaginação voar!</h1>
            <p class="text">
              Você está prestes a entrar em um mundo de infinitas possibilidades
              criativas.
            </p>
          </div>
        </section>
      </main>
    </div>
  </body>
</html>
