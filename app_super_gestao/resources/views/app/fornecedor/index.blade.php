<h3>Fornecedor</h3>

{{-- Fica o comentário que está sendo descartado pelo interpretador --}}
@php

@endphp

@isset($fornecedores)
    Fornecedor: {{ $fornecedores[0]['nome'] }}
    <br>
    Status: {{ $fornecedores[0]['status'] }}
    <br>
        CNPJ: {{ $fornecedores[0]['cnpj'] ?? 'Dado não foi preenchido'}}
@endisset
