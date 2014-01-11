<?php

require_once '../config.php';

function construirFormulario($endereco) {
    $controller = new CidadeController();
    $conteudo = '<form action="enderecoView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="' . Colunas::ENDERECO_BAIRRO . '" value="' . $endereco->bairro . '">
        </div>
        
        <div>
            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="' . Colunas::ENDERECO_CEP. '" value="' . $endereco->cep . '">
        </div>
        
        <div>
            <label for="rua">Rua:</label>
            <input type="text" id="rua" name="' . Colunas::ENDERECO_RUA . '" value="' . $endereco->rua . '">
        </div>
        
        <div>
            <label for="numero">Numero:</label>
            <input type="text" id="numero" name="' . Colunas::ENDERECO_NUMERO . '" value="' . $endereco->numero . '">
        </div>
        
        <div>
            <label for="cidade">Cidade:</label>
            <select id="cidade" name="' . Colunas::ENDERECO_FK_CIDADE. '" size="1">';
    $array = $controller->listar(Colunas::CIDADE);
    foreach ($array as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::CIDADE_ID] . '"';
        if ($linha[Colunas::CIDADE_ID] === $endereco->cidade->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::CIDADE_NOME] . '</option>';
    }
    $conteudo .= '</select>
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::ENDERECO_ID . '" value="' . $endereco->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}