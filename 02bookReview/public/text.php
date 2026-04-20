<?php

use \App\Models\Book;

return \App\Models\Book::with('reviews')->first();

return \App\Models\Book::where('title', 'LIKE', 'Et%')->get();


return \App\Models\Book::title('Et%')->get();

return \App\Models\Book::withCount('reviews')->limit(3)->latest()->get();


return \App\Models\Book::withAvg('reviews','rating')->tosql();

return \App\Models\Book::withCount('reviews')
    ->withAvg('reviews', 'rating')
    ->get()
    ->filter(fn($book) => $book->reviews_count >= 10)
    ->sortByDesc('reviews_avg_rating')
    ->values();

$book6 = \App\Models\Book::withCount('reviews')
    ->withAvg('reviews', 'rating')
    ->groupBy('books.id')
    ->havingRaw('(SELECT COUNT(*) FROM "reviews" WHERE "books"."id" = "reviews"."book_id") >= ?', [10])
    ->orderBy('reviews_avg_rating', 'desc')
    ->tosql();
return $book6;

return \App\Models\Book::withCount('reviews')->orderbY('reviews_count', 'desc');

return \App\Models\Book::popular()->highestRated()->get();
