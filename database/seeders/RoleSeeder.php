<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'ADMIN', 'slug' => 'admin', 'description' => 'System Administrator with full access', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'TEACHER', 'slug' => 'teacher', 'description' => 'School Teacher Access', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'STUDENT', 'slug' => 'student', 'description' => 'Student Access', 'is_default' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PARENT', 'slug' => 'parent', 'description' => 'Parent/Guardian Access', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

