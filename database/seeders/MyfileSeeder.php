<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Myfile;

class MyfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Myfile::create([
            'name' => 'File SK',
            'is_pinned' => true,
            'path' => 'samplepdf.pdf',
            'file_size' => '0',
            'is_public' => true,
            'filecategory_id' => '1',
            'user_id' => '1',
        ]);
        Myfile::create([
            'name' => 'File KTP',
            'is_pinned' => false,
            'path' => 'samplepdf.pdf',
            'file_size' => '0',
            'is_public' => false,
            'filecategory_id' => '2',
            'user_id' => '1',
        ]);
        Myfile::create([
            'name' => 'File Akta Lahir',
            'is_pinned' => false,
            'path' => 'samplepdf.pdf',
            'file_size' => '0',
            'is_public' => false,
            'filecategory_id' => '3',
            'user_id' => '2',
        ]);
        Myfile::create([
            'name' => 'File SPPD',
            'is_pinned' => true,
            'path' => 'samplepdf.pdf',
            'file_size' => '0',
            'is_public' => true,
            'filecategory_id' => '4',
            'user_id' => '2',
        ]);
    }
}
