<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Book;

class ReviewController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('throttle:reviews')->only(['store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

 
    public function create(Book $book)
    {
        return view('books.reviews.create' , ['book' => $book]);
    }


    public function store(Request $request , Book $book)
    {
        // validate data
        $data = $request->validate([
            'review' => 'required|min:5',
            'rating' => 'required|min:1|max:5|integer'
        ]);
 
        // create review for the book
        $book->reviews()->create($data);

        return redirect()->route('books.show' , ['book' => $book]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
