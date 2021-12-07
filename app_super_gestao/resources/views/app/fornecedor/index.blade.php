<h3>Fornecedor</h3>

{{-- Fica o comentário que está sendo descartado pelo interpretador --}}
@php

@endphp

@isset($fornecedores)
    @forelse ($fornecedores as $indice => $fornecedor)


        Iteração atual: {{ $loop->iteration }}
        <br>
        Fornecedor: {{ $fornecedor['nome'] }}
        <br>
        Status: {{ $fornecedor['status'] }}
        <br>
        CNPJ: {{ $fornecedor['cnpj'] ?? 'Dado não foi preenchido' }}
        <br>
        Telefone: ({{ $fornecedor['ddd'] ?? '' }}) {{ $fornecedor['telefone'] ?? '' }}
        <br>
        @if ($loop->first)
            Primeira iteração do loop
        @endif

        @if ($loop->last)
            Ultima iteração do loop

            <br>

            Total de registros: {{ $loop->count }}

        @endif
        <hr>
    @empty
        Não existem fornecedores cadastrados!
    @endforelse

@endisset
