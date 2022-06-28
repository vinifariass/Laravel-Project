@extends('app.layouts.basico')

@section('titulo', 'Produto')

@section('conteudo')
    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Adicionar Produto</p>
        </div>
        <div class="menu">
            <ul>
                <li><a href="{{ route('produto.index') }}">Voltar</a></li>
                <li><a href="">Consulta</a></li>
            </ul>
        </div>
        <div class="informacao-pagina">
            {{ $msg ?? '' }}
            <div style="width:30%;margin-left:auto;margin-right:auto;">
                <form method="POST" action="{{ route('produto.store') }}">

                    @csrf
                    <input type="text" name="nome" placeholder="Nome" value="{{ old('nome') }}" class="borda-preta">
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                    <input type="text" name="descricao" value="{{ old('descricao') }} placeholder="Descrição"
                        class="borda-preta">
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}

                    <input type="text" name="peso" value="{{ old('nome') }} placeholder="peso" class="borda-preta">

                    {{ $errors->has('peso') ? $errors->first('peso') : '' }}
                    <select name="unidade_id" id="unidade_id">
                        <option value="{{ old('peso') }}">-- Seleciona a Unidade de Media --</option>
                        @foreach ($unidade as $unidade)
                            <option value="{{ $unidade->id }}" {{ old('unidade_id') == $unidade->id ? 'selected' : '' }}>
                                {{ $unidade->descricao }}</option>
                        @endforeach
                    </select>
                    {{ $errors->has('unidade_id') ? $errors->first('unidade_id') : '' }}

                    <button type="submit" class="borda-preta">Cadastrar</button>


                </form>
            </div>
        </div>
    </div>
    {{-- o yield envia blocos para outras views --}}
@endsection
