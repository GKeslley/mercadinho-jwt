<?php

namespace App\Contracts;

// Declara a interface ICsvManipulador
interface ICsvManipulador
{
    /**
     * Método para ler um arquivo CSV.
     *
     * @param string $caminho
     */
    public function lerCsv(string $caminho);

    /**
     * Método para escrever em um arquivo CSV.
     *
     * @param array $data
     * @param string $caminho
     */
    public function escreverCsv(array $data, string $caminho);
}