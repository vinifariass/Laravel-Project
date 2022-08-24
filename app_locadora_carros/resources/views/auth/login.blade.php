@extends('layouts.app')

@section('content')
    @csrf
    {{-- pega o token hidden --}}
    {{-- recupera apenas o valor para criar o input dentro do component --}}
    <login-component csrf_token="{{ @csrf_token() }}"></login-component>
@endsection
