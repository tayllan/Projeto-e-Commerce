<?php

require_once '../config.php';

function construirFormulario($produto) {
    $controller = new ProdutoController();
    $conteudo = '<form action="produtoView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="' . Colunas::PRODUTO_NOME . '" value="' . $produto->nome . '">
        </div>
        
        <div>
            <label for="marca">Marca:</label>
            <select id="marca" name="' . Colunas::PRODUTO_FK_MARCA. '" size="1">';
    $arrayMarca = $controller->listar(Colunas::MARCA_DE_PRODUTO);
    foreach ($arrayMarca as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::MARCA_DE_PRODUTO_ID] . '"';
        if ($linha[Colunas::MARCA_DE_PRODUTO_ID] === $produto->marca->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::MARCA_DE_PRODUTO_NOME] . '</option>';
    }
    $conteudo .= '</select>
        </div>
        
        <div>
            <label for="categoria">Categoria:</label>
            <select id="categoria" name="' . Colunas::PRODUTO_FK_CATEGORIA . '" size="1">';
    $arrayCategoria = $controller->listar(Colunas::CATEGORIA_DE_PRODUTO);
    foreach ($arrayCategoria as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::CATEGORIA_DE_PRODUTO_ID] . '"';
        if ($linha[Colunas::CATEGORIA_DE_PRODUTO_ID] === $produto->categoria->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::CATEGORIA_DE_PRODUTO_NOME] . '</option>';
    }
    $conteudo .= '</select>
        </div>
        
        <div>
            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="' . Colunas::PRODUTO_DESCRICAO . '" value="'
                . $produto->descricao . '">
        </div>
        
        <div>
            <label for="preco">Preço:</label>
            <input type="text" id="preco" name="' . Colunas::PRODUTO_PRECO . '" value="' . $produto->preco. '">
        </div>
        
        <div>
            <label for="quantidade">Quantidade:</label>
            <input type="text" id="quantidade" name="' . Colunas::PRODUTO_QUANTIDADE . '" value="'
                . $produto->quantidade . '">
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::PRODUTO_ID . '" value="' . $produto->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}