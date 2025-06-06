<?php
use ExplosaoCultural\Services\GeneroServico;

require_once "vendor/autoload.php";

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php?acesso_proibido');
    exit;
}

$generoServico = new GeneroServico();
$listaDeGeneros = $generoServico->listarTodos();
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Explosão Cultural</title>
    <link rel="shortcut icon" href="images/logotipo2.png" type="image/png" sizes="64x64" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/estilo.css" />
</head>

<body class="bg-light text-dark">
    <header class="bg-light p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="m-0">
                <a href="index.php" class="text-light text-decoration-none">
                    <img class="logotipo" src="images/logo2.png" alt="logo tipo" />
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
                                    <?php foreach ($listaDeGeneros as $genero): ?>
                                        <li>
                                            <a class="dropdown-item" href="generos.php?tipo=<?= htmlspecialchars($genero['id']) ?>">
                                                <?= htmlspecialchars($genero['tipo']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
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
                                <input id="campo-busca" name="busca" class="form-control me-2" type="search" placeholder="Pesquise aqui" aria-label="Pesquise aqui" />
                            </form>
                            <div id="resultados" role="region" aria-live="polite" class="mt-3 position-absolute container bg-white shadow-lg p-3 rounded"></div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <hr />
    </header>

    <article class="container my-5 bg-light text-dark rounded p-4 shadow">
        <div class="container my-5 h-100">
            <h2 class="display-4">Olá! <?= htmlspecialchars($_SESSION['nome']) ?></h2>
            <hr class="my-4" />

            <div class="d-grid gap-2 d-md-block text-center">
                <a class="btn btn-dark bg-gradient btn-lg" href="criarEvento.php">
                    <i class="bi bi-person"></i> <br />
                    Criar
                </a>

                <a class="btn btn-dark bg-gradient btn-lg" href="index.php">
                    <i class="bi bi-newspaper"></i> <br />
                    Eventos
                </a>

                <a class="btn btn-dark bg-gradient btn-lg" href="meuperfil.php">
                    <i class="bi bi-people"></i> <br />
                    Meu perfil
                </a>
            </div>
        </div>
    </article>

    <footer class="bg-light py-4">
        <div class="container d-flex justify-content-center align-items-center flex-column">
            <h1 class="m-0">
                <a href="index.php" class="text-light text-decoration-none">
                    <img class="logotipo" src="images/logo2.png" alt="Logo do site" />
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
                        <?php foreach ($listaDeGeneros as $genero): ?>
                            <li>
                                <a class="dropdown-item" href="generos.php?tipo=<?= htmlspecialchars($genero['id']) ?>">
                                    <?= htmlspecialchars($genero['tipo']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/menu.js"></script>
    <script src="js/buscar.js"></script>
</body>

</html>
