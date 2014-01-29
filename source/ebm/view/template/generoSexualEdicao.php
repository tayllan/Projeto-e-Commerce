<?php

function construirFormulario($generoSexual) {
    $conteudo = '<form class="ui form" action="generoSexualView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Gênero</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::GENERO_SEXUAL_NOME
                    . '" value="' . $generoSexual->nome . '">
                <i class="male icon"></i>
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
            <input type="text" name="' . Colunas::GENERO_SEXUAL_ID
                . '" value="' . $generoSexual->id . '">
        </div>
    </fieldset>
</form>
<script>
$(\'.ui.form\').form(
    {
        genero: {
            identifier: "' . Colunas::GENERO_SEXUAL_NOME . '",
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