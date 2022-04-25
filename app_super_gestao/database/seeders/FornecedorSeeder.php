<?php

namespace Database\Seeders;

use App\Models\Fornecedor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FornecedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fornecedor = new Fornecedor();
        $fornecedor->nome = 'Fornecedor 100';
        $fornecedor->site = 'fornecedor100.com.br';
        $fornecedor->uf = 'CE';
        $fornecedor->email = 'forenecedor100@gmail.com.br';
        $fornecedor->save();

        fornecedor::create(['nome' => 'Fornecedor 200', 'site' => 'fornecedor200.com.br','uf' => 'RS', 'email' => 'forenecedor@gmail.com.br']);
   

    DB::table('fornecedores')->insert([
        ['nome' => 'Fornecedor 300', 'site' => 'fornecedor300.com.br','uf' => 'SP', 'email' => 'forenecedor300@gmail.com.br']
    ]);
}
}
