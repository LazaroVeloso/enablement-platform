@extends('layouts.app')

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Inicial</title>
</head>
<body>

<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <span class="fs-4">Sidebar</span>
    </a>

    <hr>

    <ul class="nav nav-pills flex-column mb-auto">

        <li>
            <a href="{{ route('users.index') }}">Usuários</a>
        </li>

        <li>
            <a href="{{ route('trilhas.index') }}">Trilhas</a>
        </li>

    </ul>

    <hr>


</div>
    
</body>
</html>