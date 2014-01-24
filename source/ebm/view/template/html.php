<?php

function cabecalhoHTML($titulo) {
    echo <<<CABECALHO_HTML
<!DOCTYPE html>
<html>
    <head>
        <title>{$titulo}</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/resource/css/estilo.css">
    </head>
    <body>
CABECALHO_HTML;
}

function cabecalho($mensagem) {
    $conteudo ='<header>
    <p>' . $mensagem . '</p>
</header>
<div class="home">
    <a href="/index.php">Voltar à HOME</a>
</div>
<div class="login"> <p>';
    if ((isset($_SESSION[SESSAO_LOGADO]))) {
        $conteudo .= $_SESSION[SESSAO_USUARIO_LOGIN] . ' <sub><a href="/core/logout.php">Sair</a></sub>';
        
    }
    else {
        $conteudo .= '<a href="/core/login.php">Realizar login</a>'
        . '<br>'
        . '<a href="/view/realizarCadastroView.php">Cadastre-se</a>';
    }
        
    echo $conteudo . '<br><a href="/view/carrinhoDeComprasView.php">Meu Carrinho</a></p></div>';
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