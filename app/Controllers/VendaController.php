<?php

namespace App\Controllers;

use App\Contracts\ICsvManipulador;
use App\Models\Venda;
use App\Models\Produto;
use App\Services\FormatarService;

/**
 * Controlador para operações relacionadas a venda.
 */
class VendaController implements ICsvManipulador
{
    private string $nomeProduto;

    // Serviço para formatação de números
    private $formatarService;

    /**
    * Construtor do controlador.
    */
    public function __construct()
    {
        // Inicialização do serviço
        $this->formatarService = new FormatarService();
    }

    /**
    * Função para registrar uma venda.
    */
    public function registrarVenda(): void
    {
        try {
            // Verifica se há dados POST
            if (!empty($_POST)) {
                // Extrai os dados do POST
                extract($_POST);

                // Atribui o nome do produto
                $this->nomeProduto = $nome;

                // Cria uma nova venda
                $venda = new Venda();

                // Lê o arquivo CSV para obter os detalhes do produto
                $produto = $this->lerCsv('produtos.csv');

                // Verifica se o produto existe
                if ($produto) {
                    // Cria uma nova instância de Produto
                    $produtoCadastrado = new Produto();

                    // Define o produto no objeto Produto
                    $produtoCadastrado->setProduto($produto);

                    // Verifica se a quantidade do produto está disponível
                    if ($produto['quantidade'] >= 1) {
                        // Verifica se a quantidade solicitada é válida
                        if ($quantidade < 1 || $quantidade > $produto['quantidade']) {
                            throw new \Exception("Quantidade inválida. \nDetalhes\nNome: {$produto['nome']}\nPreço: {$produto['preco']}\nEm estoque: {$produto['quantidade']}");
                        }

                        // Define a data atual
                        $dataAtual = date("d/m/Y");

                        // Define a venda
                        $venda->setVenda($produtoCadastrado, $quantidade, $desconto, $dataAtual);

                        // Obtém a nota fiscal da venda
                        $notaFiscal = $venda->getVenda();

                        // Calcula o preço final com desconto
                        $precoComDesconto = $produto['preco'] - $notaFiscal['desconto'];
                        $precoFinal = $this->calcularPrecoFinal($produto['preco'], $quantidade, $desconto);

                        // Obtém a nova quantidade do produto
                        $novaQuantidade = $produtoCadastrado->getProduto()['quantidade'];

                        // Escreve a nota fiscal no arquivo CSV
                        $this->escreverCsv($notaFiscal, 'vendas.csv');

                        // Atualiza o estoque do produto
                        $this->atualizarEstoque($produtoCadastrado, $novaQuantidade, $dataAtual);

                        // Carrega a view para exibir a confirmação da compra
                        require "resources/views/notaFiscal.php";

                        return;
                    }

                    // Lança uma exceção se o produto não tem estoque
                    throw new \Exception("Produto sem estoque. \nDetalhes\nNome: {$produto['nome']}\nPreço: {$produto['preco']}\nEm estoquee: 0");
                }
            }

            // Redireciona o usuário para a página inicial se não houver dados POST
            header('Location: ../index.php');
            exit();
        } catch (\Exception $e) {
            // Em caso de exceção, captura a mensagem de erro
            $erro = $e->getMessage();

            // Carrega a view de erro para exibir a mensagem de erro
            require "resources/views/error.php";
        }
    }

    /**
     * Função para calcular o preço final após aplicar o desconto.
     *
     * @param float $precoUnitario
     * @param int $quantidade
     * @param float $desconto
    */
    private function calcularPrecoFinal(float $precoUnitario, int $quantidade, float $desconto): float
    {
        return ($precoUnitario - $desconto) * $quantidade;
    }

    /**
     * Função para ler o arquivo CSV e obter os detalhes do produto.
     *
     * @param string $caminho
     */
    public function lerCsv(string $caminho)
    {
        // Abre o arquivo CSV para leitura
        $arquivo = fopen($caminho, 'r') or throw new Exception('Erro ao abrir arquivo ' . $caminho);

        $data = null;

        // Lê o arquivo CSV linha por linha
        while (($linha = fgetcsv($arquivo, 1000, ",")) !== false) {
            $nomeProduto = $linha[1];
            $precoProduto = $this->formatarService->formatarPreco($linha[2]);

            // Verifica se o nome do produto corresponde ao nome do produto que estamos procurando
            if ($nomeProduto == $this->nomeProduto) {
                $data = [
                  'nome' => $nomeProduto,
                  'preco' => $this->formatarService->formatarNumeroParaEUA($precoProduto),
                  'quantidade' => (int) $linha[3]
                ];
                break;
            };
        }

        // Fecha o arquivo
        fclose($arquivo);

        return $data;
    }

