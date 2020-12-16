<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $user = [
            [
                'name' => 'Admin',
                'email' => 'info@user.com',
                'password' => bcrypt('secret'),
                'role' => 'super-admin',
                'is_published' => '1',
            ],
        ];

        User::insert($user);
    }
}
