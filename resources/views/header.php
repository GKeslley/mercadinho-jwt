<?php
  $diretorio = dirname($_SERVER['SCRIPT_NAME']);
  $urlDinamica = "http://" . $_SERVER['HTTP_HOST'] . $diretorio;
?>

<head>
  <link rel="stylesheet" href="./resources/css/header.css">
</head>

<header class="header container">
  <h1><a href="<?= $urlDinamica ?>/index.php">Mercadinho JWT</a></h1>
  <nav>
    <ul>
      <li>
        <a href="<?= $urlDinamica ?>/index.php">À venda</a>
      </li>
      <li>
        <a href="<?= $urlDinamica ?>/index.php/produtos/vendidos">Vendidos</a>
      </li>
      <li>
        <a href="<?= $urlDinamica ?>/index.php/cadastrar">Novo Produto</a>
      </li>
    </ul>
  </nav>
</header>