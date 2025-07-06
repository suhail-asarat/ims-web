<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Author;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Create sample customers
        Customer::create([
            'name' => 'Tester',
            'email' => 'test@email.tld',
            'password' => bcrypt('test1234'),
            'phone' => '+8801234567890',
            'address' => 'Dumki, Patuakhali, Bangladesh',
        ]);

        Customer::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password123'),
            'phone' => '+8801234567890',
            'address' => '123 Main Street, Dhaka, Bangladesh',
        ]);

        Customer::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => bcrypt('password123'),
            'phone' => '+8809876543210',
            'address' => '456 Oak Avenue, Chittagong, Bangladesh',
        ]);

        Customer::create([
            'name' => 'Ahmed Rahman',
            'email' => 'ahmed.rahman@example.com',
            'password' => bcrypt('password123'),
            'phone' => '+8801122334455',
            'address' => '789 Rose Road, Sylhet, Bangladesh',
        ]);

        // Create sample authors
        Author::create([
            'name' => 'Tester',
            'email' => 'test@email.tld',
            'password' => bcrypt('test1234'),
            'bio' => 'This is a test author.',
            'phone' => '+8801234567890',
        ]);

        Author::create([
            'name' => 'Harper Lee',
            'email' => 'harper.lee@example.com',
            'password' => bcrypt('password123'),
            'bio' => 'American novelist best known for her 1960 novel To Kill a Mockingbird.',
            'phone' => '+1234567890',
        ]);

        Author::create([
            'name' => 'Paulo Coelho',
            'email' => 'paulo.coelho@example.com',
            'password' => bcrypt('password123'),
            'bio' => 'Brazilian lyricist and novelist, best known for his novel The Alchemist.',
            'website' => 'https://paulocoelho.com',
            'phone' => '+5511999999999',
        ]);

        Author::create([
            'name' => 'J. K. Rowling',
            'email' => 'jk.rowling@example.com',
            'password' => bcrypt('password123'),
            'bio' => 'British author, best known for the Harry Potter series.',
            'website' => 'https://jkrowling.com',
            'phone' => '+44123456789',
        ]);

        // Run the BookSeeder
        $this->call([
            BookSeeder::class,
        ]);
    }
}