    /**
     * Função para escrever dados no arquivo CSV.
     *
     * @param array $data
     * @param string $caminho
     */
    public function escreverCsv(array $data, string $caminho): void
    {
        // Abre o arquivo CSV para escrita
        $arquivo = fopen($caminho, 'a+') or throw new Exception('Erro ao abrir arquivo ' . $caminho);

        // Obtém a data atual
        $dataAtual = date("d/m/Y");

        // Conta o total de linhas no arquivo CSV
        $totalLinhas = 1;
        while (($linha = fgets($arquivo)) !== false) {
            $totalLinhas++;
        }

        // Obtém os detalhes do produto
        $produto = $data['produto']->getProduto();

        // Formata a string para escrita no arquivo CSV
        $txt = "{$totalLinhas},{$produto['nome']},R$ {$produto['preco']},{$data['quantidade']},R$ {$data['desconto']},{$dataAtual}\n";

        // Escreve a string formatada no arquivo CSV
        fwrite($arquivo, $txt);

        // Fecha o arquivo
        fclose($arquivo);
    }

    /**
     * Função para reposicionar o estoque.
     */
    public function reporEstoque(): void
    {
        try {
            // Verifica se há dados POST
            if ($_POST) {
                // Extrai os dados do POST
                extract($_POST);

                // Atribui o nome do produto
                $this->nomeProduto = $nome;

                // Lê o arquivo CSV para obter os detalhes do produto
                $produto = $this->lerCsv('produtos.csv');

                // Obtém a data atual
                $dataAtual = date("d/m/Y");

                // Verifica se a quantidade é válida
                if ($quantidade < 1) {
                    throw new \Exception("Quantidade inválida. \nDetalhes:\nNome: {$produto['nome']}\nPreço: R$ {$produto['preco']}\nEm estoque: {$produto['quantidade']}");
                }

                // Verifica se o produto existe
                if ($produto) {
                    // Cria uma nova instância de Produto
                    $produtoCadastrado = new Produto();

                    // Define o produto no objeto Produto
                    $produtoCadastrado->setProduto($produto);

                    // Atualiza o estoque do produto
                    $this->atualizarEstoque($produtoCadastrado, $quantidade, $dataAtual);
                }
            }

            // Redireciona o usuário para a página inicial
            header('Location: ../../index.php');
            exit();
        } catch (\Exception $e) {
            // Em caso de exceção, captura a mensagem de erro
            $erro = $e->getMessage();

            // Carrega a view de erro para exibir a mensagem de erro
            require "resources/views/error.php";
        }
    }

    /**
     * Função para atualizar o estoque de um produto.
     *
     * @param Produto $produtoCadastrado
     * @param int $novaQuantidade
     * @param string $dataAtual
    */
    public function atualizarEstoque(Produto $produtoCadastrado, int $novaQuantidade, string $dataAtual): void
    {
        // Abre o arquivo CSV para leitura
        $arquivo = fopen('produtos.csv', 'r') or throw new \Exception('Erro ao abrir arquivo produtos.csv');

        $linhaProduto = null;
        $linhas = [];

        // Lê o arquivo CSV linha por linha
        while (!feof($arquivo)) {
            $linha = fgets($arquivo);
            if (!$linha) {
                break;
            }

            // Divide a linha em campos separados por vírgulas
            $dataProduto = explode(',', rtrim($linha));

            // Verifica se o nome do produto corresponde ao nome do produto que estamos procurando
            if ($produtoCadastrado->getProduto()['nome'] == $dataProduto[1]) {
                // Atualiza a quantidade e a data do produto
                $dataProduto[3] = $novaQuantidade;
                $dataProduto[4] = $dataAtual;

                // Junta os campos novamente em uma linha e adiciona à lista de linhas
                $linhas[] = implode(',', $dataProduto) . "\n";
            } else {
                // Se o nome do produto não corresponder, mantém a linha original
                $linhas[] = $linha;
            }
        }

        // Fecha o arquivo CSV
        fclose($arquivo);

        // Abre o arquivo CSV para escrita
        $arquivo = fopen('produtos.csv', 'w') or throw new \Exception('Erro ao abrir arquivo produtos.csv');

        // Escreve todas as linhas na lista de linhas no arquivo CSV
        foreach ($linhas as $linha) {
            fwrite($arquivo, $linha);
        }

        // Fecha o arquivo CSV
        fclose($arquivo);
    }
}
