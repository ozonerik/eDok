<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@test.id',
                'password' => Hash::make('12345678'),
            ]);
        $user->assignRole('admin');
        $user = User::create(
            [
                'name' => 'User',
                'email' => 'user@test.id',
                'password' => Hash::make('12345678'),
            ]);
        $user->assignRole('user');
        $user = User::create(
            [
                'name' => 'User 2',
                'email' => 'user2@test.id',
                'password' => Hash::make('12345678'),
            ]);
        $user->assignRole('user');
        $user = User::create(
            [
                'name' => 'Admin 2',
                'email' => 'admin2@test.id',
                'password' => Hash::make('12345678'),
            ]);
        $user->assignRole('admin');
    }
}
