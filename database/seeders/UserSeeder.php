<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'id' => Str::uuid(),
            'name' => 'ADMIN',
            'email' => 'hrengifo@unbcorp.cl',
            'telefono' => '3127271224',
            'is_active' => true,
            'password' => Hash::make('admin1234'), 
        ]);

        // Asignación del rol de admin
        $user->assignRole('admin');
    }
}
