<?php

namespace App\Models;

class Venda
{
    // Propriedades privadas da classe Venda
    private Produto $produto;
    private int $quantidade;
    private float $desconto;
    private string $data;

    /**
    * Construtor da classe Venda.
    * Neste caso, o construtor não recebe nenhum parâmetro.
    */
    public function __construct() {}

    /**
    * Método para definir os detalhes da venda.
    *
    * @param Produto $produto
    * @param int $quantidade
    * @param float $desconto
    * @param string $data
    */
    public function setVenda(Produto $produto, int $quantidade, float $desconto, string $data) : void
    {
        $this->produto = $produto;
        $this->quantidade = $quantidade;
        $this->desconto = $desconto;
        $this->data = $data;
        $produto->setNovaQuantidade($produto->getProduto()['quantidade'] - $quantidade);
    }

    /**
    * Método para obter os detalhes da venda.
    */
    public function getVenda(): array
    {
        return [
          'produto' => $this->produto,
          'quantidade' => $this->quantidade,
          'desconto' => $this->desconto,
          'data' => $this->data
        ];
    }
}