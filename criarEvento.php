<?php
require_once __DIR__ . '/vendor/autoload.php';

use ExplosaoCultural\Auth\ControleDeAcesso;
use ExplosaoCultural\Helpers\Utils;
use ExplosaoCultural\Helpers\Validacoes;
use ExplosaoCultural\Services\GeneroServico;
use ExplosaoCultural\Models\Enderecos;
use ExplosaoCultural\Enums\TipoClassificacao;
use ExplosaoCultural\Models\Eventos;
use ExplosaoCultural\Services\EventoComEnderecoServico;

ControleDeAcesso::exigirLogin();
$idUsuario = $_SESSION['id'];

$mensagemErro = '';

$generoServico = new GeneroServico();

$listaDeGeneros = $generoServico->listarTodos();

if (isset($_POST['inserir'])) {
  
    $titulo = Utils::sanitizar($_POST["nome_evento"]);
    $dataDoEvento = Utils::sanitizar($_POST["datas"]);
    $horario = Utils::sanitizar($_POST["horario"]);
    $classificacao = Utils::sanitizar($_POST["classificacao"] ?? '');
    $telefone = Utils::sanitizar($_POST["telefone"]);
    $descricao = Utils::sanitizar($_POST["descricao"]);
    $idGenero = $_POST['genero'];

    $cep = Utils::sanitizar($_POST["cep"]);
    $logradouro = Utils::sanitizar($_POST["logradouro"]);
    $bairro = Utils::sanitizar($_POST["bairro"]);
    $cidade = Utils::sanitizar($_POST["cidade"]);
    $estado = Utils::sanitizar($_POST["estado"]);

    // Use $_FILES diretamente, sem sanitizar para não perder dados essenciais do arquivo
    $arquivoDeImagem = $_FILES["imagem"];

    try {
        Validacoes::validarGenero($idGenero);
        Validacoes::validarTitulo($titulo);
        Validacoes::validarDescricao($descricao);

        Utils::upload($arquivoDeImagem);
        $nomeDaImagem = $arquivoDeImagem["name"];
        $classificacaoEnum = TipoClassificacao::from($classificacao);

        $endereco = new Enderecos($cep, $logradouro, $bairro, $cidade, $estado);   
        $evento = new Eventos($titulo, $dataDoEvento, $horario, $classificacaoEnum, $telefone, null, $idGenero, $idUsuario, $nomeDaImagem, $descricao);

        $eventoComEnderecoServico = new EventoComEnderecoServico();
        $eventoComEnderecoServico->cadastrarCompleto($evento, $endereco);

        header("location:index.php");
        exit;
    } catch (Throwable $erro) {
        $mensagemErro = $erro->getMessage();
        Utils::registrarErro($erro);
    }
}
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
      <h1 class="m-0"><a href="index.php" class="text-light text-decoration-none"><img class="logotipo" src="images/logo2.png" alt="logo tipo"></a></h1>
      <nav class="navbar navbar-expand-lg navbar-light bg-ligth">
        <div class="container">
          <button class="navbar-toggler" type="button" id="menuBtn" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="menuNav">
            <ul class="navbar-nav ms-auto">
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

            <div class="position-relative">
              <form autocomplete="off" class="d-flex" action="resultados.php" method="POST" onsubmit="return false" id="form-busca">
                <input id="campo-busca" name="busca" class="form-control me-2" type="search" placeholder="Pesquise aqui" aria-label="Pesquise aqui">
              </form>

              <!-- Div manipulada pelo busca.js -->
              <div id="resultados" class="mt-3 position-absolute container bg-white shadow-lg p-3 rounded"></div>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <hr>
  </header>

    <main class="container my-5 bg-light text-dark rounded p-4 shadow">
        <h2 class="mb-4 text-center">Inserir Evento</h2>

        <!-- Exibe mensagem de erro, se houver -->
        <?php if ($mensagemErro): ?>
          <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($mensagemErro) ?>
          </div>
        <?php endif; ?>

        <form autocomplete="off" action="" method="post" id="form-endereco" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label" for="titulo">Nome Do evento:</label>
                <input class="form-control" type="text" id="nome_evento" name="nome_evento" placeholder="Digite o nome do evento" required />
            </div>

            <div class="mb-3">
                <label class="form-label" for="titulo">Dia :</label>
                <input class="form-control" type="date" id="datas" name="datas" placeholder="Digite o nome do evento" required />
            </div>

            <div class="mb-3">
                <label class="form-label" for="titulo">Horario:</label>
                <input class="form-control" type="time" id="horario" name="horario" placeholder="Digite o nome do evento" required />
            </div>

            <div class="mb-3">
                <label class="form-label" for="classificacao">Classificação indicativa</label>
                <select class="form-select" name="classificacao" id="classificacao" required>
                    <option value="adulto">Adulto</option>
                    <option value="infantil">Infantil</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="telefone">Telefone de contato:</label>
                <input class="form-control" type="tel" id="telefone" name="telefone" />
            </div>

            <div class="mb-3">
                <label class="form-label" for="genero">Gêneros:</label>
                <select class="form-select" name="genero" id="genero" required>
                    <option value=""></option>

                    <?php foreach ($listaDeGeneros as $generos) { ?>
                        <option value="<?= htmlspecialchars($generos['id']) ?>">
                            <?= htmlspecialchars($generos['tipo']) ?>
                        </option>
                    <?php } ?>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="descricao">Descrição:</label>
                <textarea class="form-control" name="descricao" id="descricao" cols="50" rows="6" placeholder="Digite o texto completo" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="cep">Localização do evento Pelo CEP: <span id="status"></span></label>
                <div id="area-do-cep">
                    <input maxlength="9" inputmode="numeric" placeholder="Somente números" type="text" id="cep"
                        name="cep" required> <br>
                    <button id="buscar" type="button">Buscar</button>
                </div>
            </div>
            <div class="campos-restantes mb-3">
                <label for="logradouro">Endereço:</label>
                <input type="text" id="logradouro" name="logradouro" size="30">
            </div>
            <div class="campos-restantes mb-3">
                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro">
            </div>
            <div class="campos-restantes mb-3">
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade">
            </div>
            <div class="campos-restantes mb-3">
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado">
            </div>

            <div class="mb-3">
                <label class="form-label" for="imagem">Selecione uma imagem:</label>
                <input class="form-control" type="file" id="imagem" name="imagem" accept="image/png, image/jpeg, image/gif, image/svg+xml" required />
            </div>

            <div class="text-center">
                <button class="btn btn-primary" id="inserir" name="inserir" type="submit">
                    <i class="bi bi-save"></i> Lançar evento
                </button>
            </div>
        </form>
    </main>

<footer class="bg-light py-4">
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

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/jquery.mask.min.js"></script>
    <script src="js/endereco.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/buscar.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
