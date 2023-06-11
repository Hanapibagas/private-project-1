<?php

namespace Database\Seeders;

use App\Models\BahanBaku;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BahanbakuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BahanBaku::factory()->count(20)->create();
    }
}
