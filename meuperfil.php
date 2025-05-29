<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Explosão Cultural</title>
    <meta name="description" content="Explosão Cultural - Plataforma de eventos culturais.">
    <link rel="shortcut icon" href="images/logotipo2.png" type="image/png" sizes="64x64">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body class="bg-light text-dark">
    <header class="bg-light p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="m-0">
                <a href="index.php" class="text-light text-decoration-none">
                    <img class="logotipo" src="images/logo2.png" alt="Logotipo do Explosão Cultural" loading="lazy">
                </a>
            </h1>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
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

    <div class="row">
        <article class="col-12 bg-white rounded shadow my-1 py-4">
            <h2 class="text-center">Atualizar meus dados</h2>

            <?php if (!empty($mensagemDeErro)) : ?>
                <div class="alert alert-danger text-center" role="alert">
                    <?= htmlspecialchars($mensagemDeErro) ?>
                </div>
            <?php endif; ?>

            <form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">
                <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">

                <div class="mb-3">
                    <label class="form-label" for="nome">Nome:</label>
                    <input value="<?= htmlspecialchars($usuario['nome']) ?>" class="form-control" type="text" id="nome" name="nome" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">E-mail:</label>
                    <input value="<?= htmlspecialchars($usuario['email']) ?>" class="form-control" type="email" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="senha">Senha:</label>
                    <input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
                </div>

                <button class="btn btn-primary" name="atualizar" aria-label="Atualizar dados">
                    <i class="bi bi-arrow-clockwise"></i> Atualizar
                </button>
            </form>
        </article>
    </div>

    <footer class="bg-light py-4">
        <div class="container d-flex justify-content-center align-items-center flex-column">
            <h1 class="m-0">
                <a href="index.php" class="text-light text-decoration-none">
                    <img class="logotipo" src="images/logo2.png" alt="Logotipo do Explosão Cultural" loading="lazy">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="js/menu.js" defer></script>
    <script src="js/buscar.js" defer></script>
</body>

</html>
