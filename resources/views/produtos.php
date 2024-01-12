<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produtos</title>
  <link rel="stylesheet" href="./resources/css/styles.css">
</head>

<body>
  <?php require "header.php" ?>

  <section class="container">
    <h1 class="titulo">Produtos À Venda</h1>

    <ul class="produtos">
      <?php
      foreach ($produtos as $produto => $value) {
       ?>
      <li>
        <p><?= $value[1] ?></p>
        <?php 
              $preco = isset($value[2]) ? $value[2] : 0;
              if (($valorDesconto = $calcularDesconto($preco)) > 0) {
                $novoValor = $preco - $valorDesconto;
                echo '<span class="preco valorAntigo">R$ '.$formatarNumero($value[2]).'</span>';
                echo '<p class="preco valorNovo">R$ '.$formatarNumero($novoValor).'</p>';
              } else {
                echo '<span class="preco">R$ '.$formatarNumero($value[2]).'</span>';
              }
          ?>
        <p>Em estoque: <?= $value[3] ?></p>
        <?php 
          if ($value[3] > 0) {
            require "registrarVenda.php";
          } else {
            require "reporEstoque.php";
          }
        ?>
      </li>

      <?php
      } 
    ?>
    </ul>
  </section>
</body>

</html>