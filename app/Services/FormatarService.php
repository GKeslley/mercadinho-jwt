<?php

namespace App\Services;

class FormatarService
{
    /**
    * Método para formatar um número para o formato português.
    *
    * @param float $valor
    */
    public function formatarNumeroParaPT(float $valor)
    {
        return number_format($valor, 2, ',', '.');
    }

    /**
    * Método para formatar um número para o formato americano.
    *
    * @param float $valor
    */
    public function formatarNumeroParaEUA(float $valor)
    {
        return number_format($valor, 2, '.', ',');
    }

    /**
    * Método para remover o prefixo "R$ " de um preço.
    *
    * @param string $valor
    */
    public function formatarPreco($valor)
    {
        return str_replace("R$ ", "", $valor);
    }
}