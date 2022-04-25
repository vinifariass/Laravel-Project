<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\SiteContato;


class SiteContatoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(Faker $faker)
    {
        return [
            'nome' => $faker->name,
            'telefones' =>$faker->tollFreePhoneNumber ,
            'email' => $faker->unique()->email,
            'motivo_contato' => $faker->numberBetween(1,3),
            'mensagem' => $faker->text(200)
        ];
    }
}
