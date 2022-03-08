<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Filecategory;

class FilecategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Filecategory::create(
        [
            'name' => 'SK',
            'is_public' => true,
            'user_id' => '1',
        ]);
        Filecategory::create(
        [
            'name' => 'KTP',
            'is_public' => false,
            'user_id' => '1',
        ]);
        Filecategory::create(
        [
            'name' => 'Akta Lahir',
            'is_public' => false,
            'user_id' => '2',
        ]);
        Filecategory::create(
            [
                'name' => 'SPPD',
                'is_public' => true,
                'user_id' => '2',
            ]);
        Filecategory::create(
            [
                'name' => 'Apa Bae',
                'is_public' => true,
                'user_id' => '3',
            ]);
        Filecategory::create(
            [
                'name' => 'Pujare',
                'is_public' => false,
                'user_id' => '3',
            ]);
        Filecategory::create(
            [
                'name' => 'Ya Los',
                'is_public' => true,
                'user_id' => '4',
            ]);
        Filecategory::create(
            [
                'name' => 'Ya Ora Weruh',
                'is_public' => false,
                'user_id' => '4',
            ]);
    }
}
