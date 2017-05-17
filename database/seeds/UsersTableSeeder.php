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
        $data = [
            ['name' => 'Admin', 'email' => 'admin@example.com', 'group' => 'admin', 'password' => bcrypt('secret')],
        ];

        foreach ($data as $user) {
            factory(User::class)->create($user);
        }
    }
}
