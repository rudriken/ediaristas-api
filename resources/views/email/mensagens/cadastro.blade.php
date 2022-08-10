@extends('email.layout')

@section('título', "Seja bem vindo(a) ao E-diaristas")

@section('conteúdo')
    <p style="margin: 0 0 16px;">
        Olá {{ $usuário->nome_completo }}, seja bem-vindo(a) ao E-diaristas!
    </p>
    @if ($usuário->tipo_usuario == 1)
        <p style="margin: 0 0 16px;">
            Seja bem-vindo como cliente do E-diarsitas.
        </p>
        <p style="margin: 0 0 16px;">
            Aqui você poderá encontrar os melhores e as melhores profissionais do mercado!!
        </p>
    @else
        <p style="margin: 0 0 16px;">
            Fique ligado, assim que tivermos uma diária na sua região, te avisaremos!
        </p>
        <p style="margin: 0 0 16px;">
            Você poderá escolher e se candidatar a quantas diárias achar necessário.
        </p>
    @endif
@endsection
