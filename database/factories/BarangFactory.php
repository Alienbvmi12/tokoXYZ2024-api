<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rate = fake()->randomNumber(3, true) / 100;
        return [
            'kode_barang' => fake()->numerify('BRG-####'),
            'nama_barang' => fake()->word(),
            'expired_date' => fake()->date(),
            'jumlah' => fake()->randomNumber(3, false),
            'harga' => fake()->randomNumber(5, false) * 100,
            'image' => fake()->randomElement(
                ['storage/image.png', 'storage/image2.jpg', 'storage/image3.jpg', 'storage/image4.jpg']
            ),
            'rating' => $rate > 5 ? $rate - 5 : $rate
        ];
    }
}
