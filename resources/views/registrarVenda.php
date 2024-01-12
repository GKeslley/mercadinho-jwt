<?php
  $valorDesconto = $calcularDesconto((float) $preco);
?>

<form action="./index.php/venda" method="POST" class="form-registro-venda">
  <input type="hidden" name="nome" id="nome" value="<?= $value[1] ?>">
  <input type="hidden" name="preco" id="preco" value="<?= $value[2] ?>">
  <input type="hidden" name="desconto" id="desconto" value="<?= $valorDesconto ?>">

  <div class="quantidade-container">
    <input type="number" name="quantidade" id="quantidade" placeholder="Quantidade" required>
    <button type="submit" class="btn-comprar">Comprar</button>
  </div>
</form>