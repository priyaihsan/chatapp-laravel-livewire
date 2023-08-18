<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Message::create([
            'user_id' => 1,
            'conversation_id' => 1,
            'is_read' => true, // tambahkan ini untuk menandakan pesan sudah dibaca
            'message' => 'Hello',
        ]);

        Message::create([
            'user_id' => 2,
            'conversation_id' => 1,
            'is_read' => true, // tambahkan ini untuk menandakan pesan sudah dibaca
            'message' => 'Hello too',
        ]);
    }
}
