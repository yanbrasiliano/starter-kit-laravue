<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThematicAreaSeeder extends Seeder
{
    public function run()
    {
        $thematicAreas = [
            [
                'description' => 'Administração',
            ],
            [
                'description' => 'Comunicação',
            ],
            [
                'description' => 'Contábeis',
            ],
            [
                'description' => 'Cultura e Artes',
            ],
            [
                'description' => 'Direitos Humanos e Justiça',
            ],
            [
                'description' => 'Economia',
            ],
            [
                'description' => 'Educação',
            ],
            [
                'description' => 'Meio Ambiente',
            ],
            [
                'description' => 'Saúde',
            ],
            [
                'description' => 'Trabalho',
            ],
            [
                'description' => 'Tecnologia e Produção',
            ],
        ];

        foreach ($thematicAreas as $thematicArea) {
            DB::table('thematic_areas')
                ->updateOrInsert(
                    ['description' => $thematicArea['description']],
                    [
                        ...$thematicArea,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
        }
    }
}
