<?php 
require_once __DIR__ . '/vendor/autoload.php';

use ExplosaoCultural\Enums\TipoUsuario; 
use ExplosaoCultural\Helpers\Utils;
use ExplosaoCultural\Helpers\Validacoes;
use ExplosaoCultural\Models\Usuarios;
use ExplosaoCultural\Services\GeneroServico;
use ExplosaoCultural\Services\UsuarioServico; 

$generoServico = new GeneroServico();
$listaDeGeneros = $generoServico->listarTodos();

$mensagemErro = '';
$usuarioServico = new UsuarioServico();   

if (isset($_POST['inserir'])){ 
  
    try{ 
        $nome = Utils::sanitizar($_POST["nome"]); 
        Validacoes::validarNome($nome); 

        $dataNascimento = Utils::sanitizar($_POST["data_nascimento"]);
        Validacoes::validarDataNascimento($dataNascimento); 

        $email = Utils::sanitizar($_POST["email"], 'email');
        Validacoes::validarEmail($email);

        $senhaBruta = Utils::sanitizar($_POST["senha"]);
        Validacoes::validarSenha($senhaBruta);
        $senha = Utils::codificarSenha($senhaBruta); 

        /* $tipoStr = $_POST["tipo"];
        Validacoes::validarTipo($tipoStr);
        $tipo = TipoUsuario::From($tipoStr); */


        $usuario = new Usuarios($nome, $dataNascimento, $email, $senha);
        $usuarioServico->inserir($usuario);   
        header("Location:login.php");
        
        exit;

    } catch (Throwable $erro){
        $mensagemErro = "Erro: " . $erro->getMessage();
        Utils::registrarErro($erro);
    }

}   
?>

<!DOCTYPE html>
<html lang="pt-br" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Explosão Cultural</title>
  <meta name="description" content="Explosão Cultural - Crie sua conta para participar de eventos culturais.">
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
              <form autocomplete="off" class="d-flex" action="resultados.php" method="POST" id="form-busca">
                <input id="campo-busca" name="busca" class="form-control me-2" type="search" placeholder="Pesquise aqui" aria-label="Pesquise aqui">
              </form>

              <div id="resultados" class="mt-3 position-absolute container bg-white shadow-lg p-3 rounded"></div>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <hr>
  </header>

  <main class="container my-5 bg-light text-dark rounded p-4 shadow">
  <div class="container my-5 h-100">
    <h2 class="mb-4">Login</h2>
    <p class="text-warning">Atenção: os campos <strong>Nome</strong> e <strong>E-mail</strong> são <u>obrigatórios</u>.</p>

    <form autocomplete="off" action="" method="post" id="my-form">
      <fieldset class="border p-4 rounded">
        <legend class="float-none w-auto px-3">Crie sua conta</legend> 

        <?php if (!empty($mensagemErro)) : ?>
			<div class="alert alert-danger text-center" role="alert">
				<?= htmlspecialchars($mensagemErro) ?>
			</div>
		<?php endif; ?>

        <div class="mb-3">
          <label for="nome" class="form-label">Nome </label>
          <input type="text" class="form-control" name="nome" id="nome" required placeholder="Digite seu nome completo">
        </div>
        
        <div class="mb-3">
         <label for="data_nascimento" class="form-label">Data de nascimento</label>
         <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" placeholder="00/00/0000">
       </div>

        <div class="mb-3">
          <label for="email" class="form-label">E-mail </label>
          <input type="email" class="form-control" name="email" id="email" required placeholder="email@exemplo.com">
        </div>

        <div class="mb-3">
          <label for="senha" class="form-label">Senha</label>
          <input type="password" class="form-control" name="senha" id="senha" required placeholder="Digite sua senha"> 
        </div>
        
        <button type="submit" id="inserir" name="inserir" class="btn btn-primary">Enviar</button>
  </div>
  </fieldset>
  </form>
  </main>
  </div>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/buscar.js"></script>
  <script src="js/menu.js"></script>

</body>
</html>
