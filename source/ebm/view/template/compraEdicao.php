<?php

require_once '../config.php';

function construirFormulario($compra) {
    $controller = new CompraController();
    $conteudo = '<form action="compraView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="data">Data:</label>
            <input type="text" id="data" name="' . Colunas::COMPRA_DATA . '" value="' . $compra->data . '">
        </div>
        
        <div>
            <label for="total">Total:</label>
            <input type="text" id="total" name="' . Colunas::COMPRA_TOTAL . '" value="' . $compra->total . '">
        </div>
        
        <div>
            <label for="usuario">Comprador:</label>
            <select id="usuario" name="' . Colunas::COMPRA_FK_USUARIO . '" size="1">';
    $array = $controller->listar(Colunas::USUARIO);
    foreach ($array as $linha) {
        $conteudo .= '<option value="' . $linha[Colunas::USUARIO_ID] . '"';
        if ($linha[Colunas::USUARIO_ID] === $compra->usuario->id) {
            $conteudo .= ' selected';
        }
        $conteudo .= '>' . $linha[Colunas::USUARIO_NOME] . '</option>';
    }
    $conteudo .= '</select>
        </div>
        
        <div>
            <label for="concluida">Concluida ?</label>
            <select id="concluida" size="1" name="' . Colunas::COMPRA_CONCLUIDA . '">';
    if ($compra->concluida) {
        $conteudo .= '<option value="true" selected>SIM</option>
                <option value="false">NÃO</option>';
    }
    else {
        $conteudo .= '<option value="true">SIM</option>
                <option value="false" selected>NÃO</option>';
    }
    
    $conteudo .= '</select>
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::COMPRA_ID . '" value="' . $compra->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}

function ajustarConclusao($concluida) {
    if ($concluida) {
        return 'SIM';
    }
    else {
        return 'NÃO';
    }
}