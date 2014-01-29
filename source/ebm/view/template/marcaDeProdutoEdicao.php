<?php

function construirFormulario($marcaDeProduto) {
    $conteudo = '<form class="ui form" action="marcaDeProdutoView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Marca</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::MARCA_DE_PRODUTO_NOME
                . '" value="' . $marcaDeProduto->nome . '">
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
            <input type="text" name="' . Colunas::MARCA_DE_PRODUTO_ID . '" value="' . $marcaDeProduto->id . '">
        </div>
    </fieldset>
</form>
<script>
$(\'.ui.form\').form(
    {
        marca: {
            identifier: "' . Colunas::MARCA_DE_PRODUTO_NOME . '",
            rules: [
                emptyRule
          ]
        }
    },
    {
        inline: true
    }
);
</script>';
            
    return $conteudo;
}