<?php

namespace Database\Factories;

use App\Models\BahanBaku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bahanbaku>
 */
class BahanbakuFactory extends Factory
{
    protected $model = BahanBaku::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->unique()->word() . ' ' . $this->faker->unique()->word(),
            'gambar' => 'default.jpg',
            'satuan' => $this->faker->randomNumber(2),
            'harga' => $this->faker->randomNumber(2),
            'stok' => $this->faker->randomNumber(2),
            'user_id' => 2,
        ];
    }

}
