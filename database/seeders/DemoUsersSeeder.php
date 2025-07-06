<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Author;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo customer
        Customer::updateOrCreate(
            ['email' => 'test@email.tld'],
            [
                'name' => 'Demo Customer',
                'email' => 'test@email.tld',
                'password' => Hash::make('test1234'),
                'phone' => '+1234567890',
                'address' => '123 Demo Street, Demo City, DC 12345',
                'is_active' => true,
            ]
        );

        // Create demo author
        Author::updateOrCreate(
            ['email' => 'test@email.tld'],
            [
                'name' => 'Demo Author',
                'email' => 'test@email.tld',
                'password' => Hash::make('test1234'),
                'bio' => 'A demonstration author account for testing purposes.',
                'website' => 'https://demo-author.example.com',
                'phone' => '+1234567890',
                'is_active' => true,
            ]
        );

        $this->command->info('Demo users created successfully!');
        $this->command->info('Customer: test@email.tld / test1234');
        $this->command->info('Author: test@email.tld / test1234');
    }
}
