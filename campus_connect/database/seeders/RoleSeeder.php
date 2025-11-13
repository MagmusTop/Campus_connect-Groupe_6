<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
/**
 * RoleSeeder
 */
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Example roles
        $roles = [
            [
                'name' => 'administrateur'
            ],
            [
                'name'=> 'etudiant'
            ],
            [
                'name'=> 'enseignant'
            ]

        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
