<?php

function construirFormulario($unidadeFederativa) {
    $controller = new UnidadeFederativaController();
    $conteudo = '<form action="unidadeFederativaView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="' . Colunas::UNIDADE_FEDERATIVA_NOME
                . '" value="' . $unidadeFederativa->nome . '">
        </div>
        
        <div>
            <label for="sigla">Sigla:</label>
            <input type="text" id="sigla" name="' . Colunas::UNIDADE_FEDERATIVA_SIGLA
                . '" maxlength="2" size="2" value="' . $unidadeFederativa->sigla . '">
        </div>
        
        <div>
            <label for="regiao">Região:</label>
            <select id="regiao" name="' . Colunas::UNIDADE_FEDERATIVA_FK_REGIAO. '" size="1">';
    $array = $controller->listar(Colunas::REGIAO);
    foreach ($array as $linha) {
        if ($linha[Colunas::REGIAO_NOME] != 'REGIAO_ANONIMA') {
            $conteudo .= '<option value="' . $linha[Colunas::REGIAO_ID] . '"';
            if ($linha[Colunas::REGIAO_ID] === $unidadeFederativa->regiao->id) {
                $conteudo .= ' selected';
            }
            $conteudo .= '>' . $linha[Colunas::REGIAO_NOME] . '</option>';
        }
    }
    $conteudo .= '</select>
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::UNIDADE_FEDERATIVA_ID . '" value="' . $unidadeFederativa->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}