<?php

require_once '../config.php';

function construirFormulario($itemDeProduto) {
    $compraController = new CompraController();
    $produtoController = new ProdutoController();
    $conteudo = '<form action="itemDeProdutoView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="quantidade">Quantidade:</label>
            <input type="text" id="quantidade" name="' . Colunas::ITEM_DE_PRODUTO_QUANTIDADE . '" value="'
                . $itemDeProduto->quantidade . '">
        </div>
        
        <div>
            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="' . Colunas::ITEM_DE_PRODUTO_PRECO . '" value="'
                . $itemDeProduto->preco . '">
        </div>
        
        <div>
            <label for="compra">Compra:</label>
            <select id="compra" name="' . Colunas::ITEM_DE_PRODUTO_FK_COMPRA . '" size="1">';
    $arrayCompra = $compraController->listar(Colunas::COMPRA);
    foreach ($arrayCompra as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::COMPRA_ID] . '"';
        if ($linha[Colunas::COMPRA_ID] === $itemDeProduto->compra->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::COMPRA_DATA] . ' '
            . $linha[Colunas::COMPRA_TOTAL] . '</option>';
    }
    $conteudo .= '</select>
        </div>
        
        <div>
            <label for="produto">Produto:</label>
            <select id="produto" name="' . Colunas::ITEM_DE_PRODUTO_FK_PRODUTO. '" size="1">';
    $arrayProduto = $produtoController->listar(Colunas::PRODUTO);
    foreach ($arrayProduto as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::PRODUTO_ID] . '"';
        if ($linha[Colunas::PRODUTO_ID] === $itemDeProduto->produto->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::PRODUTO_NOME] . '</option>';
    }
    $conteudo .= '</select>
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::ITEM_DE_PRODUTO_ID . '" value="' . $itemDeProduto->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}