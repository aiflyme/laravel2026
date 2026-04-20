<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(33)->create()->each(function($book){
            $numRandom = random_int(5,30);
            Review::factory()->count($numRandom)->goodRating()->for($book)->create();
        });

        Book::factory(33)->create()->each(function($book){
            $numRandom = random_int(5,30);
            Review::factory()->count($numRandom)->badRating()->for($book)->create();
        });

        Book::factory(33)->create()->each(function($book){
            $numRandom = random_int(5,30);
            Review::factory()->count($numRandom)->avgRating()->for($book)->create();
        });
    }
}
