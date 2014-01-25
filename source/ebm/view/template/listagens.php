<?php

function criarTabela($caption, $nomeView, array $array) {
    $conteudo = '<a href="' . $nomeView . '.php?editar=false">Cadastrar</a>

<br>

<table border="1">
    <caption>' . $caption . '</caption>

    <thead>
        <tr>';
    
    foreach ($array as $elemento) {
        $conteudo .= '<th><strong>' . $elemento . '</strong></th>';
    }
    
    return $conteudo . '<th><strong>Deletar</strong></th></tr></thead><tbody>';
}