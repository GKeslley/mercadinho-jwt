<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo Produto</title>
  <link rel="stylesheet" href="../resources/css/styles.css">
</head>

<body>
  <?php require "header.php" ?>
  <section class="form-container container">
    <h1>Novo Produto</h1>
    <form action="../index.php/produto" method="POST">
      <label for="nome">Nome</label>
      <input type="text" name="nome" id="nome" required>

      <label for="preco">Preço (R$)</label>
      <input type="text" name="preco" id="preco" required>

      <label for="quantidade">Quantidade</label>
      <input type="number" name="quantidade" id="quantidade" required>

      <button type="submit">Cadastrar</button>
    </form>
  </section>
</body>

</html>