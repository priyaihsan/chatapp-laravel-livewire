<?php

namespace Database\Seeders;

use App\Models\Partisipant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartisipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Partisipant::create([
            'user_id' => 1,
            'conversation_id' => 1,
        ]);

        Partisipant::create([
            'user_id' => 2,
            'conversation_id' => 1,
        ]);

        Partisipant::create([
            'user_id' => 3,
            'conversation_id' => 2,
        ]);

        Partisipant::create([
            'user_id' => 1,
            'conversation_id' => 2,
        ]);
    }
}
