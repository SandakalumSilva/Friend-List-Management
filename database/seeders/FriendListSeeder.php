<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\FriendList;

class FriendListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('friend_lists')->insert([
        //     'name' => Str::random(10),
        //     'email' => Str::random(10) . '@gmail.com',
        //     'user_id' => 1,
        //     'invitation_type' => 'confirmed',
        // ]);
        FriendList::factory()
            ->count(10)
            ->create();
    }
}
