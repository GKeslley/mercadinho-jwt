<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendidos</title>
  <link rel="stylesheet" href="../../resources/css/styles.css">

</head>

<body>
  <?php require "header.php" ?>

  <section class="container">
    <h1 class="titulo">Produtos Vendidos</h1>
    <ul class="produtos">
      <?php
      foreach ($produtos as $produto => $value) {
       ?>
      <li>
        <p>Produto: <?= $value[1] ?></p>
        <p>Preço unitário: R$ <?= $value[2] ?></p>
        <p>Preço com desconto: R$ <?php 
          $precoComDesconto = $value[2] - $value[4];
          echo $precoComDesconto;
          ?>
        </p>
        <p>Quantidade: <?= $value[3] ?></p>
        <p>Data de venda: <?= $value[5] ?></p>
      </li>

      <?php
      } 
    ?>
    </ul>
  </section>
</body>

</html>