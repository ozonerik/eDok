<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Sendfile;

class SendfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sendfile::create([
            'sendkey' => Str::random(30),
            'myfile_id' => '1',
            'user_id' => '2'
        ]);
        Sendfile::create([
            'sendkey' => Str::random(30),
            'myfile_id' => '2',
            'user_id' => '2'
        ]);
        Sendfile::create([
            'sendkey' => Str::random(30),
            'myfile_id' => '3',
            'user_id' => '1'
        ]);
        Sendfile::create([
            'sendkey' => Str::random(30),
            'myfile_id' => '4',
            'user_id' => '1'
        ]);
    }
}
