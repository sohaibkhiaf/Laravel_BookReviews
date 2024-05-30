<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(Request $request)
    {
        // receive parameters , GET method
        $title = $request->input("title");
        $filter = $request->input("filter" , "");  // default is empty

        // search books by title
        $books = Book::when($title , fn ($query , $title) => $query->title($title) );

        // apply filters on searched books by title
        $books = match($filter) {
            "popular_last_month" => $books->popularLastMonth(),
            "popular_last_6months" => $books->popularLast6Months(),
            "highest_rated_last_month" => $books->highestRatedLastMonth(),
            "highest_rated_last_6months" => $books->highestRatedLast6Months(),
            default => $books->latest()->withReviewsCount()->withAvgRating()
        };
        
        // create cache for current data
        $cacheKey = "books_". $title ."_". $filter;

        // cache()->forget($cacheKey);  // line to be removed / for testing purposes only

        // save in cache if not saved / fetch data saved if already exists
        $books = cache()->remember($cacheKey , 3600 , fn() => $books->get());

        return view('books.index' , ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function show(Book $book)
    {
        // create cache for current book
        $cacheKey = 'book_'.$book->id;
        
        // cache()->forget($cacheKey); // line to be deleted / for testing purposes only

        // save in cache if not saved / fetch data saved if already exists
        $book = cache()->remember($cacheKey , 3600 , fn() => Book::with([
            'reviews' => fn($query) => $query->latest()
        ])->withReviewsCount()->withAvgRating()->findOrFail($book->id));

        return view('books.show' , ['book' => $book ] );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
