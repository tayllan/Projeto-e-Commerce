<?php

function construirFormulario($usuario) {
    $enderecoController = new EnderecoController();
    $generoSexualController = new GeneroSexualController();
    $conteudo = '<form action="usuarioView.php" method="POST">
    <fieldset>
        <legend>Informações Gerais</legend>
        
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="' . Colunas::USUARIO_NOME . '" value="'
                . $usuario->nome . '">
        </div>
        
        <div>
            <label for="email">E-Mail:</label>
            <input type="text" id="email" name="' . Colunas::USUARIO_LOGIN . '" value="'
                . $usuario->login . '">
        </div>
        
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="' . Colunas::USUARIO_SENHA . '" value="'
                . $usuario->senha . '">
        </div>
        
        <div>
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="' . Colunas::USUARIO_CPF . '" value="'
                . $usuario->cpf . '">
        </div>
        
        <div>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="' . Colunas::USUARIO_TELEFONE . '" value="'
                . $usuario->telefone . '">
        </div>
        
        <div>
            <label for="nascimento">Data de Nascimento:</label>
            <input type="text" id="nascimento" name="' . Colunas::USUARIO_DATA_DE_NASCIMENTO . '" value="'
                . $usuario->dataDeNascimento . '">
        </div>
            
        <div>
            <label for="permissao">Administrador?</label>
            <select id="permissao" size="1" name="' . Colunas::USUARIO_ADMINISTRADOR . '">';
    if ($usuario->administrador) {
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
            <label for="endereco">Endereço:</label>
            <select id="endereco" name="' . Colunas::USUARIO_FK_ENDERECO. '" size="1">';
    $arrayEndereco = $enderecoController->listar(Colunas::ENDERECO);
    foreach ($arrayEndereco as $linha) {
        if ($linha[Colunas::ENDERECO_BAIRRO] != 'BAIRRO_ANONIMO') {
            $conteudo .= '<option value="' . $linha[Colunas::ENDERECO_ID] . '"';
            if ($linha[Colunas::ENDERECO_ID] === $usuario->endereco->id) {
                $conteudo .= ' selected';
            }
            /*
             * O nome do endereço exibido deve ser melhorado
             */
            $conteudo .= '>' . $linha[Colunas::ENDERECO_BAIRRO] . ' '
                . $linha[Colunas::ENDERECO_RUA] . ' '
                . $linha[Colunas::ENDERECO_NUMERO] . ' '
                . $linha[Colunas::ENDERECO_CEP] . '</option>';
        }
    }
    $conteudo .= '</select>
        </div>
        
        <div>
            <label for="generoSexual">Gênero Sexual:</label>
            <select id="generoSexual" name="' . Colunas::USUARIO_FK_GENERO_SEXUAL. '" size="1">';
    $arrayGenero = $generoSexualController->listar(Colunas::GENERO_SEXUAL);
    foreach ($arrayGenero as $linha) {
        if ($linha[Colunas::GENERO_SEXUAL_NOME] != 'GENERO_SEXUAL_ANONIMO') {
            $conteudo .= '<option value="' . $linha[Colunas::GENERO_SEXUAL_ID] . '"';
            if ($linha[Colunas::GENERO_SEXUAL_ID] === $usuario->generoSexual->id) {
                $conteudo .= ' selected';
            }
            $conteudo .= '>' . $linha[Colunas::GENERO_SEXUAL_NOME] . '</option>';
        }
    }
    $conteudo .= '</select>
        </div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar">
        </div>
            
        <div hidden>
            <input type="text" name="' . Colunas::USUARIO_ID . '" value="' . $usuario->id . '">
        </div>
    </fieldset>
</form>';
            
    return $conteudo;
}

function ajustarPermissao($administrador) {
    if ($administrador) {
        return 'SIM';
    }
    else {
        return 'NÃO';
    }
}