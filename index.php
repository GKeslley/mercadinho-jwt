<?php

// Requer o autoloader do Composer
require "vendor/autoload.php";

// Importa as classes necessárias
use App\Controllers\ProdutoController;
use App\Controllers\VendaController;

// Obtém a URL e o caminho da URI
$url = pathinfo($_SERVER['REQUEST_URI'])['basename'];
$uri = $_SERVER['REQUEST_URI'];
$uriPath = explode('index.php', $uri)[1];

// Cria instâncias das classes ProdutoController e VendaController
$produto = new ProdutoController();
$venda = new VendaController();

// Executa diferentes funções dependendo da URI
switch ($uriPath) {
    case '/cadastrar':
        // Cadastra um novo produto
        $produto->cadastrarProduto();
        break;
    case '/produto':
        // Salva os dados de um produto
        $produto->salvarProduto();
        break;
    case '/produto/repor':
        // Reposiciona o estoque de um produto
        $venda->reporEstoque();
        break;
    case '/venda':
        // Registra uma nova venda
        $venda->registrarVenda();
        break;
    case '/produtos/vendidos':
        // Obtem os produtos vendidos
        $produto->getProdutosVendidos();
        break;
    default:
        // Caso nenhuma das outras condições seja atendida, obtém os produtos
        $produto->getProdutos();
        break;
}