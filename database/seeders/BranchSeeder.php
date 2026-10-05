<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'Main Campus',
            'is_active' => true,
        ]);

        Branch::create([
            'name' => 'City Campus',
            'is_active' => true,
        ]);

        Branch::create([
            'name' => 'Model Town Campus',
            'is_active' => true,
        ]);
    }
}