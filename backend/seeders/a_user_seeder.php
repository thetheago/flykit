<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;

use App\Model\User;

class AUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = password_hash('123456', PASSWORD_BCRYPT);

        User::create([
            'email' => 'admin@admin.com',
            'password' => $password,
            'is_admin' => true,
        ]);

        User::create([
            'email' => 'jotaro@kutcho.com',
            'password' => $password,
            'is_admin' => false,
        ]);

        User::create([
            'email' => 'tim@henson.com',
            'password' => $password,
            'is_admin' => false,
        ]);
    }
}
