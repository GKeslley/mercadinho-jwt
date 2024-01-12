<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compra</title>
  <link rel="stylesheet" href="../resources/css/styles.css">
</head>

<body>
  <section class="container">
    <h1 class="titulo">Produto comprado!</h1>
    <p class="nota-titulo">Nota Fiscal</p>
    <ul class="nota-infos">
      <li>Produto: <?= $produto['nome'] ?></li>
      <li>Preço unitário: R$ <?= $produto['preco'] ?></li>
      <li>Desconto: R$ <?= $notaFiscal['desconto'] ?></li>
      <li>Preço unitário com desconto: R$ <?= $precoComDesconto ?></li>
      <li>Quantidade: <?= $notaFiscal['quantidade'] ?></li>
      <li>Preço Total: R$ <?= $precoFinal ?></li>
      <li>Data da compra: <?= $notaFiscal['data'] ?></li>
    </ul>
  </section>
</body>

</html>