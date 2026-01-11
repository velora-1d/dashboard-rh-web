<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default users for testing
        $users = [
            [
                'name' => 'Admin Riyadlul Huda',
                'email' => 'admin@riyadlulhuda.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Staff Pendidikan',
                'email' => 'pendidikan@riyadlulhuda.com',
                'password' => Hash::make('password'),
                'role' => 'pendidikan',
            ],
            [
                'name' => 'Staff Sekretaris',
                'email' => 'sekretaris@riyadlulhuda.com',
                'password' => Hash::make('password'),
                'role' => 'sekretaris',
            ],
            [
                'name' => 'Staff Bendahara',
                'email' => 'bendahara@riyadlulhuda.com',
                'password' => Hash::make('password'),
                'role' => 'bendahara',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('✅ Default users created successfully!');
        $this->command->info('📧 Email: admin@riyadlulhuda.com | Password: password');
        $this->command->info('📧 Email: pendidikan@riyadlulhuda.com | Password: password');
        $this->command->info('📧 Email: sekretaris@riyadlulhuda.com | Password: password');
        $this->command->info('📧 Email: bendahara@riyadlulhuda.com | Password: password');
    }
}
