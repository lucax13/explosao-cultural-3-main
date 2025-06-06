<?php

use ExplosaoCultural\Helpers\Utils;
use ExplosaoCultural\Services\EventoServico;
use ExplosaoCultural\Services\GeneroServico;

require_once "vendor/autoload.php";

$eventoServico = new EventoServico();
$listaDeEventos = $eventoServico->listarTodos();

$generoServico = new GeneroServico();
$listaDeGeneros = $generoServico->listarTodos();

?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Explosão Cultural</title>
  <link rel="shortcut icon" href="images/logotipo2.png" type="image/png" sizes="64x64">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/estilo.css">
</head>

<body class="bg-light text-dark">
  <header class="bg-light p-3">
    <div class="container d-flex justify-content-between align-items-center">
      <h1 class="m-0">
        <a href="index.php" class="text-light text-decoration-none">
          <img class="logotipo" src="images/logo2.png" alt="Logotipo">
        </a>
      </h1>
      <nav class="navbar navbar-expand-lg navbar-light bg-ligth">
        <div class="container">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav" aria-controls="menuNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse justify-content-center" id="menuNav">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                <a class="nav-link text-black" href="index.php">Home</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-black" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Gêneros
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php foreach ($listaDeGeneros as $generos) { ?>
                    <li>
                      <a class="dropdown-item" href="generos.php?tipo=<?= htmlspecialchars($generos['id']) ?>">
                        <?= htmlspecialchars($generos['tipo']) ?>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link text-black" href="cria-conta.php">Cadastro</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-black" href="login.php">Login</a>
              </li>
            </ul>

            <div class="position-relative ms-lg-3">
              <form autocomplete="off" class="d-flex" action="resultados.php" method="POST" id="form-busca">
                <input id="campo-busca" name="busca" class="form-control me-2" type="search" placeholder="Pesquise aqui" aria-label="Pesquise aqui">
              </form>
              <div id="resultados" role="region" aria-live="polite" class="mt-3 position-absolute container bg-white shadow-lg p-3 rounded"></div>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <hr>
  </header>

  <main class="container my-5 bg-light text-dark rounded p-4 shadow">

    <section class="container py-5">
      <h2 class="text-dark mb-4">Eventos em Destaque</h2>

      <div id="carouselEventos" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="d-flex gap-3">
              <div class="card bg-secondary text-light" style="min-width: 300px;">
                <img src="https://source.unsplash.com/400x250/?music" class="card-img-top" alt="Evento 1">
                <div class="card-body">
                  <h5 class="card-title">Show Indie</h5>
                  <p class="card-text">Dia 10 de Junho - Centro Cultural</p>
                </div>
              </div>
              <div class="card bg-secondary text-light" style="min-width: 300px;">
                <img src="https://source.unsplash.com/400x250/?party" class="card-img-top" alt="Evento 2">
                <div class="card-body">
                  <h5 class="card-title">Festa Black</h5>
                  <p class="card-text">Dia 15 de Julho - Arena Norte</p>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="d-flex gap-3">
              <div class="card bg-secondary text-light" style="min-width: 300px;">
                <img src="https://source.unsplash.com/400x250/?exhibition" class="card-img-top" alt="Evento 3">
                <div class="card-body">
                  <h5 class="card-title">Expo Arte Urbana</h5>
                  <p class="card-text">De 5 a 20 de Julho - Galeria Sul</p>
                </div>
              </div>
              <div class="card bg-secondary text-light" style="min-width: 300px;">
                <img src="https://source.unsplash.com/400x250/?dj" class="card-img-top" alt="Evento 4">
                <div class="card-body">
                  <h5 class="card-title">Noite Eletrônica</h5>
                  <p class="card-text">Dia 25 de Julho - Club 303</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselEventos" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselEventos" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </section>

    <section class="text-center mb-5">
      <h2 class="display-5 fw-bold">Eventos únicos</h2>
      <p class="lead">Shows, festas e experiências culturais em destaque</p>
    </section>

    <section class="row g-4">
      <?php foreach ($listaDeEventos as $evento) { ?>
        <div class="col-md-4">
          <div class="card bg-secondary text-light h-100">
            <img src="images/<?= htmlspecialchars($evento['imagem']) ?>" class="card-img-top" alt="<?= htmlspecialchars($evento['evento']) ?>">
            <div class="card-body">
              <h5 class="card-title">Evento: <?= htmlspecialchars($evento['evento']) ?></h5>
              <p class="card-text">Data do evento: <?= htmlspecialchars($evento['data_evento']) ?></p>
              <p class="card-text">Horário: <?= htmlspecialchars($evento['horario']) ?></p>
              <p class="card-text">Classificação indicativa: <?= htmlspecialchars($evento['classificacao']) ?></p>
              <p class="card-text">Telefone: <?= htmlspecialchars($evento['telefone']) ?></p>
              <p class="card-text">Descrição: <?= htmlspecialchars($evento['descricao']) ?></p>
            </div>
          </div>
        </div>
      <?php } ?>
    </section>
  </main>

  <footer class="bg-ligth py-4">
    <div class="container d-flex justify-content-center align-items-center flex-column">
      <h1 class="m-0">
        <a href="index.php" class="text-light text-decoration-none">
          <img class="logotipo" src="images/logo2.png" alt="Logo do site">
        </a>
      </h1>

      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link text-black" href="index.php">Home</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-black" href="#" id="footerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Gêneros
          </a>
          <ul class="dropdown-menu" aria-labelledby="footerDropdown">
            <?php foreach ($listaDeGeneros as $generos) { ?>
              <li>
                <a class="dropdown-item" href="generos.php?tipo=<?= htmlspecialchars($generos['id']) ?>">
                  <?= htmlspecialchars($generos['tipo']) ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link text-black" href="cria-conta.php">Cadastro</a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-black" href="login.php">Login</a>
        </li>
      </ul>
    </div>

    <p class="m-0 text-center">
      Explosão Cultural — Empresa fictícia criada por Maycon e Lucas &copy;
    </p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/menu.js"></script>
  <script src="js/buscar.js"></script>
</body>
</html>
