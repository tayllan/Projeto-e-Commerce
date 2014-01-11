<?php

require_once '../config.php';

function construirFormulario($generoSexual) {
    $conteudo = '<form action="generoSexualView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="' . Colunas::GENERO_SEXUAL_NOME
                . '" value="' . $generoSexual->nome . '">
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::GENERO_SEXUAL_ID
                . '" value="' . $generoSexual->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}