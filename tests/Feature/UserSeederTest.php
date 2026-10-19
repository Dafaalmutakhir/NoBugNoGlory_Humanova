<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_at_least_one_hundred_thousand_users_with_unique_emails(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(100_000, DB::table('users')->count());
        $this->assertSame(100_000, DB::table('users')->distinct()->count('email'));
        $this->assertSame(0, DB::table('users')->whereNull('name')->count());
        $this->assertSame(0, DB::table('users')->whereNull('password')->count());
    }
}
