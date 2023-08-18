<?php

namespace Database\Seeders;

use App\Models\Conversation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Conversation::create([
            'name' => '1 with 2',
        ]);


        Conversation::create([
            'name' => '1 with 3',
        ]);
    }
}
