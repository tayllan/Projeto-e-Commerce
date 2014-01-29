<?php

function construirFormulario($regiao) {
    $conteudo = '<form class="ui form" action="regiaoView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Região</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::REGIAO_NOME . '"
                    value="' . $regiao->nome. '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div class="ui error message"></div>
        
        <div>
            <br>
            <input type="submit" name="submeter" value="Salvar" class="ui black submit button small">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::REGIAO_ID . '" value="' . $regiao->id . '">
        </div>
    </fieldset>
</form>
<script>
$(\'.ui.form\').form(
    {
        regiao: {
            identifier: "' . Colunas::REGIAO_NOME . '",
            rules: [
                {
                    type: "empty",
                    prompt: "O campo Região deve ser preenchido."
                }
          ]
        }
    }
);
</script>';
            
    return $conteudo;
}