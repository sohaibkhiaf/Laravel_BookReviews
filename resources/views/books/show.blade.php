@extends('layouts.app')

@section('content')
  <div>
    <h1>{{ $book->title }}</h1>

    <div class="book-info">
      <div class="book-author">by {{ $book->author }}</div>
      <div class="book-rating">
        <div>
          {{ number_format($book->reviews_avg_rating, 1) }}
          <x-star-rating rating="{{ round($book->reviews_avg_rating) }}" />
        </div>
        <span class="book-review-count">
          {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
        </span>
      </div>
    </div>
  </div>

  <div>
    <a href="{{ route('books.reviews.create' , ['book' => $book]) }}">Add a review!</a>
  </div>

  <div>
    <h2>Reviews</h2>
    <ul>
      @forelse ($book->reviews as $review)
        <li class="book-item">
          <div>
            <div>
              <div>
                <x-star-rating rating="{{ round($review->rating) }}" />  
              </div>
              <div class="book-review-count">
                {{ $review->created_at->format('M j, Y') }}</div>
            </div>
            <p>{{ $review->review }}</p>
          </div>
        </li>
      @empty
        <li>
          <div class="empty-book-item">
            <p class="empty-text">No reviews yet</p>
          </div>
        </li>
      @endforelse
    </ul>
  </div>
@endsection