@extends('layouts.app')

@section('content')
    <h1 class="app-header">{{ $book->title }}</h1>

    <div class="book-info-container">
        
        <div class="book-author">By "{{ $book->author }}"</div>

        <div class="rating-and-count">
            <div>
                <x-star-rating rating="{{ round($book->reviews_avg_rating) }}" />
                <span>
                    out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                </span>
            </div>

            <div>
                <a class="add-review" href="{{ route('books.reviews.create' , ['book' => $book]) }}">Add a review!</a>
            </div>

        </div>
    </div>

    <div class="book-reviews-container">
        <h2 class="reviews-header">Reviews</h2>
        <ul class="reviews-list">
            @forelse ($book->reviews as $review)
                <li class="review-list-item">
                    <div class="review-container">
                        <div>
                            <div class="rating">
                                <x-star-rating rating="{{ round($review->rating) }}" />  
                            </div>
                            <div>
                                {{ $review->created_at->format('M j, Y') }}
                            </div>
                        </div>
                        <p>{{ $review->review }}</p>
                    </div>
                </li>
            @empty
                <li class="no-reviews-item">
                    <div class="no-reviews-container">
                        <p class="no-reviews">No reviews yet</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
@endsection