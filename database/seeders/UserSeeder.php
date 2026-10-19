<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    private const RECORD_COUNT = 100_000;

    private const BATCH_SIZE = 100;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($created = 0; $created < self::RECORD_COUNT; $created += self::BATCH_SIZE) {
            $batchSize = min(self::BATCH_SIZE, self::RECORD_COUNT - $created);
            $timestamp = now();
            $users = User::factory()->count($batchSize)->make();
            $records = [];

            foreach ($users as $user) {
                $records[] = [
                    ...$user->getAttributes(),
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }

            DB::table('users')->insert($records);
        }

        $this->command?->info('Created '.number_format(self::RECORD_COUNT).' users in the users table.');
    }
}
