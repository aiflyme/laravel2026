<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id'=> null,
            'review'=>fake()->paragraph(),
            'rating' => fake()->numberBetween(1,5),
            'created_at' => fake()->dateTimeBetween('-2 years'),
            'updated_at' => function(array $attributes){
                return fake()->dateTimeBetween($attributes['created_at']);
            },
        ];
    }

    public function goodRating()
    {
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(4,5)
            ];
        });
    }

    public function avgRating()
    {
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(2,4)
            ];
        });
    }

    public function badRating()
    {
        return $this->state(function(array $attributes){
            return [
                'rating' => fake()->numberBetween(1,2)
            ];
        });
    }
}
