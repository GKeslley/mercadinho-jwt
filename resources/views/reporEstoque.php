<form action="./index.php/produto/repor" method="POST" class="form-registro-venda">
  <input type="hidden" name="nome" id="nome" value="<?= $value[1] ?>">

  <div class="quantidade-container">
    <input type="number" name="quantidade" id="quantidade" placeholder="Quantidade" required>
    <button type="submit" class="btn-repor">Repor</button>
  </div>
</form>