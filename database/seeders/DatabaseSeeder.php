<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Review;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(25)->create()->each(function($book){
            $reviews_number = random_int(6, 30);

            Review::factory()->count($reviews_number)
                ->good()
                ->for($book)
                ->create();
        });

    }
}
