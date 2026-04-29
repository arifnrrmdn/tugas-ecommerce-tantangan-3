<?php

namespace Database\Factories;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_produk' => fake()->firstName(),
            'kategori_produk' => fake()->randomElement(['Baju', 'Celana', 'Sepatu']),
            'stok' => fake()->randomNumber(2),
            'harga_produk' => fake()->numberBetween(10000, 100000)
        ];
    }
}
