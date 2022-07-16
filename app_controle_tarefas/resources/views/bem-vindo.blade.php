Site da aplicação

@auth
    <h1>Usuário autenticado</h1>
    <p>ID :{{ Atuh::user()->id }}</p>
    <p>Nome:{{ Atuh::user()->name }}</p>
    <p>E-mail: {{ Atuh::user()->email }}</p>
@endauth

@guest 
<p>Olá visitante tudo bem?</p>
@endguest