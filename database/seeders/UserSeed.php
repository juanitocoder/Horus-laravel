<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    public function run(): void
    {
        // Primero los roles
        Role::insert([
            ['id' => 1, 'name' => 'admin'],
            ['id' => 2, 'name' => 'user'],
            ['id' => 3, 'name' => 'superadmin'],
        ]);

        // Luego los usuarios
        $user = new User();
        $user->name = "Jhoana";
        $user->email = "yumi@gmail.com";
        $user->password = bcrypt("yumi1234");
        $user->role_id = 3; // Este es el ID del rol 'user'
        $user->save();
        
        $user = new User();
        $user->name = "Juan";
        $user->email = "bjuan560@gmail.com";
        $user->password = bcrypt("12345678");
        $user->role_id = 1; // Este es el ID del rol 'user'
        $user->save();

        $user = new User();
        $user->name = "ruan";
        $user->email = "yuan560@gmail.com";
        $user->password = bcrypt("12345678");
        $user->role_id = 2; // También rol 'user'
        $user->save();
    }
}

