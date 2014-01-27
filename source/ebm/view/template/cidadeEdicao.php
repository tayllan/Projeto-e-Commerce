<?php

function construirFormulario($cidade) {
    $controller = new CidadeController();
    $conteudo = '<form class="ui form segment" action="cidadeView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Cidade</label>
            <div class="ui left labeled icon input">
                <input type="text" name="' . Colunas::CIDADE_NOME . '"
                    value="' . $cidade->nome. '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div class="ui segment">
            <i class="map icon"></i>
            <labe>Unidade Federativa</label>
            <select name="' . Colunas::CIDADE_FK_UNIDADE_FEDERATIVA. '" size="1">';
    $array = $controller->listar(Colunas::UNIDADE_FEDERATIVA);
    foreach ($array as $linha) {
        if ($linha[Colunas::UNIDADE_FEDERATIVA_NOME] != 'UNIDADE_FEDERATIVA_ANONIMA') {
            $conteudo .= '<option value="' . $linha[Colunas::UNIDADE_FEDERATIVA_ID] . '"';
            if ($linha[Colunas::UNIDADE_FEDERATIVA_ID] === $cidade->unidadeFederativa->id) {
                $conteudo .= ' selected';
            }
            $conteudo .= '>' . $linha[Colunas::UNIDADE_FEDERATIVA_NOME] . ' - '
                . $linha[Colunas::UNIDADE_FEDERATIVA_SIGLA] . '</option>';
        }
    }
    $conteudo .= '</select>
            <div class="ui red corner label">
                <i class="icon asterisk"></i>
            </div>
        </div>
        
        <div>
            <br>
            <input type="submit" name="submeter" value="Salvar" class="ui black submit button small">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::CIDADE_ID . '" value="' . $cidade->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}