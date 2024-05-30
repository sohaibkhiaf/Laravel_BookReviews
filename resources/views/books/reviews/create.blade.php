@extends('layouts.app')

@section('content')
  <h1>Add Review for {{ $book->title }}</h1>

  <form method="POST" action="{{ route('books.reviews.store', $book) }}">
    @csrf
    <label for="review">Review</label>
    <textarea name="review" id="review" required>{{ old('review') }}</textarea>

    <br>
    
    @error('review')
    {{ $message }}
    @enderror

    <br>

    <label for="rating">Rating</label>

    <select name="rating" id="rating" required>
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

    <button type="submit" class="btn">Add Review</button>
  </form>
@endsection