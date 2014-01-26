<?php

function construirFormulario($categoriaDeProduto) {
    $conteudo = '<form action="categoriaDeProdutoView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="' . Colunas::CATEGORIA_DE_PRODUTO_NOME
                . '" value="' . $categoriaDeProduto->nome . '">
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::CATEGORIA_DE_PRODUTO_ID
                . '" value="' . $categoriaDeProduto->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}