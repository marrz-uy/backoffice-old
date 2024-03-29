<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class PuntoDeInteresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($c = 0; $c < 10; $c++)
            DB::table('puntosinteres')->insert([
                'Nombre' => Str::random(10),
                'Departamento' => Str::random(10),
                'Ciudad' => Str::random(10),
                'Direccion' => Str::random(10),
                'Descripcion' => Str::random(10),
                'Imagen' => Str::random(10) . ".jpg",
            ]);
    }
}
