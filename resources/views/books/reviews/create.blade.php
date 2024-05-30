@extends('layouts.app')

@section('content')
    <h1 class="app-header">Add Review for {{ $book->title }}</h1>

    <form class="review-form" method="POST" action="{{ route('books.reviews.store', $book) }}">
        @csrf

        <label class="review-label" for="review">Review</label>
        <textarea class="review-text" name="review" id="review" rows="6" required>{{ old('review') }}</textarea>

        <br>

        @error('review')
            {{ $message }}
        @enderror

        <br>

        <label class="rating-label" for="rating">Rating</label>

        <select class="rating-select" name="rating" id="rating" required>
            <option value="">Select a Rating</option>
            @for ($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>

        <br>

        @error('rating')
            {{ $message }}
        @enderror

        <br>

        <button class="add-review" type="submit">Add Review</button>
    </form>
@endsection