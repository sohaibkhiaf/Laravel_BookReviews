@extends('layouts.app')

@section('content')
    <h1 class="app-header">Add Review for {{ $book->title }}</h1>

    <form class="review-form" method="POST" action="{{ route('books.reviews.store', $book) }}">
        @csrf

        <label class="review-label" for="review">Review</label>
        <textarea class="review-text" name="review" id="review" rows="6" >{{ old('review') }}</textarea>

        <br>

        @error('review')
            <div class="error-message">
                {{ $message }}
            </div>
        @enderror

        <br>

        <label class="rating-label" for="rating">Rating</label>

        <select class="rating-select" name="rating" id="rating" >
            <option value="">Select a Rating</option>
            @for ($i = 1; $i <= 5; $i++)
                @if ( old('rating') == $i )
                    <option value="{{ $i }}" selected>{{ $i }}</option>
                @else
                    <option value="{{ $i }}" >{{ $i }}</option>
                @endif
            @endfor
        </select>

        <br>

        @error('rating')
            <div class="error-message">
                {{ $message }}
            </div>
        @enderror

        <br>

        <button class="add-review" type="submit">Add Review</button>
    </form>
@endsection