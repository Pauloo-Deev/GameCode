<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/register.css" />
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
          <form
            class="form"
            action="../php/register.php"
            method="post"
            id="registrationForm"
          >
            <h2>Criar Conta</h2>
            <div class="input-group">
              <ul class="select-type">
                <li>
                  <button class="select-button" type="button" value="student">
                    Aluno
                  </button>
                </li>
                <li>
                  <button class="select-button" type="button" value="teacher">
                    Professor
                  </button>
                </li>
                <li>
                  <button
                    class="select-button"
                    type="button"
                    value="institution"
                  >
                    Instituição
                  </button>
                </li>
              </ul>
            </div>
            <div class="formContent" id="formContent">
              <!-- Conteúdo será exibido aqui -->
            </div>
            <input
              class="button-login"
              type="submit"
              id="criar"
              name="criar"
              value="Criar"
            />
            <div class="redirect">
              <a href="./login.html">Login</a>
            </div>
          </form>
          <div class="contentText">
            <h1 class="title">
              Até os melhores programadores já foram iniciantes!
            </h1>
            <p class="text">A chave é continuar aprendendo e nunca desistir.</p>
          </div>
        </section>
      </main>
    </div>
    <script src="../js/register.js"></script>
  </body>
</html>
