<?php

namespace App\Models;

class Produto
{
    // Propriedades privadas da classe Produto
    private string $nome;
    private float $preco;
    private int $quantidade;

    /**
     * Construtor da classe Produto.
     */
    public function __construct() {}

    /**
     * Método para definir os detalhes do produto.
     *
     * @param array $data
     */
    public function setProduto(array $data): void
    {
        $this->nome = $data['nome'];
        $this->preco = $data['preco'];
        $this->quantidade = $data['quantidade'];
    }

    /**
     * Método para definir a nova quantidade do produto.
     *
     * @param int $quantidade
     */
    public function setNovaQuantidade(int $quantidade): void
    {
        $this->quantidade = $quantidade;
    }

    /**
     * Método para obter os detalhes do produto.
     */
    public function getProduto(): array
    {
        return [
          'nome' => $this->nome,
          'preco' => $this->preco,
          'quantidade' => $this->quantidade
        ];
    }
}