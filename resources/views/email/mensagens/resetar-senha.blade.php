@extends('email.layout')

@section('titulo', 'Notificação de redefinição de senha!')

@section('conteudo')
    <p style="margin:0 0 16px">
        Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.
    </p>

    <p>
        <a
            href="{{ $url }}"
            class="m_-7707229415481028427button"
            rel="noopener"
            style="
                box-sizing:border-box;
                font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
                border-radius:4px;
                color:#fff;
                display:inline-block;
                overflow:hidden;
                text-decoration:none;
                background-color:#2d3748;
                border-bottom:8px solid #2d3748;
                border-left:18px solid #2d3748;
                border-right:18px solid #2d3748;
                border-top:8px solid #2d3748
            "
            target="_blank"
        >
            Modificar Senha
        </a>
    </p>

    <p style="margin:0 0 16px">
        Se você não solicitou a redefinição de senha, nenhuma ação adicional será necessária.
    </p>

@endsection
