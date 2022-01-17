<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->first_name = 'Admin';
        $user->last_name = 'User';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('123456');
        $user->language = 'en';
        $user->active = 1;
        $user->save();
    }
}
