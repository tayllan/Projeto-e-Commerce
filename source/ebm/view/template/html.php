<?php

function cabecalhoHTML($titulo) {
    echo <<<CABECALHO_HTML
<!DOCTYPE html>
<html>
    <head>
        <title>{$titulo}</title>
        <meta charset="UTF-8">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="/resource/packaged/css/semantic.css">

        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.address/1.6/jquery.address.js"></script>
        <script src="/resource/packaged/javascript/semantic.js"></script>
    </head>
    <body>
CABECALHO_HTML;
}

function cabecalho($mensagem) {
    $conteudo ='<header class="ui center aligned segment">
    <p class="ui black label">' . $mensagem . '</p>
</header>
<div class="ui center aligned segment">
<div class="ui label">
    <a href="/index.php"><i class="home icon">Voltar à HOME</i></a>
</div>';
    if (isset($_SESSION[SESSAO_LOGADO])) {
        $conteudo .= '<div class="ui label"><i class="mail icon"> ' . $_SESSION[SESSAO_USUARIO_LOGIN]
            . '</i></div>';
        if (isset($_SESSION[SESSAO_USUARIO_PERMISSAO])) {
            $conteudo .= '<div class="ui label"><a href="/core/paginaDoAdministrador.php" class="detail">'
            . '<i class="settings icon"> Página do Administrador</i></a></div>';
        }
        $conteudo .= '<div class="ui label"><a href="/core/logout.php" class="detail">'
            . '<i class="sign out icon"> Sair</i></a></div>';
        
    }
    else {
        $conteudo .= '<div class="ui label"><a href="/core/login.php" class="detail">'
            . '<i class="user icon"> Realizar login</i></a></div>'
        . '<div class="ui label"><a href="/view/realizarCadastroView.php" class="detail">'
            . '<i class="signup icon"> Cadastre-se</i></a></div>';
    }
        
    echo $conteudo . '<div class="ui label"><a href="/view/carrinhoDeComprasView.php">'
        . '<i class="cart icon"> Meu Carrinho</i></a></div></div>';
}

function rodape($mensagem) {
    echo <<<RODAPE
<footer class="ui center aligned segment">
    <p class="ui black label">
        EBM e-Commerce LTDA, 02.123.123/0001-11
    </p>
    <p class="ui black label">
        UTFPR Campus Cornélio Procópio - Avenida Alberto Carazzai, 1640
    </p>
    <p class="ui black label">
        Cornélio Procópio - PR, 86300-000
    </p>
</footer>
RODAPE;
}

function rodapeHTML() {
    echo <<<RODAPE_HTML
    </body>
</html>
RODAPE_HTML;
}