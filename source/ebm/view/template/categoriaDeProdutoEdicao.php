<?php

function construirFormulario($categoriaDeProduto) {
    $conteudo = '<form class="ui form segment" action="categoriaDeProdutoView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Categoria</label>
            <div class="ui left labeled icon input">
                <input type="text" name="' . Colunas::CATEGORIA_DE_PRODUTO_NOME
                . '" value="' . $categoriaDeProduto->nome . '">
                <i class="tag icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <br>
            <input type="submit" name="submeter" value="Salvar" class="ui black submit button small">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::CATEGORIA_DE_PRODUTO_ID
                . '" value="' . $categoriaDeProduto->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}