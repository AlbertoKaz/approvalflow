<?php

namespace Database\Seeders;

use App\Models\ApprovalRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        User::factory(4)->create();

        ApprovalRequest::factory(6)->pending()->create();
        ApprovalRequest::factory(8)->approved()->create();
        ApprovalRequest::factory(4)->rejected()->create();
    }
}
