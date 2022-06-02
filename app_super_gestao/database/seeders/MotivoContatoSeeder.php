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
        MotivoContato::create(['motivo_contatos'=>'Dúvida']);
        MotivoContato::create(['motivo_contatos'=>'Elogio']);
        MotivoContato::create(['motivo_contatos'=>'Reclamação']);
    }
}
