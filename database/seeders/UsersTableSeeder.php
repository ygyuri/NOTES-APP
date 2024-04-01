<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()
        ->count(10)
        ->hasNotes(6)
        ->create();
        User::factory()
        ->count(5)
        ->hasNotes(10)
        ->create();
        User::factory()
        ->count(2)
        ->hasNotes(13)
        ->create();
        User::factory()
        ->count(6)
        ->hasNotes(0)
        ->create();
    }
}
