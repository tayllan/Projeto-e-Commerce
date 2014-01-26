<?php

function construirFormulario($marcaDeProduto) {
    $conteudo = '<form action="marcaDeProdutoView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="' . Colunas::MARCA_DE_PRODUTO_NOME
                . '" value="' . $marcaDeProduto->nome . '">
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::MARCA_DE_PRODUTO_ID . '" value="' . $marcaDeProduto->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}