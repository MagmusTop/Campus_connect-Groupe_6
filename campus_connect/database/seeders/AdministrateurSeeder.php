<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdministrateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $administrateur = new User;
        $administrateur->nom = 'Ahd';
        $administrateur->prenom = 'Mag';
        $administrateur->role_id = Role::where('nom', 'administrateur')->first()->id;
        $administrateur->email = 'admin@mail.mag';
        $administrateur->password = Hash::make('Admin@123');
        $administrateur->save();

    }
}
