<?php

require_once 'entity/usuarioModel.php';
require_once 'usuarioFormulario.php';

$usuario = Usuario::getNullObject();

echo construirFormulario($usuario);