<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(50)->create()->each(function ($user) {
            Task::factory(20)->create(['user_id' => $user->id]);
        });
    }
}