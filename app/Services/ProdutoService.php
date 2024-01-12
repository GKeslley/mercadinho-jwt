<?php

namespace App\Services;

class ProdutoService
{
    /**
    * Método para verificar se um produto já está cadastrado.
    *
    * @param string $nomeProdutoCadastrado
    * @param string $caminho
    */
    public function verificarCadastroProduto(string $nomeProdutoCadastrado, string $caminho): bool
    {
        // Abre o arquivo CSV para leitura
        $arquivo = fopen($caminho, 'r') or throw new \Exception('Erro ao abrir arquivo ' . $caminho);

        $produtoCadastrado = false;

        // Lê o arquivo CSV linha por linha
        while(!feof($arquivo)) {
            $linha = fgets($arquivo);
            if (!$linha) break;
            // Divide a linha em campos separados por vírgulas
            $dataProduto = explode(',', $linha);

            // Obtém o nome do produto da linha
            $nomeProduto = $dataProduto[1];

            // Compara o nome do produto com o nome do produto cadastrado, ignorando maiúsculas e minúsculas
            if (trim(strtolower($nomeProduto)) == trim(strtolower($nomeProdutoCadastrado))) {
                $produtoCadastrado = true;
                break;
            };
        }

        // Fecha o arquivo CSV
        fclose($arquivo);

        // Retorna se o produto está cadastrado ou não
        return $produtoCadastrado;
    }
}