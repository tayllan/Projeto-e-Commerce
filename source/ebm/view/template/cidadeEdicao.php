<?php

require_once '../config.php';

function construirFormulario($cidade) {
    $controller = new CidadeController();
    $conteudo = '<form action="cidadeView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="' . Colunas::CIDADE_NOME . '" value="' . $cidade->nome . '">
        </div>
        
        <div>
            <label for="unidadeFederativa">Unidade Federativa:</label>
            <select id="unidadeFederativa" name="' . Colunas::CIDADE_FK_UNIDADE_FEDERATIVA. '" size="1">';
    $array = $controller->listar(Colunas::UNIDADE_FEDERATIVA);
    foreach ($array as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::UNIDADE_FEDERATIVA_ID] . '"';
        if ($linha[Colunas::UNIDADE_FEDERATIVA_ID] === $cidade->unidadeFederativa->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::UNIDADE_FEDERATIVA_NOME] . ' - '
            . $linha[Colunas::UNIDADE_FEDERATIVA_SIGLA] . '</option>';
    }
    $conteudo .= '</select>
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::CIDADE_ID . '" value="' . $cidade->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}