<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotivoContato;

class MotivoContatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MotivoContato::create9(['motivo_contatos'=>'Dívida']);
        MotivoContato::create9(['motivo_contatos'=>'Elogio']);
        MotivoContato::create9(['motivo_contatos'=>'Reclamação']);
    }
}
