<?php

class PagamentoController {

    private function getValorTotalDaCompra($arrayItensDeProdutosPreco, $arrayItensDeProdutosQuantidade) {
        $valorTotal = 0;
        $indice = 0;

        foreach ($arrayItensDeProdutosPreco as $preco) {
            $valorTotal += $preco * $arrayItensDeProdutosQuantidade[$indice++];
        }

        return $valorTotal;
    }

}
