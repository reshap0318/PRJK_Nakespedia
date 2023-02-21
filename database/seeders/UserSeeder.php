<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'      => 'super admin',
                'username'  => 'su@dmin',
                'email'     => 'suadmin@admin.com',
                'password'  => "su@dmin",
                'role'      => 1
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
