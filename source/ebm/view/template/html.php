<?php

function cabecalhoHTML($titulo) {
    echo <<<CABECALHO_HTML
<!DOCTYPE html>
<html>
    <head>
        <title>{$titulo}</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/ebm/resource/css/estilo.css">
    </head>
    <body>
CABECALHO_HTML;
}

function cabecalho($mensagem) {
    $conteudo ='<header>
    <p>' . $mensagem . '</p>
</header>
<div>
    <a id="home" href="/ebm/index.php">Voltar à HOME</a>
</div>
<div id="login"> <p>';
    $conteudo .= (isset($_SESSION[SESSAO_LOGADO]) ? $_SESSION[SESSAO_USUARIO_LOGIN]
        . ' <sub><a href="/ebm/core/logout.php">Sair</a></sub>': '<a href="/ebm/core/login.php">Realizar login</a>');
    echo $conteudo . '</p></div>';
}

function rodape($mensagem) {
    echo <<<RODAPE
<footer>
    <p>{$mensagem}</p>
</footer>
RODAPE;
}

function rodapeHTML() {
    echo <<<RODAPE_HTML
    </body>
</html>
RODAPE_HTML;
}