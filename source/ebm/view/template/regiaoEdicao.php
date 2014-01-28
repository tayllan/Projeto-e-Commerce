<?php

function construirFormulario($regiao) {
    $conteudo = '<form class="ui form segment" action="regiaoView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Regiao</label>
            <div class="ui left labeled icon input">
                <input type="text" name="' . Colunas::REGIAO_NOME . '"
                    value="' . $regiao->nome. '">
                <i class="map icon"></i>
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
            <input type="text" name="' . Colunas::REGIAO_ID . '" value="' . $regiao->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}