@extends('app.layouts.basico')

@section('titulo', 'Pedido Produto')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Adicionar Produtos ao Pedido</p>
        </div>
        <div class="menu">
            <ul>
                <li><a href="{{ route('pedido.index') }}">Voltar</a></li>
                <li><a href="">Consulta</a></li>
            </ul>
        </div>
        <div class="informacao-pagina">
            {{ $msg ?? '' }}
            <h4>Detalhes do Pedido</h4>
            <p>ID do pediddo: {{ $pedido->id }}</p>
            <p>Cliente: {{ $pedido->cliente_id }}</p>
            <div style="width:30%;margin-left:auto;margin-right:auto;">
                @componet('app.pedido_produto._components.form_create',['pedido'=>$pedido,'produtos'=>$produtos])
            @endcomponent
        </div>
    </div>
</div>
{{-- o yield envia blocos para outras views --}}
@endsection
