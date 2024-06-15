<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            [
                'id' => 1,
                'label' => 'Chauffeur',
                'slug' => Str::slug('Chauffeur')
            ],
            [
                'id' => 2,
                'label' => 'Client',
                'slug' => Str::slug('Client')
            ]
        ];

        DB::table('roles')->insert($roles);

    }
}
