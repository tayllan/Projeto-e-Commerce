<?php

require_once '../config.php';
require_once ROOT . 'view/template/html.php';

cabecalhoHTML('Página do Administrador');
cabecalho('Super Cabeçalho');

if (isset($_SESSION[SESSAO_USUARIO_PERMISSAO])) {
    echo <<<MENU
    <div>
        <p>
            <a href="/ebm/view/regiaoView.php">Sessão de Regiões</a>
        </p>
    
        <p>
            <a href="/ebm/view/unidadeFederativaView.php">Sessão de Unidades Federativas</a>
        </p>
    
        <p>
            <a href="/ebm/view/cidadeView.php">Sessão de Cidades</a>
        </p>
    
        <p>
            <a href="/ebm/view/enderecoView.php">Sessão de Endereços</a>
        </p>
    
        <p>
            <a href="/ebm/view/usuarioView.php">Sessão de Usuários</a>
        </p>
    
        <p>
            <a href="/ebm/view/categoriaDeProdutoView.php">Sessão de Categorias de Produtos</a>
        </p>
    
        <p>
            <a href="/ebm/view/marcaDeProdutoView.php">Sessão de Marcas de Produtos</a>
        </p>
    
        <p>
            <a href="/ebm/view/produtoView.php">Sessão de Produtos</a>
        </p>
    
        <p>
            <a href="/ebm/view/itemDeProdutoView.php">Sessão de Itens de Produtos</a>
        </p>
    
        <p>
            <a href="/ebm/view/compraView.php">Sessão de Compras</a>
        </p>
    
        <p>
            <a href="/ebm/view/generoSexualView.php">Sessão de Gêneros Sexuais</a>
        </p>
    </div>
MENU;
}
else {
    header('Location: ../index.php');
}
rodape('Super Rodapé');
rodapeHTML();