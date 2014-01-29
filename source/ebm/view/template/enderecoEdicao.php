<?php

function construirFormulario($endereco) {
    $controller = new CidadeController();
    $conteudo = '<form class="ui form" action="enderecoView.php" method="POST">
    <fieldset class="ui form segment">
        <legend>Informações Gerais</legend>
        
        <div>
            <label>Bairro</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::ENDERECO_BAIRRO . '" value="' . $endereco->bairro . '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>CEP</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::ENDERECO_CEP
                    . '" value="' . $endereco->cep . '" maxlength="8">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Rua</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::ENDERECO_RUA . '" value="' . $endereco->rua . '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Número</label>
            <div class="ui left labeled icon input field">
                <input type="number" name="' . Colunas::ENDERECO_NUMERO . '" value="' . $endereco->numero . '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div>
            <label>Cidade</label>
            <div class="ui left labeled icon input field">
                <input type="text" name="' . Colunas::CIDADE_NOME
                    . '" value="' . $endereco->cidade->nome . '">
                <i class="map icon"></i>
                <div class="ui red corner label">
                    <i class="icon asterisk"></i>
                </div>
            </div>
        </div>
        
        <div class="ui segment">
            <i class="map icon"></i>
            <label>Unidade Federativa</label>
            <select name="' . Colunas::CIDADE_FK_UNIDADE_FEDERATIVA. '" size="1">';
    $array = $controller->listar(Colunas::UNIDADE_FEDERATIVA);
    foreach ($array as $linha) {
        if ($linha[Colunas::UNIDADE_FEDERATIVA_NOME] != 'UNIDADE_FEDERATIVA_ANONIMA') {
            $conteudo .= '<option value="' . $linha[Colunas::UNIDADE_FEDERATIVA_ID] . '"';
            if ($linha[Colunas::UNIDADE_FEDERATIVA_ID] === $endereco->cidade->unidadeFederativa->id) {
                $conteudo .= ' selected';
            }
            $conteudo .= '>' . $linha[Colunas::UNIDADE_FEDERATIVA_NOME] . '</option>';
        }
    }
    $conteudo .= '</select>
            <div class="ui red corner label">
                <i class="icon asterisk"></i>
            </div>
        </div>
        
        <div class="ui error message"></div>
        
        <div>
            <input type="submit" name="submeter" value="Salvar" class="ui black submit button small">
        </div>
            
        <div hidden>
            <input type="hidden" name="' . Colunas::ENDERECO_ID . '" value="' . $endereco->id . '">
        </div>
    </fieldset>
</form>
<script>
$(\'.ui.form\').form(
    {
        bairro: {
            identifier: "' . Colunas::ENDERECO_BAIRRO . '",
            rules: [
                {
                    type: "empty",
                    prompt: "O campo Bairro deve ser preenchido."
                }
          ]
        },
        cep: {
            identifier: "' . Colunas::ENDERECO_CEP . '",
            rules: [
                {
                    type: "empty",
                    prompt: "O campo CEP deve ser preenchido."
                },
                {
                    type: "length[8]",
                    prompt: "O campo CEP deve conter 8 dígitos (sem nenhuma pontuação)."
                }
          ]
        },
        rua: {
            identifier: "' . Colunas::ENDERECO_RUA . '",
            rules: [
                {
                    type: "empty",
                    prompt: "O campo Rua deve ser preenchido."
                }
          ]
        },
        numero: {
            identifier: "' . Colunas::ENDERECO_NUMERO . '",
            rules: [
                {
                    type: "empty",
                    prompt: "O campo Número deve ser preenchido."
                }
          ]
        },
        cidade: {
            identifier: "' . Colunas::CIDADE_NOME . '",
            rules: [
                {
                    type: "empty",
                    prompt: "O campo Cidade deve ser preenchido."
                }
          ]
        }
    }
);
</script>';
            
    return $conteudo;
}