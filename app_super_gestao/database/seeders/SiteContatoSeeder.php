<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;

class SiteContatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $contato = new SiteContato();
        // $contato->nome = 'Vinicius Farias';
        // $contato->email = 'vinicius@gmail.com';
        // $contato->nome = 'Vinicius Farias';
        // $contato->telefone = '(11)99999-8888';
        // $contato->site_contato = 1;
        // $contato->mensagem = 'Seja bem-vindo ao sistema Super Gestão';
        // $contato->save();

        Factory(SiteContatoFactory::class,100)->create();

    }
}
