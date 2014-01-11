<?php

require_once '../config.php';

function construirFormulario($regiao) {
    $conteudo = '<form action="regiaoView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="' . Colunas::REGIAO_NOME
                . '" value="' . $regiao->nome . '">
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::REGIAO_ID . '" value="' . $regiao->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}