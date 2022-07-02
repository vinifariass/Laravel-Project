<form method="POST" action="{{ route('produto.update', ['produto' => $produto->id]) }}">

    @csrf
    @method('PUT')
    <input type="text" name="nome" placeholder="Nome" value="{{ $produto->nome ?? old('nome') }}"
        class="borda-preta">
    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
    <input type="text" name="descricao" value="{{ $produto->descricao ?? old('descricao') }} placeholder="Descrição"
        class="borda-preta">
    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}

    <input type="text" name="peso" value="{{ $produto->peso ?? old('peso') }} placeholder="peso"
        class="borda-preta">

    {{ $errors->has('peso') ? $errors->first('peso') : '' }}
    <select name="unidade_id" id="unidade_id">
        <option value="{{ old('peso') }}">-- Seleciona a Unidade de Media --</option>
        @foreach ($unidade as $unidade)
            <option value="{{ $unidade->id }}"
                {{ $produto->unidade_id ?? old('unidade_id') == $unidade->id ? 'selected' : '' }}>
                {{ $unidade->descricao }}</option>
        @endforeach
    </select>
    {{ $errors->has('unidade_id') ? $errors->first('unidade_id') : '' }}

    <button type="submit" class="borda-preta">Cadastrar</button>


</form>
