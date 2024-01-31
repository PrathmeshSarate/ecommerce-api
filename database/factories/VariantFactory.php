<?php

namespace Database\Factories;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Variant::class;
    
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'sku' => $this->faker->unique()->word,
            'additional_cost' => $this->faker->randomFloat(2, 0, 100),
            'stock_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}
