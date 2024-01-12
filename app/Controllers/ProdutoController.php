<?php

namespace App\Controllers;

use App\Contracts\ICsvManipulador;
use App\Services\ProdutoService;
use App\Services\FormatarService;
use App\Models\Produto;

/**
 * Controlador para operações relacionadas aos produtos.
 */
class ProdutoController implements ICsvManipulador
{
    // Serviço para manipulação de produtos
    private $produtoService;

    // Serviço para formatação de números
    private $formatarService;

    /**
    * Construtor do controlador.
    */
    public function __construct()
    {
        // Inicialização dos serviços
        $this->produtoService = new ProdutoService();
        $this->formatarService = new FormatarService();
    }

    /**
    * Método para obter todos os produtos a venda do arquivo produtos.csv e retornar na view.
    */
    public function getProdutos()
    {
        try {
            // Lê os produtos do arquivo CSV
            $produtos = $this->lerCsv('produtos.csv');

            // Define uma função anônima para calcular o desconto
            $calcularDesconto = function ($preco) {
                return $this->calcularDesconto($preco);
            };

            // Define uma função anônima para formatar o número
            $formatarNumero = function ($valor) {
                return $this->formatarService->formatarNumeroParaPT($valor);
            };

            // Exibe a view com os produtos
            require "resources/views/produtos.php";
        } catch (\Exception $e) {
            // Captura qualquer erro que possa ocorrer durante a execução do método
            $erro = $e->getMessage();

            // Mostra a mensagem de erro na tela
            require "resources/views/error.php";
        }
    }

    public function getProdutosVendidos()
    {
        try {
            // Lê todos os produtos vendidos do arquivo vendas.csv
            $produtos = $this->lerCsv('vendas.csv');

            // Carrega a view para exibir os produtos vendidos
            require "resources/views/vendidos.php";
        } catch (\Exception $e) {
            // Em caso de exceção, captura a mensagem de erro
            $erro = $e->getMessage();

            // Carrega a view de erro para exibir a mensagem de erro
            require "resources/views/error.php";
        }
    }

    /**
    * Retorna a view para cadastro de produto.
    */
    public function cadastrarProduto()
    {
        // Carrega a view para cadastro de produto
        require "resources/views/cadastrarProduto.php";
    }

    /**
    * Função para realizar o tratamento de erros dos dados enviados via formulário e salvar no arquivo csv.
    */
    public function salvarProduto()
    {
        try {
            // Verifica se há dados POST
            if (!empty($_POST)) {
                // Extrai os dados do POST
                extract($_POST);
                
                // Formata o preço enviado para o padrão americano
                $preco = str_replace(',', '.', $preco);
                
                // Verifica se $nome é um nome válido
                if (empty($nome)) {
                    throw new \Exception("Nome inválido.\nDigite o nome do produto corretamente!");
                }
                
                // Verifica se $preco é um número válido
                if (!is_numeric($preco) || $preco < 1) {
                    throw new \Exception("Preço \"{$preco}\" inválido. Adicione um valor válido");
                }
                
                // Verifica se $quantidade é um número válido
                if (!is_numeric($quantidade) || $quantidade < 1) {
                    throw new \Exception("Quantidade \"{$quantidade}\" inválida. Adicione um valor válido");
                }
                
                // Verifica se o produto já está cadastrado, a partir do nome
                $produtoJaCadastrado = $this->produtoService->verificarCadastroProduto($nome, 'produtos.csv');
   
                if ($produtoJaCadastrado) {
                    throw new \Exception("Produto \"{$nome}\" já está cadastrado");
                }

                // Cria uma nova instância da classe Produto
                $produto = new Produto();

                // Adiciona duas casas decimais ao preço (caso não tenha)
                $precoCasasDecimais = $this->formatarService->formatarNumeroParaEUA($preco);

                // Define um novo produto
                $produto->setProduto(['nome' => $nome, 'preco' => $precoCasasDecimais, 'quantidade' => $quantidade]);

                // Salva os dados do produto registrado no arquivo csv
                $this->escreverCsv($produto->getProduto(), 'produtos.csv');
            }

            // Redireciona o usuário para a página principal
            header("Location: ../index.php");
            exit();
        } catch (\Exception $e) {
            // Em caso de exceção, captura a mensagem de erro
            $erro = $e->getMessage();

            // Carrega a view de erro para exibir a mensagem de erro
            require "resources/views/error.php";
        }
    }

    /**
 * Função para calcular o valor de desconto baseado no preço do produto.
 *
 * @param float $preco
 */
    public function calcularDesconto(float $preco): float
    {
        $desconto = 0.00;

        // Aplica descontos de acordo com o preço do produto
        if ($preco > 100.00) {
            $desconto = 10.00; // Desconto fixo de R$10 para produtos acima de R$100
        } elseif ($preco > 50.00) {
            $desconto = 5.00; // Desconto fixo de R$5 para produtos entre R$50 e R$100
        }

        return $desconto;
    }

    /**
     * Função para ler arquivo csv e obter os dados.
     *
     * @param string $caminho
     */
    public function lerCsv(string $caminho): array
    {
        // Tenta abrir o arquivo CSV
        $arquivo = fopen($caminho, 'r') or throw new \Exception('Erro ao abrir arquivo ' . $caminho);

        $data = [];

        // Lê o arquivo CSV linha por linha
        while(($linha = fgetcsv($arquivo, 0, ",")) !== false) {
            $linha = $this->formatarService->formatarPreco($linha);

            // Adiciona a linha formatada ao array de dados
            $data[] = $linha;
        }

        // Fecha o arquivo
        fclose($arquivo);

        return $data;
    }

    /**
     * Função para ler e escrever dentro do arquivo csv.
     *
     * @param array $data
     * @param string $caminho
     */
    public function escreverCsv(array $data, string $caminho): void
    {
        // Tenta abrir o arquivo CSV
        $arquivo = fopen($caminho, 'a+') or throw new \Exception('Erro ao abrir arquivo ' . $caminho);

        $totalLinhas = 1;

        // Conta o total de linhas no arquivo CSV
        while (!feof($arquivo)) {
            fgets($arquivo);
            $totalLinhas++;
        }

        // Formata a string para escrita no arquivo CSV
        $txt = "{$totalLinhas},{$data['nome']},R$ {$data['preco']},{$data['quantidade']}\n";

        // Escreve a string formatada no arquivo CSV
        fwrite($arquivo, $txt);

        // Fecha o arquivo
        fclose($arquivo);
    }
}
